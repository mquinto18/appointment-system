<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\Rating;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Carbon\Carbon;
use App\Models\AppointmentSlot;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
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

    // Retrieve and count ratings
    $ratings = DB::table('ratings')
        ->select('rating', DB::raw('COUNT(*) as count'))
        ->groupBy('rating')
        ->pluck('count', 'rating')
        ->toArray();

    // Ensure all ratings (1-5) are present, even if 0
    $ratingsData = [];
    for ($i = 1; $i <= 5; $i++) {
        $ratingsData[$i] = $ratings[$i] ?? 0; // Default to 0 if no ratings for that star
    }

    return view('dashboard', compact(
        'totalUsers',
        'totalAppointment',
        'totalAmount',
        'totalCompleted',
        'appointments',
        'appointmentsAll',
        'monthlyEarnings',
        'statusCounts',
        'ratingsData' // Pass ratings data to the view
    ));
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
        $users = User::where('type', 2)
             ->where('status', 'active')
             ->get(); // Retrieves all users with type 1

        // Pass the users to the view
        return view('patient.patient-appointment', compact('users'));
    }

    public function patientStore(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'selected_date' => 'required|date',
            'selected_time' => 'required|string',
            'selected_doctor' => 'required|integer', // Keep this to validate the ID
        ]);

        // Retrieve the doctor's name from the database
        $doctor = User::find($validatedData['selected_doctor']);
        $doctorName = $doctor ? $doctor->name : 'Doctor not found'; // Get doctor's name

        // Save data to session
        session([
            'appointment_date' => $validatedData['selected_date'],
            'appointment_time' => $validatedData['selected_time'],
            'appointment_doctor' => $doctorName, // Store the doctor's name
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
        $doctorName = session('appointment_doctor'); // This is now the doctor's name

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
                'appointment_doctor' => $doctorName, // Store appointment doctor's name
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
        $doctorName = $patientDetails['appointment_doctor'] ?? ''; // This will now contain the doctor's name

        return view('patient.confirm-appointment', compact('patientDetails', 'date', 'time', 'doctorName'));
    }
    public function appointConfirm(Request $request)
{
    // Retrieve the patient details from the session
    $patientDetails = session('patient_details');
    $appointmentDate = $patientDetails['appointment_date'];

        // Find the slot for the specified appointment date
    $slot = AppointmentSlot::firstOrCreate(
            ['appointment_date' => $appointmentDate],
            ['total_slots' => 4] // Ensure there are always 2 total slots
    );

    // Check if there are available slots
    if ($slot->booked_slots < $slot->total_slots) {
        // Generate a unique transaction number
        $transactionNumber = 'TRX-' . strtoupper(Str::random(10));

            // Convert appointment time to 24-hour format
            $appointmentTime = Carbon::createFromFormat('g:i A', $patientDetails['appointment_time'])->format('H:i:s');

        // Create a new Appointment instance
        $appointment = new Appointment([
            'transaction_number' => $transactionNumber,
            'first_name' => $patientDetails['first_name'],
            'last_name' => $patientDetails['last_name'],
            'date_of_birth' => $patientDetails['birthday'],
            'appointment_date' => $appointmentDate,
            'appointment_time' => $appointmentTime,
            'visit_type' => $patientDetails['visit_type'],
            'doctor' => $patientDetails['appointment_doctor'], // This is now the doctor's name
            'additional' => $patientDetails['medical_certificate'],
            'gender' => $patientDetails['gender'],
            'contact_number' => $patientDetails['mobile_number'],
            'email_address' => $patientDetails['email'],
            'complete_address' => $patientDetails['address'],
            'status' => 'pending',
            'user_id' => auth()->id(), // Set the user_id to the currently authenticated user's ID
        ]);

        // Save the appointment to the database
        $appointment->save();

            // Increment booked slots
            $slot->increment('booked_slots');

        // Clear the session data
        session()->forget('patient_details');

        // Redirect to a success page or confirmation view
        return redirect()->back()->with('message', 'Please wait for a notification once your appointment has been approved.');
    } else {
        // No slots available, show an error message
            return redirect()->back()->with('error', 'This date is fully booked. Please select a different date.');
    }
}



    public function appointmentBooked()
    {
        // Retrieve the currently authenticated user's appointments, sorted by created_at in descending order
        $appointments = Appointment::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc') // Sort by created_at in descending order
            ->get();

        return view('patient.appointment-booked', compact('appointments'));
    }


    public function appointmentCancel($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'cancelled';
        $appointment->save();

        notify()->success('Appointment Cancelled!');
        return redirect()->back()->with('success', 'Appointment cancelled successfully.');
    }

    public function appointmentReschedule($id){
        $appointment = Appointment::findorFail($id);
        $appointment->status = 'approved';
        $appointment->save();

        notify()->success('Appointment Rescheduled!');
        return redirect()->back()->with('success', 'Appointment rescheduled successfully.');
    }

    public function appointmentDelete($id)
    {
        $appointment = Appointment::find($id);
        $appointment->delete();

        notify()->success('Appointment deleted successfully!');
        return redirect()->route('appointments.booked')->with('success', 'Appointment deleted successfully!');
    }

    public function appointmentQrcode($id)
    {
        // Find the appointment by ID
        $appointmentqr = Appointment::findOrFail($id);  // Changed variable name to appointmentqr

        // Generate QR code using a unique field, e.g., appointment transaction number
        $qrCode = new QrCode($appointmentqr->transaction_number); // Using appointmentqr instead of appointments
        $writer = new PngWriter();

        // Write the QR code to a string (PNG format)
        $qrCodeImage = $writer->write($qrCode);

        // Return the QR code as a response (image/png)
        return response($qrCodeImage->getString())
            ->header('Content-Type', 'image/png');
    }

    public function downloadQRPdf($id)
    {
        // Find the appointment by ID, ensuring a unique record each time
        $appointment = Appointment::findOrFail($id);

        // Generate QR code specific to this appointment's transaction number
        $qrCode = new QrCode($appointment->transaction_number);
        $writer = new PngWriter();
        $qrCodeImage = $writer->write($qrCode);

        // Encode QR code as base64 for embedding in PDF, avoiding any reuse or caching
        $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($qrCodeImage->getString());

        // Load the PDF view, passing in the specific QR code and appointment details
        $pdf = Pdf::loadView('patient.qr-code', [
            'appointment' => $appointment,
            'qrCode' => $qrCodeBase64,
        ]);

        // Download the PDF for this specific appointment, ensuring no caching issues
        return $pdf->download('appointment_qrcode_' . $appointment->id . '.pdf');
    }

    public function appointmentRate(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'rating' => 'required|integer|min:1|max:5', // Ensure the rating is between 1 and 5
        ]);

        // Store the rating in the database
        $rating = new Rating();
        $rating->rating = $request->input('rating'); // Store the rating value
        $rating->save();

        // Optionally, you can return a response or redirect
        notify()->success('Appointment rating submitted!');
        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }
}
