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
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str; // Import the Str class

class AppointmentController extends Controller
{
    public function appointment(Request $request)
    {

        $users = User::where('type', 2)
            ->where('status', 'active')
            ->get(); // Retrieves all users with type 1
        // Get search query
        $search = $request->input('search');

        // Query appointments with search functionality
        $appointments = Appointment::where(function ($query) use ($search) {
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
        // Find the appointment by ID
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'approved';
        $appointment->save();

        // Send email to the user
        $details = [
            'name' => $appointment->first_name . ' ' . $appointment->last_name,
            'email_address' => $appointment->email_address,
            'appointment_date' => $appointment->appointment_date,
            'appointment_time' => $appointment->appointment_time,
            'doctor' => $appointment->doctor,
            'status' => 'approved'
        ];
        Mail::to($appointment->email_address)->send(new AppointmentApprovedMail($details));

        // Send SMS using Twilio (Fetching credentials from .env file)
        $sid    = env('TWILIO_SID');
        $token  = env('TWILIO_AUTH_TOKEN');
        $from   = env('TWILIO_PHONE_NUMBER'); // Your Twilio phone number
        $to     = $appointment->contact_number; // Assuming this is stored in the appointment record

        $client = new Client($sid, $token);

        // SMS content
        $messageContent = "Hi " . $appointment->first_name . ",\n" .
            "Your appointment on " . $appointment->appointment_date . " at " . $appointment->appointment_time .
            " has been approved.\n Please arrive 10-15 minutes early. If you need to reschedule, kindly update your scheduled appointment on your Online Portal at least 24 hours in advance. \n For inquiries, contact us at 09123456789. \n Thank you!";

        try {
            // Sending the SMS
            $client->messages->create(
                $to, // To phone number
                [
                    'from' => $from, // From phone number (your Twilio number)
                    'body' => $messageContent // SMS message content
                ]
            );
        } catch (Exception $e) {
            // Handle any errors (e.g., invalid phone number)
            \Log::error('Error sending SMS: ' . $e->getMessage());
        }

        // Notify success in the system
        notify()->success('Appointment approved!');

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Appointment approved successfully.');
    }
    //Completed appointment
    public function completed($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'completed';
        $appointment->save();

        $details = [
            'name' => $appointment->first_name . ' ' . $appointment->last_name,
            'email_address' => $appointment->email_address,
            'appointment_date' => $appointment->appointment_date,
            'doctor' => $appointment->doctor,
            'status' => 'completed'
        ];

        Mail::to($appointment->email_address)->send(new AppointmentCompletedMail($details));

        // // Send SMS using Twilio (Fetching credentials from .env file)
        // $sid    = env('TWILIO_SID');
        // $token  = env('TWILIO_AUTH_TOKEN');
        // $from   = env('TWILIO_PHONE_NUMBER'); // Your Twilio phone number
        // $to     = $appointment->contact_number; // Assuming this is stored in the appointment record

        // $client = new Client($sid, $token);

        // // SMS content
        // $messageContent = "Hi " . $appointment->first_name . ",\n" .
        //     "Your appointment on " . $appointment->appointment_date . " at " . $appointment->appointment_time .
        //     " has been successfully completed.\n We appreciate your time and trust in our services. If you have any feedback or need further assistance, feel free to contact us at 09123456789. \n Thank you!";


        // try {
        //     // Sending the SMS
        //     $client->messages->create(
        //         $to, // To phone number
        //         [
        //             'from' => $from, // From phone number (your Twilio number)
        //             'body' => $messageContent // SMS message content
        //         ]
        //     );
        // } catch (Exception $e) {
        //     // Handle any errors (e.g., invalid phone number)
        //     \Log::error('Error sending SMS: ' . $e->getMessage());
        // }

        notify()->success('Appointment completed!');
        return redirect()->back()->with('success', 'Appointment completed successfully.');
    }
    // Rejected appointment
    public function rejected(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        // Update status to rejected
        $appointment->status = 'rejected';

        // Update appointment date and time if provided
        if ($request->has('appointment_date') && $request->has('appointment_time')) {
            $appointment->appointment_date = $request->appointment_date;
            $appointment->appointment_time = $request->appointment_time;
        }

        $appointment->save();

        // Send rejection email
        $details = [
            'name' => $appointment->first_name . ' ' . $appointment->last_name,
            'email_address' => $appointment->email_address,
            'appointment_date' => $appointment->appointment_date,
            'appointment_time' => $appointment->appointment_time,
            'status' => 'rejected'
        ];

        Mail::to($appointment->email_address)->send(new AppointmentRejectedMail($details));

        notify()->success('Appointment rejected and rescheduled!');

        return redirect()->back()->with('success', 'Appointment rejected and rescheduled successfully.');
    }


    // Appointment Edit
    public function appointmentEdit($id)
    {
        $appointment = Appointment::findOrFail($id);

        // Pass the admin details to the view
        return view('appointment.appointmentEdit', compact('appointment'));
    }

    public function appointmentFollowUp($id)
    {
        $appointment = Appointment::findOrFail($id);

        return view('appointment.followUp', compact('appointment'));
    }

    public function appointmentFollowUpSave(Request $request, $id)
    {
        $transactionNumber = 'TRX-' . strtoupper(Str::random(10));

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

        // Convert 12-hour format to 24-hour format
        $appointmentTime24 = Carbon::createFromFormat('h:i A', $request->input('appointment_time'))->format('H:i:s');

        // Find the existing appointment
        $appointment = Appointment::findOrFail($id);

        // Update fields
        $appointment->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'date_of_birth' => $request->input('date_of_birth'),
            'appointment_date' => $request->input('appointment_date'),
            'appointment_time' => $appointmentTime24,
            'visit_type' => $request->input('visit_type'),
            'doctor' => $request->input('doctor'),
            'gender' => $request->input('gender'),
            'marital_status' => $request->input('marital_status'),
            'contact_number' => $request->input('contact_number'),
            'email_address' => $request->input('email_address'),
            'complete_address' => $request->input('complete_address'),
            'notes' => $request->input('notes'),
            'diagnosis' => $request->input('diagnosis'),
            'transaction_number' => $transactionNumber,
            'status' => 'approved',
        ]);

        // Explicitly set follow_up to 1
        $appointment->follow_up = 1;
        $appointment->save();

        notify()->success('Appointment follow-up updated successfully!');
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

    public function appointmentDelete($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        // Redirect back with a success message
        notify()->success('Appointment deleted successfully!');
        return redirect()->route('appointment')->with('success', 'Appointment deleted successfully!');
    }


    public function pending(Request $request)
    {
        // Get search query
        $search = $request->input('search');

        // Query appointments with search functionality
        $appointments = Appointment::where('status', 'pending') // Only retrieve pending appointments
            ->where(function ($query) use ($search) {
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

    public function approved(Request $request)
    {
        // Get search query
        $search = $request->input('search');

        // Query appointments with search functionality
        $appointments = Appointment::where('status', 'approved') // Only retrieve pending appointments
            ->where(function ($query) use ($search) {
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

    public function completedAppoint(Request $request)
    {

        $search = $request->input('search');

        // Query appointments with search functionality
        $appointments = Appointment::where('status', 'completed') // Only retrieve pending appointments
            ->where(function ($query) use ($search) {
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

    public function rejectedAppoint(Request $request)
    {

        $search = $request->input('search');

        // Query appointments with search functionality
        $appointments = Appointment::where('status', 'rejected') // Only retrieve pending appointments
            ->where(function ($query) use ($search) {
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
    public function canceledAppoint(Request $request)
    {

        $search = $request->input('search');

        // Query appointments with search functionality
        $appointments = Appointment::where('status', 'cancelled') // Only retrieve pending appointments
            ->where(function ($query) use ($search) {
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

    public function emergency()
    {
        return view('appointment.emergency');
    }
}
