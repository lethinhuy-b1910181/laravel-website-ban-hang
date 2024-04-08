<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quyen extends Model
{
    use HasFactory;
    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'chitietquyen', 'quyen_id', 'admin_id');
    }
}