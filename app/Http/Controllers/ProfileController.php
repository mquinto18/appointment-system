<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profileUpdate(Request $request)
{
    // Validate the input (exclude profile_picture from here)
    $request->validate([
        'date_of_birth'   => 'nullable|date',
        'phone_number'    => 'nullable|string|max:15',
        'address'         => 'nullable|string|max:255',
        'gender'          => 'nullable|in:male,female',
        'status'          => 'required|in:active,inactive',
    ]);

    /** @var User $user */
    $user = Auth::user();

    // Only update fields that have changed
    $user->update($request->only(['date_of_birth', 'phone_number', 'address', 'gender', 'status']));

    notify()->success('Profile updated successfully!');
    return redirect()->back()->with('status', 'Profile updated successfully!');
}

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Delete old image if exists
        if ($user->profile_picture) {
            Storage::disk('public')->delete('profile_pictures/' . $user->profile_picture);
        }

        // Generate a secure filename
        $filename = $user->id . '_' . time() . '.' . $request->profile_picture->extension();

        // Store in storage/app/public/profile_pictures
        $request->profile_picture->storeAs('profile_pictures', $filename, 'public');

        // Update user profile picture
        $user->profile_picture = $filename;
        $user->save();

        notify()->success('Profile picture updated successfully!');
        return redirect()->back()->with('status', 'Profile picture updated successfully!');
    }


    public function securityUpdate(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        notify()->success('Changed successfully!');
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],  // Laravel will verify this automatically
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],  // 'confirmed' requires a matching '_confirmation' field
        ]);

        // Update password
        /** @var User $user */
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        notify()->success('Password Changed successfully!');
        return redirect()->back()->with('success', 'Password updated successfully!');
    }

    public function accountDelete(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $user->delete();

        Auth::logout();
        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }
}
