<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
class MedicalController extends Controller
{
    public function medicalcert(Request $request){
        $search = $request->input('search');

    // Query appointments with search functionality
    $appointments = Appointment::where('status', 'completed') // Only retrieve completed appointments
        ->where('additional', 'Medical Certificate') // Filter for appointments with a medical certificate
        ->when($search, function($query) use ($search) {
            // Apply search criteria only to the completed appointments with medical certificates
            $query->where(function($subQuery) use ($search) {
                $subQuery->where('first_name', 'like', '%' . $search . '%')
                         ->orWhere('last_name', 'like', '%' . $search . '%')
                         ->orWhere('doctor', 'like', '%' . $search . '%')
                         ->orWhere('visit_type', 'like', '%' . $search . '%');
            });
        })
        ->paginate(10); // Pagination with 10 rows per page

    $totalAppointments = Appointment::where('status', 'completed')
                                     ->where('additional', 'Medical Certificate') // Count only completed appointments with medical certificates
                                     ->count();

    // Pass the appointments data and total count to the view
    return view('appointment.medicalCertificate', compact('appointments', 'totalAppointments', 'search'));
    }

    public function medicalcertPrint($id) {
        $appointment = Appointment::findOrFail($id);
    
        // Calculate age from the date of birth
        $dateOfBirth = Carbon::parse($appointment->date_of_birth);
        $age = $dateOfBirth->age; // Calculate age
    
        // Prepare data for the PDF, including the appointment object
        $data = [
            'appointment' => $appointment, // Pass the whole appointment object
            'appointment_date' => $appointment->appointment_date,
            'appointment_time' => $appointment->appointment_time,
            'patient_name' => $appointment->first_name . ' ' . $appointment->last_name,
            'date_of_birth' => $appointment->date_of_birth,
            'age' => $age,
            'gender' => $appointment->gender,
            'address' => $appointment->complete_address,
            'diagnosis' => $appointment->diagnosis,
            'notes' => $appointment->notes,
        ];
    
        // Load the view and generate the PDF
        $pdf = PDF::loadView('appointment.medicalPrint', $data);
    
        // Download the PDF
        return $pdf->download('medical_certificate_' . $appointment->id . '.pdf');
    }

    public function medicalDownload($id){
        $appointment = Appointment::findOrFail($id);
    
        // Calculate age from the date of birth
        $dateOfBirth = Carbon::parse($appointment->date_of_birth);
        $age = $dateOfBirth->age; // Calculate age
    
        // Prepare data for the PDF, including the appointment object
        $data = [
            'appointment' => $appointment, // Pass the whole appointment object
            'appointment_date' => $appointment->appointment_date,
            'appointment_time' => $appointment->appointment_time,
            'patient_name' => $appointment->first_name . ' ' . $appointment->last_name,
            'date_of_birth' => $appointment->date_of_birth,
            'age' => $age,
            'gender' => $appointment->gender,
            'address' => $appointment->complete_address,
            'diagnosis' => $appointment->diagnosis,
            'notes' => $appointment->notes,
        ];
    
        // Load the view and generate the PDF
        $pdf = PDF::loadView('appointment.medicalPrint', $data);
    
        // Download the PDF
        return $pdf->download('medical_certificate_' . $appointment->id . '.pdf');
    }
    
}
