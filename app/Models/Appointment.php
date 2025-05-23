<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_number',
        'first_name',
        'last_name',
        'date_of_birth',
        'appointment_date',
        'appointment_time',
        'visit_type',
        'additional',
        'doctor',
        'gender',
        'marital_status',
        'contact_number',
        'email_address',
        'complete_address',
        'amount',
        'discount',
        'id_number',
        'id_type',
        'follow_up',
        'status',
        'notes',
        'description', // Add this if you want to store the invoice description
        'qty', // If you want to save quantity
        'drugname',
        'dosage',
        'doctorqty',
        'diagnosis',
        'user_id', // Added user_id to the fillable fields
        // Add other fields as necessary
    ];
    


}
