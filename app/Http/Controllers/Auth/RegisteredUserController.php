<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $countries = Country::orderBy('name')->get();

        $services = Service::orderBy('title')->where('status','active')->get();

        return view('auth.register', compact('countries', 'services'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['nullable', 'string', 'max:20'],
            'country_id' => ['required', 'string', 'max:255'],
            'state_id' => ['required', 'string', 'max:255'],
            'city_id' => ['required', 'string', 'max:255'],
            'role' => ['required', 'in:user,agent,professional'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ]);

        // Determine role based on user type
        // $role = $request->role === 'buy' ? 'customer' : $request->role;

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verified_at' => now(),
            'status' => 1,
        ]);

        $user->assignRole($request->role);

        event(new Registered($user));

        Auth::login($user);

        // Flash a role-based message
        if ($request->role === 'professional') {
            session()->flash('dashboard_message', 'Welcome Professional! Your profile is not listing in service until you update your profile.');
        } elseif ($request->role === 'agent') {
            session()->flash('dashboard_message', 'Welcome Agent! Start listing properties for your clients.');
        } else {
            session()->flash('dashboard_message', 'Welcome! Start exploring properties now.');
        }

        return redirect()->route('dashboard');
    }
}
