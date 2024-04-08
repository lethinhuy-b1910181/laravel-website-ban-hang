<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Auth;
class WishlistController extends Controller
{
    public function index(){
        return view('frontend.pages.wishlist');
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
}
