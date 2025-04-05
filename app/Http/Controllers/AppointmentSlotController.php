<?php

namespace App\Http\Controllers;

use App\Models\AppointmentSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentSlotController extends Controller
{
    public function getMonthlySlots(Request $request)
    {
        $month = $request->input('month'); // Get the month from the request (e.g., '2024-11')

        // Retrieve the appointment slots for the given month
        $slots = AppointmentSlot::whereBetween('appointment_date', [
            Carbon::parse($month)->startOfMonth(),
            Carbon::parse($month)->endOfMonth(),
        ])->get();  

        // Map the slot data into a format that FullCalendar can use
        $events = $slots->map(function ($slot) {
            $remaining_slots = $slot->total_slots - $slot->booked_slots;
            $status = $remaining_slots <= 0 ? 'fully_booked' : 'available';

            return [
                'title' => $status === 'fully_booked' ? 'Fully Booked' : $remaining_slots . ' Slot' . ($remaining_slots > 1 ? 's' : '') . ' Available',
                'start' => $slot->appointment_date,
                'className' => $status, // Use the status to apply different styles
                'available_slots' => $remaining_slots,
                'status' => $status,
                'date' => $slot->appointment_date, // Return the date for frontend comparison
            ];
        });

        return response()->json($events);
    }
}