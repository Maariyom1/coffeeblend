<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppInfo extends Model
{
    use HasFactory;
    protected $table = "appinfo";

    protected $fillable = [
        "id",
        "name",
        "address",
        "phone",
        "email",
        "website",
    ];

    public $timestamps = true;
}
