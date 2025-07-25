<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */

    // login function
    public function showLoginForm()
    {
        return view('pages.auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === 'super_admin') {
                return redirect('/dashboard')->with('success', 'Welcome Super Admin!');
            } elseif ($user->role === 'admin') {
                return redirect('/')->with('success', 'Welcome Admin!');
            } else {
                Auth::logout();
                return redirect('/login')->withErrors(['username' => 'Unauthorized role.']);
            }
        }

        return redirect()->back()->withErrors(['username' => 'Invalid credentials.']);
    }


    // logout function
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully.');
    }

    // registration function
    public function showRegistrationForm()
    {
        return view('pages.auth.register');
    }
    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Automatically log in the newly registered user
        // Auth::login(User::where('email', $validated['email'])->first());

        return redirect('/')->with('success', 'User registered successfully.');
    }





}
