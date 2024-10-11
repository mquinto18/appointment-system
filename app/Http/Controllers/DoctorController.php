<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;    
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DoctorController extends Controller
{
    public function doctorAcc(Request $request){
         // Fetch the search input from the request (if any)
         $searchDoctor = $request->input('searchDoctor');

         // Fetch the admins with pagination (5 per page) and apply search if necessary
         $doctors = User::where('type', '2') // Assuming 'type' 2 is Doctor
                     ->when($searchDoctor, function ($query, $searchDoctor) {
                         return $query->where('name', 'like', "%{$searchDoctor}%")
                                     ->orWhere('email', 'like', "%{$searchDoctor}%");
                     })
                     ->paginate(5);
 
         // Count total admins (for the header)
         $totalDoctors = User::where('type', '2')->count();
 
         // Pass the paginated admins and total count to the view
         return view('components.doctor', compact('doctors', 'totalDoctors', 'searchDoctor'));
    }    

    public function doctorSave(Request $request)
    {
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
            'type' => "2"
        ]);

        notify()->success('Doctor added successfully!');
        return redirect()->back()->with('success', 'Doctor added successfully.');
    }

    public function doctorEdit($id){
        // Find the specific admin by ID
        $doctor = User::findOrFail($id);
    
        // Pass the admin details to the view
        return view('components.doctorEdit', compact('doctor'));
    }

    public function doctorUpdate(Request $request, $id){
        $doctor = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        // Update the admin details
        $doctor->update($request->all());
    
        // Redirect back with success message
        notify()->success('Doctor updated successfully!');
        return redirect()->route('doctor')->with('success', 'Doctor updated successfully.'); 
    }
}
