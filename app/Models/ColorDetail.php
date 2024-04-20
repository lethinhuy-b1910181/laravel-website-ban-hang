<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorDetail extends Model
{
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function khoHang()
    {
        return $this->hasMany(KhoHang::class, 'color_id', 'color_id');
    }
    use HasFactory;
}
