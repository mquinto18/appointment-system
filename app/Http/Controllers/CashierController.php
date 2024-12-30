<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Appointment;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;    
use Illuminate\Http\Request;

class CashierController extends Controller
{

    public function cashierIndex(){
        $totalUsers = User::count();
        $totalAppointment = Appointment::count();
    
        $appointments = Appointment::where('status', 'completed') // Filter for completed appointments
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
            $ratingsData[$i] = $ratings[$i] ?? 0; // Default to 0 if no ratings for that star
        }
    
        return view('cashier', compact(
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


    public function CashierAcc(Request $request)
    {
        // Fetch the search input from the request (if any)
        $searchCashier= $request->input('searchCashier');

        // Fetch the admins with pagination (5 per page) and apply search if necessary
        $users = User::where('type', '3') // Assuming 'type' 1 is Admin
                    ->when($searchCashier, function ($query, $searchCashier) {
                        return $query->where('name', 'like', "%{$searchCashier}%")
                                    ->orWhere('email', 'like', "%{$searchCashier}%");
                    })
                    ->paginate(5);

        // Count total admins (for the header)
        $totalUsers = User::where('type', '3')->count();

        // Pass the paginated admins and total count to the view
        return view('components.cashier', compact('users', 'totalUsers', 'searchCashier'));
    }

    
    public function cashierSave(Request $request){
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
            'type' => "3"
        ]);

        notify()->success('Cashier added successfully!');
        return redirect()->back()->with('success', 'User added successfully.');
    }

    public function invoiceCashier(Request $request){
        $search = $request->input('search');
    
        // Query appointments with search functionality
        $appointments = Appointment::where('status', 'completed') // Only retrieve completed appointments
            ->when($search, function($query) use ($search) {
                // Apply search criteria only to the completed appointments
                $query->where(function($subQuery) use ($search) {
                    $subQuery->where('first_name', 'like', '%' . $search . '%')
                             ->orWhere('last_name', 'like', '%' . $search . '%')
                             ->orWhere('doctor', 'like', '%' . $search . '%')
                             ->orWhere('visit_type', 'like', '%' . $search . '%');
                });
            })
            ->paginate(10); // Pagination with 10 rows per page
    
        $totalAppointments = Appointment::where('status', 'completed')->count(); // Count total number of completed appointments
    
        // Pass the appointments data and total count to the view
        return view('appointment.cashierinvoice', compact('appointments', 'totalAppointments', 'search'));
    }

    public function cashierinvoicePrint($id){
        $appointment = appointment::findOrFail($id);
    
        // Pass the admin details to the view
        return view('appointment.cashierinvoicePrint', compact('appointment'));
    }
    

    public function cashierinvoiceSave(Request $request, $id)
    {
        $validatedData = $request->validate([
            'amount' => 'array',
            'amount.*' => 'numeric',
            'descriptions' => 'array',
            'descriptions.*' => 'string',
            'qty' => 'array',
            'qty.*' => 'integer|min:1',
            'discount' => 'required|integer|min:0|max:50', // Validate discount value
        ]);
    
        $appointment = Appointment::findOrFail($id);
        $appointment->amount = json_encode($validatedData['amount']); // Store as JSON
        $appointment->descriptions = json_encode($validatedData['descriptions']); // Store as JSON
        $appointment->qty = json_encode($validatedData['qty']); // Store as JSON
        $appointment->discount = $validatedData['discount']; // Store discount
        $appointment->save();
    
        notify()->success('Data saved successfully!');
        return redirect()->to("cashier/invoice/print/{$appointment->id}")->with('success', 'Invoice saved successfully.');
    }

    public function cashierprintInvoice($id)
    {
        $appointment = Appointment::findOrFail($id);
    
        // Fetch the invoice details from the appointment
        $descriptions = json_decode($appointment->descriptions) ?? [];
        $quantities = json_decode($appointment->qty) ?? [];
        $amounts = json_decode($appointment->amount) ?? [];
    
        // Fetch additional appointment details
        $transaction_number = $appointment->transaction_number;
        $first_name = $appointment->first_name;
        $last_name = $appointment->last_name;
        $appointment_date = $appointment->appointment_date;
        $appointment_time = $appointment->appointment_time;
        $contact_number = $appointment->contact_number;
        $complete_address = $appointment->complete_address;
    
        // Calculate the total amount
        $totalAmount = array_sum($amounts);
    
        // Apply discount if available
        $discount = $appointment->discount ?? 0; // Get discount percentage, default is 0
        $discountedAmount = $totalAmount - ($totalAmount * ($discount / 100));
    
        // Pass the data to the view
        $pdf = Pdf::loadView('appointment.invoice-pdf', compact(
            'appointment', 
            'descriptions', 
            'quantities', 
            'amounts', 
            'transaction_number',
            'first_name', 
            'last_name',
            'appointment_date',
            'appointment_time',
            'contact_number',
            'complete_address',
            'totalAmount',
            'discount',
            'discountedAmount'
        ));
    
        // Return the generated PDF as a download
        return $pdf->download('invoice_' . $appointment->id . '.pdf');
    }

    
}
