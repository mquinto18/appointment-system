<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;  

class CashierProfileController extends Controller
{
    public function profileSettings()
    {
        return view('components.cashierProfile');
    }

    public function profileUpdate(Request $request)
    {
        // Validate the input
        $request->validate([
            'date_of_birth'   => 'nullable|date',
            'phone_number'    => 'nullable|string|max:15',
            'address'         => 'nullable|string|max:255',
            'gender'          => 'nullable|in:male,female',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max for profile picture
            'status'          => 'required|in:active,inactive', // Add status validation
        ]);

        // Get the authenticated user
         /** @var User $user */
        $user = Auth::user();

        // Check if a profile picture is being uploaded
        if ($request->hasFile('profile_picture')) {
            // Delete old image if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete('profile_pictures/' . $user->profile_picture);
            }
        
            // Generate a secure filename
            $filename = $user->id . '_' . time() . '.' . $request->profile_picture->extension();
            
            // Store in storage/app/public/profile_pictures
            $request->profile_picture->storeAs('profile_pictures', $filename, 'public');
        
            // Update the user record
            $user->profile_picture = $filename;
            $user->save();
        }

        // Update the other user fields
        $user->update([
            'date_of_birth' => $request->date_of_birth,
            'phone_number'  => $request->phone_number,
            'address'       => $request->address,
            'gender'        => $request->gender,
            'status'        => $request->status, // Update the status field
        ]);

        // Redirect back with a success message
        notify()->success('Profile updated successfully!');
        return redirect()->back()->with('status', 'Profile updated successfully!');
    }

    public function securitySettings()
    {
        return view('components.cashierSecurity');
    }

    public function securityUpdate(Request $request){
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

   public function changePassword(Request $request){
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

public function accountDelete(Request $request){
    /** @var User $user */
    $user = Auth::user();
    $user->delete();

    Auth::logout();
    return redirect('/')->with('success', 'Your account has been deleted successfully.');
}
}
