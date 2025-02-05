<?php

namespace App\Http\Controllers;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentApprovedMail; // Import your mailable class
use App\Mail\AppointmentCompletedMail; // Import your mailable class
use App\Mail\AppointmentRejectedMail; // Import your mailable class
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str; // Import the Str class

class AppointmentController extends Controller
{
    public function appointment(Request $request) {

        $users = User::where('type', 2)
        ->where('status', 'active')
        ->get(); // Retrieves all users with type 1
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
        return view('appointment.totalAppointment', compact('appointments', 'totalAppointments', 'search', 'users'));
    }

    public function appointmentSave(Request $request)
{
    // Automatically generate a unique transaction number
    $transactionNumber = 'TRX-' . strtoupper(Str::random(10));

    // Create a new appointment instance
    $appointment = new Appointment();

    // Fill the fields with data from the request
    $appointment->transaction_number = $transactionNumber;
    $appointment->user_id = $request->input('user_id') ?? auth()->id();
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

    // Define the mapping of visit types to amounts
   

    // Get the visit type from the requests
    $visitType = $request->input('visit_type');

    // Set the amount based on the visit type
 

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

    // Send email to the user
    $details = [
        'name' => $appointment->first_name . ' ' . $appointment->last_name,
        'email_address' => $appointment->email_address,
        'appointment_date' => $appointment->appointment_date,
        'appointment_time' => $appointment->appointment_time,
        'status' => 'approved'
    ];
    Mail::to($appointment->email_address)->send(new AppointmentApprovedMail($details));

    notify()->success('Appointment approved!');
    return redirect()->back()->with('success', 'Appointment approved successfully.');
}
    //Completed appointment
    public function completed($id){
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'completed';
        $appointment->save();

        $details = [
            'name' => $appointment->first_name . ' ' . $appointment->last_name,
            'email_address' => $appointment->email_address,
            'appointment_date' => $appointment->appointment_date,
            'status' => 'completed'
        ];

        Mail::to($appointment->email_address)->send(new AppointmentCompletedMail($details));

        notify()->success('Appointment completed!');
        return redirect()->back()->with('success', 'Appointment completed successfully.');
    }
    // Rejected appointment
    public function rejected($id){
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'rejected';
        $appointment->save();

        $details = [
            'name' => $appointment->first_name . ' ' . $appointment->last_name,
            'email_address' => $appointment->email_address,
            'appointment_date' => $appointment->appointment_date,
            'status' => 'rejected'
        ];

        Mail::to($appointment->email_address)->send(new AppointmentRejectedMail($details));

        notify()->success('Appointment rejected!');
        return redirect()->back()->with('success', 'Appointment rejected successfully.');
    }

    // Appointment Edit
    public function appointmentEdit($id){
        $appointment = Appointment::findOrFail($id);
    
        // Pass the admin details to the view
        return view('appointment.appointmentEdit', compact('appointment'));
    }

    public function appointmentFollowUp($id){
        $appointment = Appointment::findOrFail($id);

        return view('appointment.followUp', compact('appointment'));
    }

