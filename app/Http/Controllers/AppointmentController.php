<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;    
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str; // Import the Str class

class AppointmentController extends Controller
{
    public function appointment(Request $request) {
        // Get search query
        $search = $request->input('search');
    
        // Query appointments with search functionality
        $appointments = Appointment::where(function($query) use ($search) {
            if ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                      ->orWhere('last_name', 'like', '%' . $search . '%')
                      ->orWhere('doctor', 'like', '%' . $search . '%')
                      ->orWhere('visit_type', 'like', '%' . $search . '%');
            }
        })
        ->paginate(10); // Pagination with 5 rows per page
    
        $totalAppointments = Appointment::count(); // Count total number of appointments
    
        // Pass the appointments data and total count to the view
        return view('appointment.totalAppointment', compact('appointments', 'totalAppointments', 'search'));
    }

    public function appointmentSave(Request $request)
    {
        // Automatically generate a unique transaction number
        $transactionNumber = 'TRX-' . strtoupper(Str::random(10));

        // Create a new appointment instance
        $appointment = new Appointment();

        // Fill the fields with data from the request
        $appointment->transaction_number = $transactionNumber;
        $appointment->first_name = $request->input('first_name');
        $appointment->last_name = $request->input('last_name');
        $appointment->date_of_birth = $request->input('date_of_birth');
        $appointment->appointment_date = $request->input('appointment_date');
        $appointment->appointment_time = $request->input('appointment_time');
        $appointment->visit_type = $request->input('visit_type');
        $appointment->additional = $request->input('additional');
        $appointment->doctor = $request->input('doctor');
        $appointment->gender = $request->input('gender');
        $appointment->marital_status = $request->input('marital_status');
        $appointment->contact_number = $request->input('contact_number');
        $appointment->email_address = $request->input('email_address');
        $appointment->complete_address = $request->input('complete_address');
        
        // Automatically set the status to 'Pending'
        $appointment->status = 'Pending';
        
        $appointment->notes = $request->input('notes');

        // Save the appointment to the database
        $appointment->save();

        // Redirect back with a success message
        notify()->success('Appointment added successfully!');
        return redirect()->back()->with('success', 'Appointment successfully added!');
    }


    // Approve appointment
    public function approve($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'approved';
        $appointment->save();

        notify()->success('Appointment approved!');
        return redirect()->back()->with('success', 'Appointment approved successfully.');
    }
    //Completed appointment
    public function completed($id){
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'completed';
        $appointment->save();

        notify()->success('Appointment completed!');
        return redirect()->back()->with('success', 'Appointment completed successfully.');
    }
    // Rejected appointment
    public function rejected($id){
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'rejected';
        $appointment->save();

        notify()->success('Appointment rejected!');
        return redirect()->back()->with('success', 'Appointment rejected successfully.');
    }
    }
