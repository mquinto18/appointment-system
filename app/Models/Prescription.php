<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'user_id', 
        'drugname', 
        'dosage', 
        'qty'
    ];

    // Casts the JSON fields to arrays automatically
    protected $casts = [
        'drugname' => 'array',
        'dosage' => 'array',
        'qty' => 'array',
    ];
}
