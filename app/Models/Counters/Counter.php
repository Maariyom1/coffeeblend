<?php

namespace App\Models\Counters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;
    protected $table = 'counter';
    protected $fillable = [
        'icon_class', 'count', 'name'
    ];

    public $timestamps = true;
}
