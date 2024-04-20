<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhoHang extends Model
{
    use HasFactory;

    public function colorDetail()
    {
        return $this->belongsTo(ColorDetail::class, 'color_id', 'color_id');
    }
}
