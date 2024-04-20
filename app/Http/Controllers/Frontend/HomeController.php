<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Product;
use App\Models\CartUser;
use App\Models\Category;
use App\Models\Brand;
use App\Models\BrandCategory;
use App\Models\Color;
use App\Models\ProductReview;
use Auth;
class HomeController extends Controller
{
    public function index(){

        $sliders = Slider::where('status', 1)->get();
        $products = Product::where('product_type', 'new')->get();
        $view_products = Product::orderBy('view', 'desc')->take(8)->get();
        $sell_products = Product::orderBy('sales', 'desc')->take(8)->get();
        $category = Category::orderBy('name', 'desc')->get();
       

        return view('frontend.home.home', 
            compact(
                'sliders',
                'products',
                'view_products',
                'category',
                'sell_products'
            ));
    }

    public function shop(Request $request){
        $re_brand = $request->brand;
        $categories = Category::orderBy('name', 'desc')->get();
        $brands = Brand::orderBy('name', 'desc')->get();
        $colors = Color::orderBy('name', 'desc')->get();
        $re_sort = '';
        $re_price = '';
        $sort = $request->sort;
        if($request->has('search')){
            $products = Product::where('status', 1)->where(function($query) use ($request){
                $query->where('name', 'like', '%'.$request->search.'%')
                      ->orWhere('long_description', 'like', '%'.$request->search.'%');  
            });
            if($request->has('brand')){
                $brand = Brand::where('slug', $request->brand)->firstOrFail();
                $products->where(['brand_id'=> $brand->id, 'status' => 1]);

                
            }

            elseif($request->has('category')){
                $cate = Category::where('slug', $request->category)->firstOrFail();
                $products->where('category_id', $cate->id);
            }
            if ($sort === 'new') {
                $re_sort = 'new';
                $products->orderBy('created_at', 'desc');
            } elseif ($sort === 'price_asc') {
                $re_sort = 'price_asc';
                $products->orderBy('offer_price', 'desc');
            } elseif ($sort === 'price_desc') {
                $re_sort = 'price_desc';
                $products->orderBy('offer_price', 'asc');
            }elseif ($sort === 'sale') {
                $re_sort = 'sale';
                $products->orderBy('sales', 'asc');
            }elseif ($sort === 'view') {
                $re_sort = 'view';
                $products->orderBy('view', 'asc');
            }
        
            $products = $products->get();
        }else{
            $products = Product::where('status', 1);
            if($request->has('brand')){
                $brand = Brand::where('slug', $request->brand)->firstOrFail();
                $products->where(['brand_id'=> $brand->id, 'status' => 1]);
                
            }

            if($request->has('category')){
                $cate = Category::where('slug', $request->category)->firstOrFail();
                $products->where('category_id', $cate->id);
            }

            if($request->has('price_range')){
                $re_price = $request->price_range;
                    switch($request->price_range){
                        case 'Duoi20':
                            $products->where('offer_price', '<', 1000000);
                            break;
                        case 'Tu20Den40':
                            $products->whereBetween('offer_price', [1000000, 3000000]);
                            break;
                        case 'Tu40Den70':
                            $products->whereBetween('offer_price', [3000000, 5000000]);
                            break;
                        case 'Tren70':
                            $products->where('offer_price', '>', 5000000);
                            break;
                        default:
                            // Xử lý mặc định nếu không có lựa chọn mức giá
                            break;
                    }

                    if ($sort === 'new') {
                        $re_sort = 'new';
                        $products->orderBy('created_at', 'desc');
                    } elseif ($sort === 'price_asc') {
                        $re_sort = 'price_asc';
                        $products->orderBy('offer_price', 'desc');
                    } elseif ($sort === 'price_desc') {
                        $re_sort = 'price_desc';
                        $products->orderBy('offer_price', 'asc');
                    }elseif ($sort === 'sale') {
                        $re_sort = 'sale';
                        $products->orderBy('sales', 'asc');
                    }elseif ($sort === 'view') {
                        $re_sort = 'view';
                        $products->orderBy('view', 'asc');
                    }
                }
            if ($sort === 'new') {
                $re_sort = 'new';
                $products->orderBy('created_at', 'desc');
            } elseif ($sort === 'price_asc') {
                $re_sort = 'price_asc';
                $products->orderBy('offer_price', 'desc');
            } elseif ($sort === 'price_desc') {
                $re_sort = 'price_desc';
                $products->orderBy('offer_price', 'asc');
            }elseif ($sort === 'sale') {
                $re_sort = 'sale';
                $products->orderBy('sales', 'asc');
            }elseif ($sort === 'view') {
                $re_sort = 'view';
                $products->orderBy('view', 'asc');
            }

            $products = $products->get();

        }

        return view('frontend.pages.shop', compact('categories', 'brands', 'colors', 'products', 're_brand', 're_price', 're_sort'));
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
    public function shopDetail(Request $request, $slug) {
        $re_cate = '';
        $re_sort = '';
        $re_price = '';
        $sort = $request->sort;
        
    
        $brand = Brand::where('slug', $slug)->where('status', 1)->first();
        $category = BrandCategory::where('brand_id', $brand->id)->where('status', 1)->get();
        $products = Product::where('status', 1)->where('brand_id', $brand->id);
    
        if ($request->has('category')) {
            $cate = Category::where('slug', $request->category)->firstOrFail();
            $re_cate = $request->category;


          
            $products = $products->where(['category_id' => $cate->id]);

            if ($sort === 'new') {
                $re_sort = 'new';
                $products->orderBy('created_at', 'desc');
            } elseif ($sort === 'price_asc') {
                $re_sort = 'price_asc';
                $products->orderBy('offer_price', 'desc');
            } elseif ($sort === 'price_desc') {
                $re_sort = 'price_desc';
                $products->orderBy('offer_price', 'asc');
            }elseif ($sort === 'sale') {
                $re_sort = 'sale';
                $products->orderBy('sales', 'asc');
            }elseif ($sort === 'view') {
                $re_sort = 'view';
                $products->orderBy('view', 'asc');
            }


        }
    
        if ($request->has('price_range')) {

            $re_price = $request->price_range;
            switch ($request->price_range) {
                case 'Duoi20':
                    $products->where('offer_price', '<', 1000000);
                    break;
                case 'Tu20Den40':
                    $products->whereBetween('offer_price', [1000000, 3000000]);
                    break;
                case 'Tu40Den70':
                    $products->whereBetween('offer_price', [3000000, 5000000]);
                    break;
                case 'Tren70':
                    $products->where('offer_price', '>', 5000000);
                    break;
                default:
                    break;
            }

            if ($sort === 'new') {
                $re_sort = 'new';
                $products->orderBy('created_at', 'desc');
            } elseif ($sort === 'price_asc') {
                $re_sort = 'price_asc';
                $products->orderBy('offer_price', 'desc');
            } elseif ($sort === 'price_desc') {
                $re_sort = 'price_desc';
                $products->orderBy('offer_price', 'asc');
            }elseif ($sort === 'sale') {
                $re_sort = 'sale';
                $products->orderBy('sales', 'asc');
            }elseif ($sort === 'view') {
                $re_sort = 'view';
                $products->orderBy('view', 'asc');
            }
        }
    
        
        
    
        if (!$request->has('category') && !$request->has('price_range')) {
            $products = Product::where('status', 1)->where('brand_id', $brand->id);
            if ($sort === 'new') {
                $re_sort = 'new';
                $products->orderBy('created_at', 'desc');
            } elseif ($sort === 'price_asc') {
                $re_sort = 'price_asc';
                $products->orderBy('offer_price', 'desc');
            } elseif ($sort === 'price_desc') {
                $re_sort = 'price_desc';
                $products->orderBy('offer_price', 'asc');
            }elseif ($sort === 'sale') {
                $re_sort = 'sale';
                $products->orderBy('sales', 'asc');
            }elseif ($sort === 'view') {
                $re_sort = 'view';
                $products->orderBy('view', 'asc');
            }
            $products = $products->get();
        } else {
            
            $products = $products->get();
        }
    
        return view('frontend.pages.shop_detail', compact('brand', 'category', 'products', 're_cate', 're_price', 're_sort'));
    }
    
   
}
