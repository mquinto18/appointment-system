<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Appointment;
class InvoiceController extends Controller
{
    public function invoice(Request $request) {
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
        return view('appointment.invoice', compact('appointments', 'totalAppointments', 'search'));
    }

    public function invoicePrint($id) {
        $appointment = Appointment::findOrFail($id);
        return view('appointment.invoicePrint', compact('appointment'));
    }

    public function invoiceSave(Request $request, $id)
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
        return redirect()->to("admin/invoice/print/{$appointment->id}")->with('success', 'Invoice saved successfully.');
    }
    public function printInvoice($id)
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
