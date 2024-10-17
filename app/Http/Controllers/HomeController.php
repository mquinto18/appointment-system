<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function adminIndex() {
        $totalUsers = User::count();
        $totalAppointment = Appointment::count();
        
        $appointments = Appointment::paginate(10); // Paginate appointments by 10
        
        $totalAmount = 0;
        $totalCompleted = 0; 
        
        foreach ($appointments as $appointment) {
            $amounts = json_decode($appointment->amount, true); 
    
            // Sum the decoded amounts
            if (is_array($amounts)) {
                $totalAmount += array_sum($amounts);
            } elseif (is_numeric($appointment->amount)) {
                $totalAmount += $appointment->amount;
            }
    
            if ($appointment->status === 'completed') {
                $totalCompleted++;
            }
        }
    
        $totalAmount = number_format($totalAmount, 2, '.', ',');
    
        // Ensure 'appointments' is passed to the view
        return view('dashboard', compact('totalUsers', 'totalAppointment', 'totalAmount', 'totalCompleted', 'appointments'));
    }
    
    
    
    

    public function profileSettings(){
        return view('components.profile');
    }

    public function securitySettings(){
        return view('components.security');
    }
}
