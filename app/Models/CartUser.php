<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartUser extends Model
{

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    use HasFactory;
}