    public function appointmentFollowUpSave(Request $request, $id)
{
    // Generate a unique transaction number
    $transactionNumber = 'TRX-' . strtoupper(Str::random(10));

    // Validate request data
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'date_of_birth' => 'required|date',
        'appointment_date' => 'required|date',
        'appointment_time' => 'required',
        'visit_type' => 'required|string|max:255',
        'doctor' => 'required|string|max:255',
        'gender' => 'required|string',
        'marital_status' => 'required|string',
        'contact_number' => 'required|string|max:20',
        'email_address' => 'required|email|max:255',
        'complete_address' => 'required|string|max:255',
        'notes' => 'nullable|string',
        'diagnosis' => 'nullable|string',
    ]);

    // Find the existing appointment by ID
    $appointment = Appointment::findOrFail($id);

    // Update appointment details and set status to approved
    $appointment->update([
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'date_of_birth' => $request->input('date_of_birth'),
        'appointment_date' => $request->input('appointment_date'),
        'appointment_time' => $request->input('appointment_time'),
        'visit_type' => $request->input('visit_type'),
        'doctor' => $request->input('doctor'),
        'gender' => $request->input('gender'),
        'marital_status' => $request->input('marital_status'),
        'contact_number' => $request->input('contact_number'),
        'email_address' => $request->input('email_address'),
        'complete_address' => $request->input('complete_address'),
        'notes' => $request->input('notes'),
        'diagnosis' => $request->input('diagnosis'),
        'transaction_number' => $transactionNumber, // Save the generated transaction number
        'status' => 'approved',  // Set the status to approved
    ]);

    notify()->success('Appointment follow-up updated successfully!');
    // Redirect with success message
    return redirect()->route('appointment')
                     ->with('success', 'Appointment follow-up updated successfully');
}

    public function appointmentUpdate(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'visit_type' => 'required|string',
            'additional' => 'nullable|string|max:255',
            'doctor' => 'required|string',
            'gender' => 'required|string',
            'marital_status' => 'required|string',
            'contact_number' => 'required|string|max:15',
            'email_address' => 'required|email|max:255',
            'complete_address' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'diagnosis' => 'nullable|string',
        ]);

        // Find the appointment by ID
        $appointment = Appointment::findOrFail($id);

        // Update the appointment with the validated data
        $appointment->update($request->all());

        // Redirect back with a success message
        notify()->success('Appointment updated successfully!');
        return redirect()->route('appointment') // Adjust the route as needed
            ->with('success', 'Appointment updated successfully.');
    }

    public function appointmentDelete($id){
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        // Redirect back with a success message
        notify()->success('Appointment deleted successfully!');
        return redirect()->route('appointment')->with('success', 'Appointment deleted successfully!');
    }


    public function pending(Request $request){
         // Get search query
    $search = $request->input('search');

    // Query appointments with search functionality
    $appointments = Appointment::where('status', 'pending') // Only retrieve pending appointments
        ->where(function($query) use ($search) {
            if ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                      ->orWhere('last_name', 'like', '%' . $search . '%')
                      ->orWhere('doctor', 'like', '%' . $search . '%')
                      ->orWhere('visit_type', 'like', '%' . $search . '%');
            }
        })
        ->paginate(10); // Pagination with 10 rows per page

    $totalAppointments = Appointment::where('status', 'pending')->count(); // Count total number of pending appointments

    // Pass the appointments data and total count to the view
    return view('appointment.appointmentPending', compact('appointments', 'totalAppointments', 'search'));
    }

    public function approved(Request $request){
                // Get search query
        $search = $request->input('search');

        // Query appointments with search functionality
        $appointments = Appointment::where('status', 'approved') // Only retrieve pending appointments
            ->where(function($query) use ($search) {
                if ($search) {
                    $query->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%')
                            ->orWhere('doctor', 'like', '%' . $search . '%')
                            ->orWhere('visit_type', 'like', '%' . $search . '%');
                }
            })
            ->paginate(10); // Pagination with 10 rows per page

        $totalAppointments = Appointment::where('status', 'approved')->count(); // Count total number of pending appointments

        // Pass the appointments data and total count to the view
        return view('appointment.appointmentApproved', compact('appointments', 'totalAppointments', 'search'));
        }

        public function completedAppoint(Request $request){
            
            $search = $request->input('search');

            // Query appointments with search functionality
            $appointments = Appointment::where('status', 'completed') // Only retrieve pending appointments
                ->where(function($query) use ($search) {
                    if ($search) {
                        $query->where('first_name', 'like', '%' . $search . '%')
                                ->orWhere('last_name', 'like', '%' . $search . '%')
                                ->orWhere('doctor', 'like', '%' . $search . '%')
                                ->orWhere('visit_type', 'like', '%' . $search . '%');
                    }
                })
                ->paginate(10); // Pagination with 10 rows per page
    
            $totalAppointments = Appointment::where('status', 'completed')->count(); // Count total number of pending appointments
    
            // Pass the appointments data and total count to the view
            return view('appointment.appointmentCompleted', compact('appointments', 'totalAppointments', 'search'));
        }

        public function rejectedAppoint(Request $request){
            
            $search = $request->input('search');

            // Query appointments with search functionality
            $appointments = Appointment::where('status', 'rejected') // Only retrieve pending appointments
                ->where(function($query) use ($search) {
                    if ($search) {
                        $query->where('first_name', 'like', '%' . $search . '%')
                                ->orWhere('last_name', 'like', '%' . $search . '%')
                                ->orWhere('doctor', 'like', '%' . $search . '%')
                                ->orWhere('visit_type', 'like', '%' . $search . '%');
                    }
                })
                ->paginate(10); // Pagination with 10 rows per page
    
            $totalAppointments = Appointment::where('status', 'rejected')->count(); // Count total number of pending appointments
    
            // Pass the appointments data and total count to the view
            return view('appointment.appointmentRejected', compact('appointments', 'totalAppointments', 'search'));
        }
        public function canceledAppoint(Request $request){
            
            $search = $request->input('search');

            // Query appointments with search functionality
            $appointments = Appointment::where('status', 'cancelled') // Only retrieve pending appointments
                ->where(function($query) use ($search) {
                    if ($search) {
                        $query->where('first_name', 'like', '%' . $search . '%')
                                ->orWhere('last_name', 'like', '%' . $search . '%')
                                ->orWhere('doctor', 'like', '%' . $search . '%')
                                ->orWhere('visit_type', 'like', '%' . $search . '%');
                    }
                })
                ->paginate(10); // Pagination with 10 rows per page
    
            $totalAppointments = Appointment::where('status', 'rejected')->count(); // Count total number of pending appointments
    
            // Pass the appointments data and total count to the view
            return view('appointment.appointmentRejected', compact('appointments', 'totalAppointments', 'search'));
        }

        public function emergency(){
            return view('appointment.emergency');
        }
    }
