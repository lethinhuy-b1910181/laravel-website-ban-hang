<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\KhoHang;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ReceiptProduct;
use App\Models\ColorDetail;
use App\Models\ProductReview;
use App\Models\UserActivity;

use Auth;

class FrontendProductController extends Controller
{
    public function showProduct(string $slug){


        $product = Product::with('brand', 'colors', 'productImage', 'category')->where('slug', $slug)->first();
        $relate_products = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->where('status', 1)->get();
        $sale = ColorDetail::where('product_id', $product->id)->sum('sale');
        $sl = ColorDetail::where('product_id', $product->id)->sum('quantity') - $sale;

        $product->view ++;
        $product->save();
        $stars = ProductReview::where('product_id', $product->id)->avg('star');
        $reviews = ProductReview::where('product_id', $product->id)->where('status', 1)->latest()->get();
        $stars = round($stars);
        $total_star = ProductReview::where('product_id', $product->id)->avg('star');
        $total_star = round($total_star, 1);

        $price_min_kho = KhoHang::where('product_id' , $product->id)->min('price');

        if(Auth::guard('customer')->check()){
            $activity = new UserActivity();
            $activity->user_id = Auth::guard('customer')->user()->id;
            $activity->type = 'view';
            $activity->product_id = $product->id;
            $activity->save();
        }


        return view('frontend.pages.product-detail', compact('product', 'sl', 'stars', 'reviews', 'total_star', 'price_min_kho', 'relate_products'));
    }
}
