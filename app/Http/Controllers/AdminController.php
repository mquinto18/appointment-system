<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;    
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function adminAcc(Request $request)
    {
        // Fetch the search input from the request (if any)
        $search = $request->input('search');

        // Fetch the admins with pagination (5 per page) and apply search if necessary
        $admins = User::where('type', '1') // Assuming 'type' 1 is Admin
                    ->when($search, function ($query, $search) {
                        return $query->where('name', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->paginate(5);

        // Count total admins (for the header)
        $totalAdmins = User::where('type', '1')->count();

        // Pass the paginated admins and total count to the view
        return view('components.admin', compact('admins', 'totalAdmins', 'search'));
    }

    public function adminSave(Request $request){

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
            'type' => "1"
        ]);

        notify()->success('Admin added successfully!');
        return redirect()->back()->with('success', 'Admin added successfully.');
    }

    public function adminDestroy($id){
        $user = User::findOrFail($id)->delete();

        if($user){
            session()->flash('success', 'Deleted Successfully');
            notify()->success('Admin deleted successfully!');
            return redirect()->back()->with('success', 'Admin deleted successfully.');
        }else{
            session()->flash('error', 'Error Delete');
            return redirect()->back()->with('success', 'Admin deleted successfully.');
        }
    }   

   

    public function adminEdit($id){
        // Find the specific admin by ID
        $admin = User::findOrFail($id);
    
        // Pass the admin details to the view
        return view('components.adminEdit', compact('admin'));
    }

    public function adminUpdate(Request $request, $id){
        $admin = User::findOrFail($id);
    
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
        $admin->update($request->all());
    
        // Redirect back with success message
        notify()->success('Admin updated successfully!');
        return redirect()->route('admin')->with('success', 'Admin updated successfully.');  
    }
}

