<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product\OrderItem;

class Order extends Model
{
    protected $table = 'orders'; // Ensure this matches your database table
    protected $fillable = [
        'firstname', 'lastname', 'country', 'state', 'street_address',
        'street_address1', 'towncity', 'postcodezip', 'phone', 'email',
        'total_price', 'paymentMethod', 'user_id'
    ];

    public $timestamps = true;
    // Define the relationship with OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class); // An order has many order items
    }
}

