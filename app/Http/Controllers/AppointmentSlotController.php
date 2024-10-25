<?php

namespace App\Http\Controllers;
use App\Models\AppointmentSlot;
use Illuminate\Http\Request;

class AppointmentSlotController extends Controller
{
    public function getMonthlySlots(Request $request)
    {
        $month = $request->query('month'); // Expected format: 'YYYY-MM'
        $slots = AppointmentSlot::where('appointment_date', 'like', "$month%")->get();

        $formattedSlots = $slots->map(function ($slot) {
            $status = $slot->booked_slots >= $slot->total_slots ? 'fully_booked' : 
                      ($slot->booked_slots > 0 ? 'partially_booked' : 'available');
            
            return [
                'date' => $slot->appointment_date,
                'status' => $status,
                'available_slots' => $slot->total_slots - $slot->booked_slotsks
            ];
        });

        return response()->json($formattedSlots);
    }
}
