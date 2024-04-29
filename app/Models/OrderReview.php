<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderReview extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(OrderTotal::class, 'order_id', 'id');
    }
}
