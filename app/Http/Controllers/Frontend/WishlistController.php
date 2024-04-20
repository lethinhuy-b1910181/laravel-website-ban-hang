<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Auth;
class WishlistController extends Controller
{
    public function index(){
        $products = '';
        if(Auth::guard('customer')->check()){
            $products = Wishlist::where('user_id', Auth::guard('customer')->user()->id)->get();
            
        }
        
        return view('frontend.pages.wishlist', compact('products'));
    }

    public function addToWishList(Request $request){
        if(Auth::guard('customer')->check()){
            $wishlistCount = Wishlist::where(['product_id'=> $request->id, 'user_id' => Auth::guard('customer')->user()->id])->count(); 
            if($wishlistCount >0){
                return response(['status'=>'error', 'message'=>'Bạn đã thêm vào trước đó rồi!']);
            }else{
                $wishlist = new Wishlist();
                $wishlist->user_id = Auth::guard('customer')->user()->id;
                $wishlist->product_id = $request->id;
                $wishlist->save();
            return response(['status'=>'success', 'message'=>'Thêm yêu thích!']);

            }
        }else {
            return response(['status'=>'error', 'message'=>'Đăng nhập để tiếp tục!']);
              }
       
    }

    public function getWishlistCount()
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if(Auth::guard('customer')->check()) {
            // Lấy user_id từ người dùng đã đăng nhập
            $user_id = Auth::guard('customer')->id();
            
            // Đếm số sản phẩm trong danh sách yêu thích của người dùng
            $count = Wishlist::where('user_id', $user_id)->count();
            return response()->json(['status' => 'success', 'count' => $count]);
        } else {
            // Nếu người dùng chưa đăng nhập, trả về số sản phẩm yêu thích là 0
            return response()->json(['status' => 'success', 'count' => 0]);
        }
    }
}
