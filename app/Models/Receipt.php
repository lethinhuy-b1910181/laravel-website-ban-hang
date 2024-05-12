<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    public function products()
    {
        return $this->belongsToMany(Product::class, 'receipt_products', 'receipt_id', 'product_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    
    use HasFactory;
}
