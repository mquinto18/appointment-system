<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Import the Str class

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function adminIndex()
    {
        $totalUsers = User::count();
        $totalAppointment = Appointment::count();

        $appointments = Appointment::whereDate('appointment_date', Carbon::today())->paginate(3);
        $appointmentsAll = Appointment::all();
        $totalAmount = 0;
        $totalCompleted = 0;

        // Array to store monthly earnings
        $monthlyEarnings = [];

        foreach ($appointments as $appointment) {
            $amounts = json_decode($appointment->amount, true);

            // Sum the decoded amounts
            if (is_array($amounts)) {
                $appointmentTotal = array_sum($amounts);
                $totalAmount += $appointmentTotal;
            } elseif (is_numeric($appointment->amount)) {
                $appointmentTotal = $appointment->amount;
                $totalAmount += $appointment->amount;
            } else {
                $appointmentTotal = 0;
            }

            if ($appointment->status === 'completed') {
                $totalCompleted++;
            }

            // Group total earnings by month
            $month = \Carbon\Carbon::parse($appointment->created_at)->format('m-d-y');
            if (!isset($monthlyEarnings[$month])) {
                $monthlyEarnings[$month] = 0;
            }
            $monthlyEarnings[$month] += $appointmentTotal;
        }

        $totalAmount = number_format($totalAmount, 2, '.', ',');

        $statusCounts = [
            'pending' => $appointmentsAll->where('status', 'pending')->count(),
            'approved' => $appointmentsAll->where('status', 'approved')->count(),
            'completed' => $appointmentsAll->where('status', 'completed')->count(),
            'rejected' => $appointmentsAll->where('status', 'rejected')->count(),
        ];
        // Pass the earnings data to the view
        return view('dashboard', compact('totalUsers', 'totalAppointment', 'totalAmount', 'totalCompleted', 'appointments', 'appointmentsAll', 'monthlyEarnings', 'statusCounts'));
    }



    public function profileSettings()
    {
        return view('components.profile');
    }

    public function securitySettings()
    {
        return view('components.security');
    }

    //Patient Appointment
    public function patient_appointment()
    {
        // Retrieve all users with type = 1
        $users = User::where('type', 2)->get(); // Retrieves all users with type 1

        // Pass the users to the view
        return view('patient.patient-appointment', compact('users'));
    }

    public function patientStore(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'selected_date' => 'required|date',
            'selected_time' => 'required|string',
            'selected_doctor' => 'required|integer',
        ]);

        // Save data to session or database
        session([
            'appointment_date' => $validatedData['selected_date'],
            'appointment_time' => $validatedData['selected_time'],
            'appointment_doctor' => $validatedData['selected_doctor'],
        ]);

        // Redirect to patient details
        return redirect()->route('patient.details');
    }

    public function patientDetails()
    {
        // You can retrieve session data or any additional data here
        $date = session('appointment_date');
        $time = session('appointment_time');
        $doctorId = session('appointment_doctor');
    
        // Optionally retrieve the doctor's information if needed
        $doctor = User::find($doctorId); // Assuming the doctor is in the users table
    
        // Get doctor's name (or any other information you need)
        $doctorName = $doctor ? $doctor->name : 'Doctor not found'; // Adjust 'name' to the correct column name in your users table
    
        return view('patient.patientDetails', compact('date', 'time', 'doctorName'));
    }

    public function storePatientDetails(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'birthday' => 'required|date',
            'gender' => 'required|string|in:male,female',
            'visit_type' => 'required|string',
            'medical_certificate' => 'nullable|string',
        ]);

        // Retrieve appointment details from the session
        $date = session('appointment_date');
        $time = session('appointment_time');
        $doctorName = session('appointment_doctor');

        // Store patient details and appointment details in the session
        session([
            'patient_details' => [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'mobile_number' => $validated['mobile_number'],
                'address' => $validated['address'],
                'birthday' => $validated['birthday'],
                'gender' => $validated['gender'],
                'visit_type' => $validated['visit_type'],
                'medical_certificate' => $request->has('medical_certificate') ? 'Medical Certificate' : null, // Store as true/false
                'appointment_date' => $date, // Store appointment date
                'appointment_time' => $time, // Store appointment time
                'appointment_doctor' => $doctorName, // Store appointment doctor ID
            ]
        ]);
       
        // Redirect to the next step (adjust the route as necessary)
        return redirect()->route('appointments.confirmDetails'); // Define this route in your web.php
    }


    public function confirmDetails()
    {

        $patientDetails = session('patient_details');
        $date = $patientDetails['appointment_date'] ?? '';
        $time = $patientDetails['appointment_time'] ?? '';
        $doctorName = $patientDetails['appointment_doctor'] ?? '';


        return view('patient.confirm-appointment', compact('patientDetails', 'date', 'time', 'doctorName'));
    }
}
