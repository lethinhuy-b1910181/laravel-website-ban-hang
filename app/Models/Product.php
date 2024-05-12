<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'color_details', 'product_id', 'color_id');
    } 
    public function receipts()
    {
        return $this->belongsToMany(Receipt::class, 'receipt_products', 'product_id', 'receipt_id');
    }

    public function orders()
    {
        return $this->belongsToMany(OrderTotal::class, 'order_product');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productImage(){
        return $this->hasMany(ProductImage::class);
    }

    public function receiptDetails()
    {
        return $this->hasMany(ReceiptDetail::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    use HasFactory;

    
}


