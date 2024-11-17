<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    // Only the 'rating' field is required now, as there's no 'appointment_id'
    protected $fillable = ['rating'];

    // No need for a relationship method anymore since there's no appointment_id
}
