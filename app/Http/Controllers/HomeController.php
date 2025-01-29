<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;    
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use App\Models\Rating;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Carbon\Carbon;
use App\Models\AppointmentSlot;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Mail\ContactMessage;
use Illuminate\Support\Str; // Import the Str class

class HomeController extends Controller
{
    public function index()
    {   

        $images = [
            asset('images/pic1.jpg'),
            asset('images/pic2.jpg'),
            asset('images/pic3.jpg'),
            asset('images/pic3.jpg'),
        ];

        return view('home', compact('images'));
    }


    public function adminIndex()
{

    $appointmentStatus = Appointment::where('user_id', auth()->id())
    ->where('status', 'pending')
    ->get();

    $appointmentCount = $appointmentStatus->count();


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
        'ratingsData',
        'appointmentStatus', 
        'appointmentCount' 
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
        'amount' => 'required|string', // Change to string as the input is JSON-encoded
        'medical_certificate' => 'nullable|string',
    ]);

    // Decode the JSON string into an associative array
    $amountData = json_decode($validated['amount'], true);

    // Store patient details and appointment details in the session
    $date = session('appointment_date');
    $time = session('appointment_time');
    $doctorName = session('appointment_doctor'); // This is now the doctor's name

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
            'amount' => $amountData, // Store the decoded amount
            'medical_certificate' => $request->has('medical_certificate') ? 'Medical Certificate' : null,
            'appointment_date' => $date,
            'appointment_time' => $time,
            'appointment_doctor' => $doctorName,
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
            'amount' => json_encode($patientDetails['amount']), // Store the amount as JSON
            'doctor' => $patientDetails['appointment_doctor'],
            'additional' => $patientDetails['medical_certificate'],
            'gender' => $patientDetails['gender'],
            'contact_number' => $patientDetails['mobile_number'],
            'email_address' => $patientDetails['email'],
            'complete_address' => $patientDetails['address'],
            'status' => 'pending',
            'user_id' => auth()->id(),
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
    public function downloadQRPdf($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);
    
        // Create QR code using transaction number
        $qrCode = new QrCode($appointment->transaction_number);// Use create() method for the new syntax
        $writer = new PngWriter();
    
        // Generate QR code image
        $qrCodeImage = $writer->write($qrCode);
    
        // Convert QR code binary to base64 string for embedding in PDF
        $qrCodeDataUri = 'data:image/png;base64,' . base64_encode($qrCodeImage->getString());
    
        // Generate PDF with QR code
        $pdf = Pdf::loadView('patient.qr-code', compact('appointment', 'qrCodeDataUri'));
        return $pdf->download('appointment_qr_code.pdf');
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


    public function appointmentuserEdit($id){
        $appointment = Appointment::findOrFail($id);
    
        // Pass the admin details to the view
        return view('patient.appointmentuserEdit', compact('appointment'));
    }

    public function appointmentuserUpdate(Request $request, $id)
    {
        // Validate the input data
    $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'visit_type' => 'required|string',
        'mobile_number' => 'required|string|max:15', // Matching form input
        'email_address' => 'required|email|max:255',
        'selected_date' => 'required|date', // Ensure the selected_date is provided and valid
        'appointment_time' => 'required|string|in:09:00 AM,09:30 AM,10:00 AM,10:30 AM,11:00 AM,11:30 AM', // Validate appointment time
    ]);

    // Convert the appointment time to the correct format for storage
    $validatedData['appointment_time'] = Carbon::createFromFormat('h:i A', $validatedData['appointment_time'])->format('H:i:s');

    // Find the appointment by ID
    $appointment = Appointment::findOrFail($id);

    // Store the old appointment date
    $oldDate = $appointment->appointment_date;

    // Update the appointment with the validated data
    $appointment->update([
        'appointment_date' => $validatedData['selected_date'],
        'first_name' => $validatedData['first_name'],
        'last_name' => $validatedData['last_name'],
        'visit_type' => $validatedData['visit_type'],
        'contact_number' => $validatedData['mobile_number'],
        'email_address' => $validatedData['email_address'],
        'appointment_time' => $validatedData['appointment_time'],
    ]);

    // Adjust the booked_slots if the date has changed
    if ($oldDate !== $request->selected_date) {
        // Decrement booked_slots for the old date
        $oldSlot = AppointmentSlot::where('appointment_date', $oldDate)->first();
        if ($oldSlot) {
            $oldSlot->decrement('booked_slots');
        }

        // Increment booked_slots for the new date
        $newSlot = AppointmentSlot::firstOrCreate(
            ['appointment_date' => $request->selected_date],
            ['total_slots' => 4] // Ensure default total slots are set
        );
        $newSlot->increment('booked_slots');
    }

    // Return success notification and redirect back
    notify()->success('Appointment updated successfully!');
    return redirect()->route('appointments.booked') // Adjust this route if needed
        ->with('success', 'Appointment updated successfully.');
}


    public function profileuserSettings()
    {
        return view('patient.userProfile');
    }

    public function profileuserUpdate(Request $request)
    {
        // Validate the input
        $request->validate([
            'date_of_birth'   => 'nullable|date',
            'phone_number'    => 'nullable|string|max:15',
            'address'         => 'nullable|string|max:255',
            'gender'          => 'nullable|in:male,female',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max for profile picture
            // 'status'          => 'required|in:active,inactive', // Add status validation
        ]);

        // Get the authenticated user
         /** @var User $user */
        $user = Auth::user();

        // Check if a profile picture is being uploaded
        if ($request->hasFile('profile_picture')) {
            // If the user already has a profile picture, delete the old one
            if ($user->profile_picture) {
                $oldImagePath = public_path('profile_pictures/' . $user->profile_picture);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Delete the old image from the public directory
                }
            }

            // Store the new profile picture in the public directory
            $filename = $user->id . '_' . time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('profile_pictures'), $filename);

            // Update the user with the new profile picture filename
            $user->profile_picture = $filename;
        }

        // Update the other user fields
        $user->update([
            'date_of_birth' => $request->date_of_birth,
            'phone_number'  => $request->phone_number,
            'address'       => $request->address,
            'gender'        => $request->gender,
            // 'status'        => $request->status, // Update the status field
        ]);

        // Redirect back with a success message
        notify()->success('Profile updated successfully!');
        return redirect()->back()->with('status', 'Profile updated successfully!');
    }

    public function securityuserSettings()
    {
        return view('patient.userSecurity');
    }

    public function securityuserUpdate(Request $request)
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

    public function changeuserPassword(Request $request){
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
    public function accountDelete(){
            /** @var User $user */
        $user = Auth::user();
        $user->delete();

        Auth::logout();
        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }

    public function contactSend(Request $request)
    {
        // Validate the form data
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        // Send the email
        Mail::to('quintom53@gmail.com')->send(new ContactMessage($request->all()));

        // Return a response
        notify()->success('Message sent successfully!');
        return back()->with('success', 'Your message has been sent successfully.');
    }

    public function aboutMore() {

        $images = [
            asset('images/pic1.jpg'),
            asset('images/pic2.jpg'),
            asset('images/pic3.jpg'),
            asset('images/pic3.jpg'),
        ];

        return view('appointment.aboutMore', compact('images'));
    }
}
