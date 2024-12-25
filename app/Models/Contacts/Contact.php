<?php

namespace App\Models\Contacts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contacts'; // Ensure this matches your database table
    protected $fillable = [
        'name', 'email', 'subject', 'message'
    ];

    public $timestamps = true;
}
