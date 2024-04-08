<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ReceiptProduct;

class FrontendProductController extends Controller
{
    public function showProduct(string $slug){
        $product = Product::with('brand', 'colors', 'productImage', 'category')->where('slug', $slug)->first();
        $sl = ReceiptProduct::where('product_id', $product->id)->sum('quantity');
       
        return view('frontend.pages.product-detail', compact('product', 'sl'));
    }
}
