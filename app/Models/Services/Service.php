<?php

namespace App\Models\Services;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services'; // Ensure this matches your database table
    protected $fillable = [
        'icon_class', 'name', 'description'
    ];
}
