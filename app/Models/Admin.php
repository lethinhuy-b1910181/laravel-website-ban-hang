<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class Admin extends Authenticatable
{
    use HasFactory;
    public function isSuperAdmin()
    {
        return $this->type === 1;
    }
    public function is_order() {
        $user = Auth::guard('admin')->user(); 
        if ($user) {
            return $user->permissions()->where('name', 'order')->exists();
        }
        return false; 
    }
    public function check_is_order() {
        return $this->permissions()->where('name', 'order')->exists();
    }

    public function is_product() {
        $user = Auth::guard('admin')->user(); 
        if ($user) {
            return $user->permissions()->where('name', 'product')->exists();
        }
        return false; 
    }
    public function check_is_product() {
        return $this->permissions()->where('name', 'product')->exists();
    }

    public function is_receipt() {
        $user = Auth::guard('admin')->user(); 
        if ($user) {
            return $user->permissions()->where('name', 'receipt')->exists();
        }
        return false; 
    } 

    public function check_is_receipt() {
        return $this->permissions()->where('name', 'receipt')->exists();
    }

    public function is_blog() {
        $user = Auth::guard('admin')->user(); 
        if ($user) {
            return $user->permissions()->where('name', 'blog')->exists();
        }
        return false; 
    }
    public function check_is_blog() {
        return $this->permissions()->where('name', 'blog')->exists();
    }

    public function hasPermission($permissions)
    {
        return $this->permissions()->whereIn('name', $permissions)->exists();
    }

    public function permissions()
    {
        return $this->belongsToMany(Quyen::class, 'chi_tiet_quyens', 'admin_id', 'quyen_id')
                    ->wherePivot('coquyen', 1); 
    }


}
