<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietQuyen extends Model
{
    use HasFactory;

    public function quyen()
    {
        return $this->belongsTo(Quyen::class, 'quyen_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function check_is_product() {
        return $this->quyen->where('name', 'product')->exists();
    }
}
