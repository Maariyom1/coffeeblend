<?php

namespace App\Models\Bookings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'bookings'; // Ensure this matches your database table
    protected $fillable = [
        'firstname', 'lastname', 'date', 'time', 'phone', 'message'
    ];

    public $timestamps = true;
}
