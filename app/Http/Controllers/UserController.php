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


    // admin panel
    // view all users 
    public function index()
    {
        $users = User::all();
        return view('pages.admin.users.index', compact('users'));
    }


    // create user function
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,super_admin'],
        ]);

        User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);


        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    // update user function
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'in:admin,super_admin'],
        ], [], [], "edit_{$user->id}");

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    // delete user function
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }




}
