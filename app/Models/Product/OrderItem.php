<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $table = 'order_items'; // Ensure this matches your database table
    protected $fillable = [
        'order_id', 'product_name', 'quantity', 'price', 'total_price'
    ];

    public $timestamps = true;

    // Define the inverse relationship to Order
    public function order()
    {
        return $this->belongsTo(Order::class); // Each order item belongs to an order
    }
}
