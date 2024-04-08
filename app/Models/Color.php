<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    public function products()
    {
        return $this->belongsToMany(Product::class, 'color_details', 'color_id', 'product_id');
    }
    use HasFactory;
}
