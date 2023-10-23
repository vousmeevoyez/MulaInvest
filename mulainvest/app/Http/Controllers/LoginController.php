<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validasi
        $request->validate([
            'email' => ['required', 'email', Rule::exists('users', 'Email')->where(function ($query) {
                $query->where('IsActive', 1);
            })],
            'password' => ['required', 'min:5', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],
        ]);

        // Fetch user pakai Email
        $user = User::where('Email', $request->email)->where('IsActive', 1)->first();

        // Login Logic
        if ($user && Hash::check($request->password, $user->Password)) {
            auth()->login($user);

            // Handle role user
            if ($user->Role === 'user') {
                return redirect()->route('user-home');
            } elseif ($user->Role === 'admin') {
                return redirect()->route('content-management-system');
            }
        }

        // If login details are incorrect
        return redirect()->back()->withErrors(['email' => 'The provided credentials do not match our records.']);

    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login.form');
    }
}
