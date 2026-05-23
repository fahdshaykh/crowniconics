<?php

namespace App\Http\Controllers;

use App\Enums\BooleanEnum;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;
use Nnjeim\World\Models\City;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(10);
        return view('dashboard.pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User();
        $roles = Role::all();
        $countries = Country::orderBy('name')->get();
        $services = Service::all();
        
        // Set default values for selection
        $selectedCountry = old('country_id');
        $selectedState = old('state_id');
        $selectedCity = old('city_id');
        
        return view('dashboard.pages.users.create', compact(
            'user',
            'roles', 
            'countries', 
            'selectedCountry', 
            'selectedState', 
            'selectedCity',
            'services'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
                'phone' => 'nullable|string|max:20',
                'password' => 'required|string|min:8|confirmed',
                'country_id' => 'nullable|exists:countries,id',
                'city_id' => 'nullable|exists:cities,id',
                'state_id' => 'nullable|exists:states,id',
                'zip_code' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'role' => 'required|exists:roles,name',
                'status' => 'required|in:active,inactive,pending',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];

            if ($request->role === 'professional') {
                $rules['service_id'] = 'required|exists:services,id';
                $rules['price'] = 'required|numeric|min:0';
                $rules['experience_years'] = 'required|integer|min:0';
                $rules['personal_information'] = 'required|string';
            }

            $request->validate($rules);

            $data = $request->only([
                'first_name', 'last_name', 'email', 'phone',
                'country_id', 'state_id', 'city_id', 'zip_code', 'address', 'status'
            ]);
            $data['name'] = $request->first_name . ' ' . $request->last_name;
            $data['password'] = Hash::make($request->password);

            if ($request->hasFile('profile_image')) {
                $imagePath = $request->file('profile_image')->store('users/profile-images', 'public');
                $data['profile_image'] = $imagePath;
            }

            $user = User::create($data);

            if ($request->role === 'professional' && $request->filled('service_id')) {
                $user->services()->sync([
                    $request->service_id => [
                        'price' => $request->price,
                        'experience_years' => $request->experience_years,
                        'personal_information' => $request->personal_information,
                        'status' => 'active',
                    ]
                ]);
            }

            $role = Role::where('name', $request->role)->first();
            if ($role) {
                $user->assignRole($role);
            }

            return $this->redirectWithSuccess('User created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->redirectWithError('Error updating user: ' . $e->getMessage());
            // dd($e->errors()); // Debug validation errors
        } catch (\Exception $e) {
            return $this->redirectWithError('Error updating user: ' . $e->getMessage());
            // dd('Non-validation error: ' . $e->getMessage()); // Debug other errors
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        return view('dashboard.pages.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('roles', 'services')->findOrFail($id);
        $roles = Role::all();
        $countries = Country::orderBy('name')->get();
        $services = Service::all();

        $states = [];
        $cities = [];

        if ($user->country) {
            $countryId = Country::where('name', $user->country)->value('id');
            $states = State::where('country_id', $countryId)->orderBy('name')->get();
        }

        if ($user->state) {
            $stateId = State::where('name', $user->state)->value('id');
            $cities = City::where('state_id', $stateId)->orderBy('name')->get();
        }

        return view('dashboard.pages.users.edit', compact(
            'user', 'roles', 'countries', 'states', 'cities', 'services'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        try {
            $user = User::findOrFail($id);

            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'phone' => 'nullable|string|max:20',
                'password' => 'nullable|string|min:8|confirmed',
                'country_id' => 'nullable|string|max:255',
                'city_id' => 'nullable|string|max:255',
                'state_id' => 'nullable|string|max:255',
                'zip_code' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'role' => 'required|exists:roles,name',
                'status' => 'required|in:active,inactive,pending',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $data = $request->all();
            $data['name'] = $request->first_name . ' ' . $request->last_name;

            // Handle password update
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            } else {
                unset($data['password']);
            }

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                // Delete old image if exists
                if ($user->profile_image) {
                    Storage::disk('public')->delete($user->profile_image);
                }
                $imagePath = $request->file('profile_image')->store('users/profile-images', 'public');
                $data['profile_image'] = $imagePath;
            }

            $user->update($data);

            if ($request->role === 'professional' && $request->filled('service_id')) {
                $user->services()->sync([
                    $request->service_id => [
                        'price' => $request->price,
                        'experience_years' => $request->experience_years,
                        'personal_information' => $request->personal_information,
                        'status' => 'active',
                    ]
                ]);
            }

            // Update role using Spatie
            $role = Role::where('name', $request->role)->first();
            if ($role) {
                $user->syncRoles([$role]);
            }

            return $this->redirectWithSuccess('User updated successfully!');
        } catch (\Exception $e) {
            return $this->redirectWithError('Error updating user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            // Delete profile image if exists
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $user->delete();

            return $this->redirectWithSuccess('User deleted successfully!');
        } catch (\Exception $e) {
            return $this->redirectWithError('Error deleting user: ' . $e->getMessage());
        }
    }

    /**
     * Toggle user status
     */
    public function toggleStatus(string $id)
    {
        try {
            $user = User::findOrFail($id);

            $user->status = $user->status === BooleanEnum::TRUE->value ? BooleanEnum::TRUE->value : BooleanEnum::FALSE->value;
            $user->save();

           return redirect()->back()->with('success', 'User status updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating user status: ' . $e->getMessage());
        }
    }

    public function getStates($countryId)
    {
        $states = State::where('country_id', $countryId)->orderBy('name')->get();
        return response()->json($states);
    }

    public function getCities($stateId)
    {
        return response()->json(City::where('state_id', $stateId)->orderBy('name')->get());
    }
}
