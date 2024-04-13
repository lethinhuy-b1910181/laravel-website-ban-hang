<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Product;
use App\Models\CartUser;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use App\Models\ProductReview;
use Auth;
class HomeController extends Controller
{
    public function index(){

        $sliders = Slider::where('status', 1)->get();
        $products = Product::where('product_type', 'new')->get();
        $view_products = Product::orderBy('view', 'desc')->get();
        $category = Category::orderBy('name', 'desc')->get();
       

        return view('frontend.home.home', 
            compact(
                'sliders',
                'products',
                'view_products',
                'category'
            ));
    }

    public function shop(Request $request){
        $categories = Category::orderBy('name', 'desc')->get();
        $brands = Brand::orderBy('name', 'desc')->get();
        $colors = Color::orderBy('name', 'desc')->get();
        if($request->has('category')){
            $cate = Category::where('slug', $request->category)->firstOrFail();
            $products = Product::where([
                'category_id' => $cate->id,
                'status' => 1,
            ])->get();
        }elseif($request->has('search')){
            $products = Product::where('status', 1)->where(function($query) use ($request){
                $query->where('name', 'like', '%'.$request->search.'%')
                      ->orWhere('long_description', 'like', '%'.$request->search.'%');  
            });
            if($request->has('category')){
                $cate = Category::where('slug', $request->category)->firstOrFail();
                $products->where('category_id', $cate->id);
            }
        
            $products = $products->get();
        }else{
            $products = Product::where('status', 1)->get();

        }

        return view('frontend.pages.shop', compact('categories', 'brands', 'colors', 'products'));
    }
    public function autocomplete_ajax(Request $request){
        $data = $request->all();
        if($data['query']){
            $product = Product::where('status', 1)
                              ->where('name', 'LIKE', '%'.$data['query'].'%')
                              ->get();
    
            $output = '<ul class="dropdown-menu" style="display:block;position:relative; max-height: 350px; overflow-y: auto;">';
            foreach($product as $key => $val){
                $output.='<li class="li-search-ajax"><a href="'.route('product-detail', $val->slug).'" class="d-flex align-items-center"><div><img class="ml-2" style="width:60px; height:60px" src="'.asset($val->image).'"></div><div class="ml-2" style="margin-left: 10px;"><div>'.$val->name.'</div><div class="text-danger">Giá: '.number_format($val->offer_price, 0, ',', '.').'&#8363</div></div></a></li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }
    
    // public function autocomplete_ajax(Request $request){
    //     $data = $request->all();
    //     if($data['query']){
    //         $product = Product::where('status', 1)->where('name', 'LIKE', '%'.$data['query'].'%')->get();

    //         $output = '<ul class="dropdown-menu" style="display:block;position:relative;">';
    //         foreach($product as $key => $val){
    //             $output.='<li class="li-search-ajax"><a href="'.route('product-detail', $val->slug).'" class="d-flex align-items-center"><div><img class="ml-2" style="width:60px; height:60px" src="'.asset($val->image).'"></div><div class="ml-2" style="margin-left: 10px;"><div>'.$val->name.'</div><div class="text-danger">Giá: '.number_format($val->offer_price, 0, ',', '.').'&#8363</div></div></a></li>';
    //      }
    //         $output .= '</ul>';
    //         echo $output;
    //     }
    // }
}
