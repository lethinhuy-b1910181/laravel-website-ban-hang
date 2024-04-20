<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    public function category()
    {
        return $this->belongsToMany(Category::class, 'brand_categories', 'brand_id', 'category_id');
    } 
}
