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
        return $this->belongsTo(Color::class, 'product_id', 'id');
    }

    use HasFactory;
}
