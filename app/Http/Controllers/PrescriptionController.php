<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Prescription;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
class PrescriptionController extends Controller
{
    public function prescription(Request $request){
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
        return view('appointment.prescription', compact('appointments', 'totalAppointments', 'search'));
    }

    public function prescriptionPrint($id){
        $appointment = appointment::findOrFail($id);
        return view('appointment.prescriptionPrint', compact('appointment'));
    }

    public function prescriptionSave(Request $request, $id)
{
    \Log::info($request->all()); // Log all incoming request data

    // Validate the incoming request data
    $validatedData = $request->validate([
        'drugname' => 'array|required',
        'drugname.*' => 'string|max:255',
        'dosage' => 'array|required',
        'dosage.*' => 'string|max:255',
        'doctorqty' => 'array|required', // Updated validation rule
        'doctorqty.*' => 'integer|min:1', // Updated validation rule
        'diagnosis' => 'string|max:255|required', // Add diagnosis validation
    ]);

    // Find the appointment by ID
    $appointment = Appointment::findOrFail($id);

    // Store the validated data in the appointment model
    $appointment->drugname = json_encode($validatedData['drugname']);
    $appointment->dosage = json_encode($validatedData['dosage']);
    $appointment->doctorqty = json_encode($validatedData['doctorqty']); // Store doctorqty
    $appointment->diagnosis = $validatedData['diagnosis']; // Store the diagnosis
    $appointment->save(); // Save the updated appointment

    notify()->success('Prescription saved successfully!');
    return redirect()->to("admin/prescription/print/{$appointment->id}")->with('success', 'Prescription saved successfully.');
}

    public function printPrescription($id)
    {
    $appointment = Appointment::findOrFail($id);

    // Fetch the invoice details from the appointment
    $drugname = json_decode($appointment->drugname) ?? [];
    $dosage = json_decode($appointment->dosage) ?? [];
    $doctorqty = json_decode($appointment->doctorqty) ?? [];
    }

}
