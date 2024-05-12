<?php

namespace App\Http\Controllers\Frontend;


use Phpml\Classification\KNearestNeighbors;
// use Phpml\Math\Distance;
use Phpml\Math\Distance\Euclidean;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Product;
use App\Models\CartUser;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Brand;
use App\Models\BrandCategory;
use App\Models\Color;
use App\Models\Rating;
use App\Models\ProductReview;
use Auth;
use App\Models\UserActivity;



class HomeController extends Controller
{

  

    public function recommendPopularProducts()
    {
        $popular_products = Product::orderBy('sales', 'desc')->limit(8)->pluck('id')->toArray();

        return $popular_products;
    }



    public function findNearestNeighbors($currentUserId)
    {
   
        $allUsersPurchases = Rating::select('user_id', 'product_id')
            ->where('user_id', '!=', $currentUserId) // Exclude the current user
            ->get()
            ->groupBy('user_id');
        
        $samples = []; //Lưu trữ user_id và product_id của người dùng đã mua
        $labels = [];//Lưu trữ user_id của người dùng đã mua
        foreach ($allUsersPurchases as $uid => $purchases) {
            $userSamples = [];
            foreach ($purchases as $purchase) {
                $userSamples[] = $purchase->product_id;
            }
            $samples[] = $userSamples;
            $labels[] = $uid;
        }

        $max_length = max(array_map('count', $samples));
        foreach ($samples as &$sample) {
            $missing_elements = $max_length - count($sample);
            for ($i = 0; $i < $missing_elements; $i++) {
                $sample[] = 0; 
            }
        }
        
     
        $classifier = new KNearestNeighbors($k = 3, new Euclidean());
        $classifier->train($samples, $labels);
    
        
        $userSimilarity = []; //Danh sách người dùng tương tự người dùng hiện tại
        foreach ($samples as $idx => $sample) {
              

            $predictedUserId = $labels[$idx];
            $similarity = $classifier->predict([$sample]);
            $userSimilarity[$predictedUserId] = $similarity[0]; 
            
        }
        $userPurchases = Rating::where('user_id', $currentUserId)
        ->pluck('product_id')
        ->toArray();

        foreach ($userSimilarity as $idx =>$user) {

            $userId = $idx;
            $userPurchasedProducts = Rating::where('user_id', $userId)->pluck('product_id')->toArray();
        
            // Tính số lượng sản phẩm trùng khớp
            $commonProducts = array_intersect($userPurchases, $userPurchasedProducts);
            $similary = count($commonProducts);
        
            // Lưu độ tương tự vào mảng
            $similarities[$userId] = $similary;
        }
        
        // Sắp xếp người dùng theo độ tương tự giảm dần
        arsort($similarities);
   
        $nearestNeighbors = array_slice(array_keys($similarities), 0, 3); 
        return $nearestNeighbors;
    }


    public function index(){

        $sliders = Slider::where('status', 1)->get();
        $products = Product::where('product_type', 'new')->where('status', 1)->get();
        $view_products = Product::orderBy('view', 'desc')->where('status', 1)->take(8)->get();
        $sell_products = Product::orderBy('sales', 'desc')->where('status', 1)->take(8)->get();
        $category = Category::orderBy('name', 'desc')->where('status', 1)->get();
       
        if(Auth::guard('customer')->check()){

            $currentUserId = Auth::guard('customer')->user()->id;
            $userExists = Rating::where('user_id', $currentUserId)->exists();

            if ($userExists) {
                $nearestNeighbors = $this->findNearestNeighbors($currentUserId);
    
                // Kiểm tra xem có người dùng tương tự hay không
                if (!empty($nearestNeighbors)) {
                    // Lấy danh sách sản phẩm đã mua bởi người dùng hiện tại
                    $currentUserPurchases = Rating::where('user_id', $currentUserId)
                        ->pluck('product_id')
                        ->toArray();

                    // Lấy danh sách các sản phẩm được gợi ý
                    $recommendedProducts = [];
                    foreach ($nearestNeighbors as $neighborId) {
                        // Lấy danh sách sản phẩm đã mua bởi người dùng tương tự
                        $neighborPurchases = Rating::where('user_id', $neighborId)
                            ->pluck('product_id')
                            ->toArray();

                        // Loại bỏ các sản phẩm đã mua bởi người dùng hiện tại và loại bỏ các sản phẩm trùng lặp
                        $recommendedProducts = array_merge($recommendedProducts, array_diff($neighborPurchases, $currentUserPurchases));
                    }

                    // Loại bỏ sản phẩm đã mua bởi người dùng hiện tại và loại bỏ các sản phẩm trùng lặp
                    $recommendedProducts = array_unique($recommendedProducts);
                } else {
                    $currentUserPurchases = Rating::where('user_id', $currentUserId)
                    ->pluck('product_id')
                    ->toArray();

                    $recommendedProducts = $this->recommendPopularProducts();
                    $recommendedProducts = array_diff($recommendedProducts, $currentUserPurchases);
                }
            } else {
                $recommendedProducts = $this->recommendPopularProducts();
            }
        }else {
            $recommendedProducts = $this->recommendPopularProducts();
        }

        
        $recentBlogs = Blog::with(['category', 'user'])->where('status',1)->orderBy('id', 'DESC')->take(8)->get();

        return view('frontend.home.home', 
            compact(
                'recentBlogs',
                'sliders',
                'products',
                'view_products',
                'category',
                'sell_products',
                'recommendedProducts'
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
            if(Auth::guard('customer')->check()){
                $activity = new UserActivity();
                $activity->user_id = Auth::guard('customer')->user()->id;
                $activity->type = 'search';
                $activity->search_query = $request->search;
                $activity->save();
            }
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
        
            $products = $products->paginate(24);
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

            $products = $products->paginate(24);

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
            $products = $products->paginate(24);
        } else {
            
            $products = $products->paginate(24);
        }
    
        return view('frontend.pages.shop_detail', compact('brand', 'category', 'products', 're_cate', 're_price', 're_sort'));
    }
    
   public function blog(){
    return view('frontend.pages.blog');
   }
}
