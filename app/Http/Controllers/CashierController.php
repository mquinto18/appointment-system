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
use Spatie\SimpleExcel\SimpleExcelWriter;
use Illuminate\Support\Facades\File;

class CashierController extends Controller
{

    public function cashierIndex()
    {
        $totalUsers = User::count();
        $totalAppointment = Appointment::count();
        $appointments = Appointment::where('status', 'completed')->paginate(5);
        $appointmentsAll = Appointment::all();
        $totalAmount = 0;
        $totalCompleted = Appointment::where('status', 'completed')->count();

        // Get today's date
        $today = \Carbon\Carbon::today();

        // Fetch only completed appointments updated today
        $completedAppointments = Appointment::where('status', 'approved')
            ->whereDate('updated_at', $today) // Filter by today's date
            ->orderBy('updated_at', 'desc')
            ->get();

        $monthlyEarnings = [];

        foreach ($appointments as $appointment) {
            $amounts = json_decode($appointment->amount, true);

            if (is_array($amounts)) {
                $appointmentTotal = array_sum($amounts);
                $totalAmount += $appointmentTotal;
            } elseif (is_numeric($appointment->amount)) {
                $appointmentTotal = $appointment->amount;
                $totalAmount += $appointment->amount;
            } else {
                $appointmentTotal = 0;
            }

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

        $ratings = DB::table('ratings')
            ->select('rating', DB::raw('COUNT(*) as count'))
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        $ratingsData = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingsData[$i] = $ratings[$i] ?? 0;
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
            'ratingsData',
            'completedAppointments' // Pass only today's completed appointments to the view
        ));
    }

    public function CashierAcc(Request $request)
    {
        // Fetch the search input from the request (if any)
        $searchCashier = $request->input('searchCashier');

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


    public function cashierSave(Request $request)
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
            'type' => "3"
        ]);

        notify()->success('Cashier added successfully!');
        return redirect()->back()->with('success', 'User added successfully.');
    }

    public function invoiceCashier(Request $request)
    {
        $search = $request->input('search');
        $recordsPerPage = $request->input('records_per_page', 10); // Default to 10 records per page

        // Query appointments with search functionality
        $appointments = Appointment::whereIn('status', ['approved', 'completed']) // Correct way to check multiple statuses
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]) // Search full name
                        ->orWhere('doctor', 'like', '%' . $search . '%')
                        ->orWhere('visit_type', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('appointment_date', 'desc') // Sort by latest appointment date
            ->orderBy('appointment_time', 'desc') // Sort by latest appointment time
            ->paginate($recordsPerPage); // Dynamic pagination

        $totalAppointments = Appointment::whereIn('status', ['approved', 'completed'])->count(); // Count both statuses

        return view('appointment.cashierinvoice', compact('appointments', 'totalAppointments', 'search', 'recordsPerPage'));
    }





    public function cashierinvoicePrint($id)
    {
        $appointment = appointment::findOrFail($id);

        // Pass the admin details to the view
        return view('appointment.cashierinvoicePrint', compact('appointment'));
    }


    public function cashierinvoiceSave(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_number' => 'nullable|string|max:255',
            'id_type' => 'nullable|string|in:PWD,Senior Citizen',
            'amount' => 'required|array',
            'amount.*' => 'required|numeric',
            'descriptions' => 'required|array',
            'descriptions.*' => 'required|string',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
            'discount' => 'nullable|integer|min:0|max:50',
        ]);

        // Find appointment
        $appointment = Appointment::findOrFail($id);

        $appointment->id_number = $validatedData['id_number'] ?? null;
        $appointment->id_type = $validatedData['id_type'] !== "0" ? $validatedData['id_type'] : null;
        $appointment->amount = json_encode($validatedData['amount']);
        $appointment->descriptions = json_encode($validatedData['descriptions']);
        $appointment->qty = json_encode($validatedData['qty']);
        $appointment->discount = is_numeric($validatedData['discount']) ? (int) $validatedData['discount'] : 0;

        // ✅ Set status to completed
        $appointment->status = 'completed';

        $appointment->save();

        // Notify user and redirect
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
        $id_number = $appointment->id_number;
        $id_type = $appointment->id_type;
    
        // Calculate the total amount
        $totalAmount = 0;
        foreach ($amounts as $index => $amount) {
            $qty = $quantities[$index] ?? 1;
            $totalAmount += $amount * $qty;
        }
    
        // Apply discount if available
        $discount = $appointment->discount ?? 0;
        $discountAmount = $totalAmount * ($discount / 100);
        $discountedAmount = $totalAmount - $discountAmount;
    
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
            'discountAmount',
            'discountedAmount',
            'id_number',
            'id_type'
        ));
    
        return $pdf->download('invoice_' . $appointment->id . '.pdf');
    }
    

    public function cashierprintReports($interval)
    {
        $appointments = Appointment::query();

        // Set the date range based on the interval
        switch ($interval) {
            case 'weekly':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                $appointments->whereBetween('appointment_date', [$startDate, $endDate]);
                $dateRange = "From " . $startDate->toFormattedDateString() . " to " . $endDate->toFormattedDateString();
                break;

            case 'monthly':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                $appointments->whereBetween('appointment_date', [$startDate, $endDate]);
                $dateRange = "From " . $startDate->toFormattedDateString() . " to " . $endDate->toFormattedDateString();
                break;

            case 'yearly':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                $appointments->whereBetween('appointment_date', [$startDate, $endDate]);
                $dateRange = "From " . $startDate->toFormattedDateString() . " to " . $endDate->toFormattedDateString();
                break;

            default:
                $appointments = Appointment::all();
                $dateRange = "All Time";
                break;
        }

        // Retrieve the appointments
        if ($interval !== 'default') {
            $appointments = $appointments->get();
        }

        // Ensure the directory exists
        $storagePath = storage_path('reports');
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true); // Create the directory if it doesn't exist
        }

        // Generate Excel file
        $filePath = $storagePath . '/appointments_' . time() . '.xlsx';
        $writer = SimpleExcelWriter::create($filePath, 'xlsx');

        // Add header row
        $writer->addHeader([
            'ID',
            'PATIENT NAME',
            'GENDER',
            'APPOINTMENT DATE',
            'VISIT TYPE',
            'AMOUNT',
            'DISCOUNT',
            'TOTAL AMOUNT',
        ]);

        $totalSales = 0;

        // Add data rows
        foreach ($appointments as $appointment) {
            // Decode amount to an array and calculate total amount
            $amount = json_decode($appointment->amount, true);
            $totalAmount = is_array($amount) ? array_sum($amount) : 0;

            // Get discount and calculate the discount amount
            $discount = $appointment->discount ?? 0;
            $discountAmount = ($totalAmount * $discount) / 100;

            // Calculate the final amount after discount
            $finalAmount = $totalAmount - $discountAmount;

            // Add to total sales
            $totalSales += $finalAmount;

            // Add row to the Excel file
            $writer->addRow([
                $appointment->id,
                $appointment->first_name . ' ' . $appointment->last_name,
                ucfirst($appointment->gender),
                Carbon::parse($appointment->appointment_date)->toFormattedDateString(),
                $appointment->visit_type,
                number_format($totalAmount, 2),
                $discount . '%',
                number_format($finalAmount, 2),
            ]);
        }

        // Add total sales row at the bottom
        $writer->addRow([
            '',
            '',
            '',
            '',
            '',
            '',
            'Total Sales:',
            number_format($totalSales, 2),
        ]);


        // Return Excel file for download
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function cashierEdit($id)
    {
        $user = User::findOrFail($id);

        // Pass the admin details to the view
        return view('components.cashierEdit', compact('user'));
    }

    public function cashierUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string',
            'address' => 'nullable|string',
            'status'  => 'required|in:active,inactive',
        ]);

        // Update the admin details
        $user->update($request->all());

        // Redirect back with success message
        notify()->success('Cashier updated successfully!');
        return redirect()->route('cashier')->with('success', 'User updated successfully.');
    }
}
