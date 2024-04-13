<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ReceiptProduct;
use App\Models\ColorDetail;
use App\Models\ProductReview;

class FrontendProductController extends Controller
{
    public function showProduct(string $slug){
        $product = Product::with('brand', 'colors', 'productImage', 'category')->where('slug', $slug)->first();
        $sale = ColorDetail::where('product_id', $product->id)->sum('sale');
        $sl = ColorDetail::where('product_id', $product->id)->sum('quantity') - $sale;

        $product->view ++;
        $product->save();
        $stars = ProductReview::where('product_id', $product->id)->avg('star');
        $reviews = ProductReview::where('product_id', $product->id)->latest()->get();
        $stars = round($stars);
        $total_star = ProductReview::where('product_id', $product->id)->avg('star');
        $total_star = round($total_star, 1);

        return view('frontend.pages.product-detail', compact('product', 'sl', 'stars', 'reviews', 'total_star'));
    }
}
