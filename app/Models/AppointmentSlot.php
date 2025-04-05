<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AppointmentSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_date',
        'time',
        'total_slots',
        'booked_slots',
    ];

    /**
     * Check if there are available slots for booking.
     */
    public function isAvailable(): bool
    {
        return $this->booked_slots < $this->total_slots;
    }

    /**
     * Book a slot if available. Returns true on success, false on failure.
     */
    public function bookSlot(): bool
    {
        if ($this->isAvailable()) {
            $this->increment('booked_slots');
            return true;
        }
        
        return false;
    }

    /**
     * Release a booked slot.
     */
    public function releaseSlot(): bool
    {
        if ($this->booked_slots > 0) {
            $this->decrement('booked_slots');
            return true;
        }

        return false;
    }

    /**
     * Scope a query to only include available slots.
     */
    public function scopeAvailable($query)
    {
        return $query->whereColumn('booked_slots', '<', 'total_slots');
    }

    /**
     * Relationship to appointments (if you have an appointments table).
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
