<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;    
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DoctorController extends Controller
{

   public function doctorIndex()
{
    $totalUsers = User::count();
    $totalAppointment = Appointment::count();

    // Get the current logged-in doctor's name
    $doctorName = auth()->user()->name; // Assuming the doctor is logged in

    // Set the current time to Philippine Time
    $currentDateTime = now('Asia/Manila');

    // Fetch appointments that are completed and assigned to the logged-in doctor by their name
    $appointments = Appointment::where('status', 'completed')
        ->where('doctor', $doctorName) // Match by doctor name
        ->paginate(5);

    $appointmentsAll = Appointment::all();
    $totalAmount = 0;
    $totalCompleted = Appointment::where('status', 'completed')->count();

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
        $ratingsData[$i] = $ratings[$i] ?? 0;
    }

    // Calculate new and old appointments
    $newAppointments = Appointment::where('created_at', '>=', now()->subDays(30))->count(); // Last 30 days
    $oldAppointments = $totalAppointment - $newAppointments; // Remaining are old appointments

    // Ongoing patient details with 5-minute condition
    $ongoingPatient = Appointment::where('status', 'pending')
        ->where('appointment_date', $currentDateTime->toDateString())
        ->whereBetween('appointment_time', [
            $currentDateTime->toTimeString(), // From now
            $currentDateTime->addMinutes(10)->toTimeString() // Until 5 minutes later
        ])
        ->first();

    return view('doctor', compact(
        'totalUsers',
        'totalAppointment',
        'totalAmount',
        'totalCompleted',
        'appointments',
        'appointmentsAll',
        'monthlyEarnings',
        'statusCounts',
        'ratingsData',
        'newAppointments',
        'oldAppointments',
        'ongoingPatient'
    ));
}



    
    

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

    public function doctorAppointment(Request $request)
    {
        $doctorName = auth()->user()->name; // Get the authenticated doctor's name
        $search = $request->input('search');

        // Query appointments with search functionality and filter by doctor and status
        $appointments = Appointment::where('doctor', $doctorName)
            ->where('status', 'completed') // Filter for completed appointments
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('visit_type', 'like', '%' . $search . '%');
                }
            })
            ->paginate(10); // Pagination with 10 rows per page

        $totalAppointments = Appointment::where('doctor', $doctorName)
            ->where('status', 'completed')
            ->count(); // Count total number of completed appointments for the specific doctor

        // Pass the appointments data and total count to the view
        return view('appointment.doctorTotalAppointment', compact('appointments', 'totalAppointments', 'search'));
    }

    public function appointmentdoctorDelete($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        // Redirect back with a success message
        notify()->success('Appointment deleted successfully!');
        return redirect()->route('doctorAppointment')->with('success', 'Appointment deleted successfully!');
    }

    public function profiledoctorSettings()
    {
        return view('components.doctorProfile');
    }

    public function profiledoctorUpdate(Request $request)
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
            'status'        => $request->status, // Update the status field
        ]);

        // Redirect back with a success message
        notify()->success('Profile updated successfully!');
        return redirect()->back()->with('status', 'Profile updated successfully!');
    }

    public function securitydoctorSettings()
    {
        return view('components.cashierDoctorSecurity');
    }

    public function securitydoctorUpdate(Request $request)
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

    public function accountDelete(Request $request){
        /** @var User $user */
        $user = Auth::user();
        $user->delete();
    
        Auth::logout();
        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }
}
