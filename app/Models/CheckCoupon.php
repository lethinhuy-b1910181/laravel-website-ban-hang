<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckCoupon extends Model
{
    use HasFactory;

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'coupon_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(OrderTotal::class, 'order_id', 'id');
    }
}
