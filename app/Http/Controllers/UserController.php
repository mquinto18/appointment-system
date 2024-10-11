<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;    
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function userAcc(Request $request){

        // Fetch the search input from the request (if any)
        $searchUser = $request->input('searchUser');

        // Fetch the admins with pagination (5 per page) and apply search if necessary
        $users = User::where('type', '0') // Assuming 'type' 1 is Admin
                    ->when($searchUser, function ($query, $searchUser) {
                        return $query->where('name', 'like', "%{$searchUser}%")
                                    ->orWhere('email', 'like', "%{$searchUser}%");
                    })
                    ->paginate(5);

        // Count total admins (for the header)
        $totalUsers = User::where('type', '0')->count();

        // Pass the paginated admins and total count to the view
        return view('components.user', compact('users', 'totalUsers', 'searchUser'));
    }

    public function userSave(Request $request){
        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255', // Ensure this matches your database table
            'password' => 'required|string|min:8',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:male,female,other',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:500',
        ])->validate();
 
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'type' => "0"
        ]);

        notify()->success('User added successfully!');
        return redirect()->back()->with('success', 'User added successfully.');
    }

    public function userEdit($id){
        // Find the specific admin by ID
        $user = User::findOrFail($id);
    
        // Pass the admin details to the view
        return view('components.userEdit', compact('user'));
    }

    public function userUpdate(Request $request, $id){
        $user = User::findOrFail($id);
    
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string',
            'address' => 'nullable|string',
        ]);
    
        // Update the admin details
        $user->update($request->all());
    
        // Redirect back with success message
        notify()->success('User updated successfully!');
        return redirect()->route('user')->with('success', 'User updated successfully.'); 
    }
}
