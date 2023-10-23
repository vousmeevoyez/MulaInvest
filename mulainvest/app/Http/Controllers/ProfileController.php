<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    
    public function index()
    {
        $user = User::where('UserID', auth()->user()->UserID)->first();
        return view('profile', [
            'title' => 'Profil',
            'user' => $user
        ]);
    }

    public function showEditProfileForm()
    {
        $user = User::where('UserID', auth()->user()->UserID)->first();
        return view('edit-profile-form');
    }

    public function updateProfile(Request $request)
    {
        // Validasi
        $request->validate([
            'email' => 'required|email|unique:users,Email,' . auth()->user()->UserID . ',UserID,IsActive,1',
            'full_name' => 'required|string|max:255',
            'no_telp' => 'nullable|numeric',
        ]);

        // Dapatkan user yang sedang login
        $user = User::where('UserID', auth()->user()->UserID)->first();

        // Update data user
        $user->Name = $request->full_name;
        $user->Email = $request->email;
        $user->NoTelp = $request->no_telp;

        if ($user->save()) {
            // Redirect dengan pesan sukses
            return redirect()->route('profile-page')->with('status', 'Profile Updated!');
        } else {
            // Redirect dengan pesan kesalahan
            return back()->with('error', 'Failed to update profile. Please try again.');
        }
    }

    public function showEditPasswordForm()
    {
        $user = User::where('UserID', auth()->user()->UserID)->first();
        return view('edit-password-form');
    }

    public function updatePassword(Request $request)
    {
        // Validasi form inputan
        $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|string|min:5|regex:/[a-z]/|regex:/[0-9]/|confirmed',
        ]);

        // Dapatkan user yang sedang login
        $user = User::where('UserID', auth()->user()->UserID)->first();

        // Periksa apakah kata sandi lama sesuai
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Old password is incorrect.');
        }

        // Update kata sandi
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            // Redirect dengan pesan sukses
            return redirect()->route('profile-page')->with('status', 'Password Updated!');
        } else {
            // Redirect dengan pesan kesalahan
            return back()->with('error', 'Failed to update password. Please try again.');
        }
    }
}
