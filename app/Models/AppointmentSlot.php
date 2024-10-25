<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_date',
        'total_slots',
        'booked_slots',
    ];

    // Example of a method to check availability
    public function isAvailable()
    {
        return $this->booked_slots < $this->total_slots;
    }

    // If you later decide to add a relationship
    // public function appointments()
    // {
    //     return $this->hasMany(Appointment::class);
    // }
}

