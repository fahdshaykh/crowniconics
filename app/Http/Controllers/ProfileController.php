<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Country;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $countries = Country::orderBy('name')->get();
        $services = Service::all();

        return view('dashboard.profile.edit', [
            'countries' => $countries,
            'services' => $services,
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        // $request->user()->fill($request->validated());

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }

        // $request->user()->save();

        try {
            $user = User::findOrFail(auth()->id());
            
            $validated = $request->validate([
                'first_name'           => 'required|string|max:255',
                'last_name'            => 'required|string|max:255',
                'phone'                => 'nullable|string|max:20',
                'password'             => 'nullable|string|min:8|confirmed',
                'country_id'           => 'nullable|string|max:255',
                'city_id'              => 'nullable|string|max:255',
                'state_id'             => 'nullable|string|max:255',
                'zip_code'             => 'nullable|string|max:20',
                'address'              => 'nullable|string',
                'profile_image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'service_id'           => 'nullable|exists:services,id',
                'price'                => 'nullable|numeric',
                'experience_years'     => 'nullable|numeric',
                'personal_information' => 'nullable|string',
            ]);

            $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];

            
            // Handle password
            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            
            // Handle profile image
            if ($request->hasFile('profile_image')) {
                // dd($user->profile_image);
                if ($user->profile_image) {
                    Storage::disk('public')->delete($user->profile_image);
                }

                $validated['profile_image'] = $request->file('profile_image')->store('users/profile-images', 'public');
            }

            // Handle multiple images upload
            if ($request->hasFile('images')) {
                // Ensure folder exists
                if (!Storage::disk('public')->exists('users/gallery')) {
                    Storage::disk('public')->makeDirectory('users/gallery');
                }

                $images = [];
                foreach ($request->file('images') as $image) {
                    $images[] = $image->store('users/gallery', 'public');
                }

                $data['images'] = $images;
            }

            $user->update($validated);

            // Sync service pivot table
            if (!empty($validated['service_id'])) {
                $user->services()->sync([
                    $validated['service_id'] => [
                        'experience_years'      => $validated['experience_years'] ?? 0,
                        'personal_information'  => $validated['personal_information'] ?? '',
                        'status'                => 'active',
                        'images'                => !empty($images) ? json_encode($images) : null, 
                    ]
                ]);
            }

            return redirect()->route('profile.edit')->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('profile.edit')->with('error', 'Error updating user: ' . $e->getMessage());
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
