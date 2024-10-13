<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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

    public function invoicePrint($id){
        $appointment = appointment::findOrFail($id);
    
        // Pass the admin details to the view
        return view('appointment.invoicePrint', compact('appointment'));
    }
}
