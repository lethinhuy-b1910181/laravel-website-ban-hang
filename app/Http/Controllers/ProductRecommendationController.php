<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\ProductRecommendationTrait;


class ProductRecommendationController extends Controller
{
    use ProductRecommendationTrait;


    public function showRecommendedProducts()
    {
        return view('products.recommended', compact('recommendedProducts'));
    }
}
