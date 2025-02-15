<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Carbon\Carbon;


class ReportsController extends Controller
{


    public function reports(Request $request)
{
    // Retrieve filter inputs
    $year = $request->input('filter-year');
    $month = $request->input('filter-month');
    $visitType = $request->input('visit_type'); // Corrected key

    // Start building the query
    $query = Appointment::query();

    // Apply year filter if provided
    if ($year) {
        $query->whereYear('appointment_date', $year);
    }

    // Apply month filter if provided
    if ($month) {
        $query->whereMonth('appointment_date', $month);
    }

    // Apply visit_type filter if provided
    if ($visitType) {
        $query->where('visit_type', $visitType);
    }

    // Fetch the filtered or all appointments
    $appointments = $query->get();

    // Initialize total sales
    $totalSales = 0;

    // Loop through each appointment and sum the 'amount' values
    foreach ($appointments as $appointment) {
        // Decode the JSON 'amount' field
        $amount = json_decode($appointment->amount, true);

        // Check if the 'amount' contains valid data and is an array
        if (is_array($amount)) {
            foreach ($amount as $value) {
                // Sum the amount values (adjust this if the structure is different)
                $totalSales += intval($value);
            }
        }
    }

    // Get the count of male and female appointments from the filtered appointments
    $maleCount = $appointments->where('gender', 'male')->count();
    $femaleCount = $appointments->where('gender', 'female')->count();

    // Get the total count of appointments to calculate the percentages
    $totalCount = $maleCount + $femaleCount;

    // Calculate the percentages
    $malePercentage = $totalCount > 0 ? number_format(($maleCount / $totalCount) * 100, 2) : 0;
    $femalePercentage = $totalCount > 0 ? number_format(($femaleCount / $totalCount) * 100, 2) : 0;

    // Calculate age distribution
    $ageRanges = [
        '0-10' => 0,
        '11-20' => 0,
        '21-30' => 0,
        '31-40' => 0,
        '41-50' => 0,
        '51-60' => 0,
        '61-70' => 0,
        '71-80' => 0,
        '81-90' => 0,
    ];

    // Loop through each appointment and calculate the age
    foreach ($appointments as $appointment) {
        if ($appointment->date_of_birth) { // Ensure date_of_birth is not null
            $age = Carbon::parse($appointment->date_of_birth)->age; // Calculate age using Carbon

            // Categorize age into ranges
            if ($age >= 0 && $age <= 10) {
                $ageRanges['0-10']++;
            } elseif ($age >= 11 && $age <= 20) {
                $ageRanges['11-20']++;
            } elseif ($age >= 21 && $age <= 30) {
                $ageRanges['21-30']++;
            } elseif ($age >= 31 && $age <= 40) {
                $ageRanges['31-40']++;
            } elseif ($age >= 41 && $age <= 50) {
                $ageRanges['41-50']++;
            } elseif ($age >= 51 && $age <= 60) {
                $ageRanges['51-60']++;
            } elseif ($age >= 61 && $age <= 70) {
                $ageRanges['61-70']++;
            } elseif ($age >= 71 && $age <= 80) {
                $ageRanges['71-80']++;
            } elseif ($age >= 81 && $age <= 90) {
                $ageRanges['81-90']++;
            }
        }
    }

    // Calculate service usage
    $services = [
        'Medical Consultation' => 0,
        'Pediatric Consultation' => 0,
        'Pediatric Ears, Nose and Throat' => 0,
        'Adult Ears, Nose and Throat' => 0,
        'Minor Suturing' => 0,
        'Wound Dressing' => 0,
    ];

    // Count the service usage based on visit_type
    foreach ($appointments as $appointment) {
        if (isset($services[$appointment->visit_type])) {
            $services[$appointment->visit_type]++;
        }
    }

    // Pass data to the view
    return view('appointment.reports', compact(
        'malePercentage',
        'femalePercentage',
        'maleCount',
        'femaleCount',
        'ageRanges',
        'services',
        'totalSales',
        'appointments', // Pass the appointments data to the view
        'year', // Pass the selected year to the view
        'month', // Pass the selected month to the view
        'visitType' // Pass the selected visit_type to the view
    ));
}




    
}
