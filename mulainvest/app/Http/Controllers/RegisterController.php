<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Validasi
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,Email,NULL,id,IsActive,1',
            'full_name' => 'required|string|max:255',
            'password' => 'required|string|min:5|regex:/[a-z]/|regex:/[0-9]/|confirmed'
        ]);

        // Create User
        $user = new User;
        $user->UserID = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
        $user->Name = $request->full_name;
        $user->Email = $request->email;
        $user->Password = Hash::make($request->password);
        $user->Balance = 0;
        $user->Role = 'user';
        $user->IsActive = 1;

        if ($user->save()) {
            //Nanti ganti route-nya dengan Login page
            return redirect()->route('register-success')->with('status', 'Registration successful!');
        } else {
            return back()->with('error', 'Failed to register. Please try again.');
        }
    }
}
