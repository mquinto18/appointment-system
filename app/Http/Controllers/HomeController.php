<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
    
        $appointments = Appointment::paginate(3);
        $appointmentsAll = Appointment::all();
        $totalAmount = 0;
        $totalCompleted = 0;
    
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
    
            if ($appointment->status === 'completed') {
                $totalCompleted++;
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
        // Pass the earnings data to the view
        return view('dashboard', compact('totalUsers', 'totalAppointment', 'totalAmount', 'totalCompleted', 'appointments','appointmentsAll', 'monthlyEarnings', 'statusCounts'));
    }
    
    
    
    
    

    public function profileSettings(){
        return view('components.profile');
    }

    public function securitySettings(){
        return view('components.security');
    }
}
