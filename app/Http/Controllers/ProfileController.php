<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        return view('settings', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $data['profile_photo_path'] = $path;
        }

        $user->update($data);

        return back()->with('status', 'Profile updated');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = Auth::user();

        if (! Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        return back()->with('status', 'Password updated');
    }
}
