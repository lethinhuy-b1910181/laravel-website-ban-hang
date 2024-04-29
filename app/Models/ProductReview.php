<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(OrderTotal::class, 'order_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
