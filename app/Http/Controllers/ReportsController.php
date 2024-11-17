<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Carbon\Carbon;


class ReportsController extends Controller
{


    public function reports(){
        // Get the count of male and female appointments
        $maleCount = Appointment::where('gender', 'male')->count();
        $femaleCount = Appointment::where('gender', 'female')->count();
    
        // Get the total count of appointments to calculate the percentages
        $totalCount = $maleCount + $femaleCount;
    
        // Calculate the percentages
        $malePercentage = $totalCount > 0 ? ($maleCount / $totalCount) * 100 : 0;
        $femalePercentage = $totalCount > 0 ? ($femaleCount / $totalCount) * 100 : 0;
    
        // Pass data to the view
        return view('appointment.reports', compact('malePercentage', 'femalePercentage', 'maleCount', 'femaleCount'));
    }
}
