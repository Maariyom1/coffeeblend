<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = "cart";

    protected $fillable = [
        "pro_id",
        "name",
        "image",
        "price",
        "description",
        "user_id",
        "quantity"
    ];

    public $timestamps = true;
}
