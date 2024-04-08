<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartUser;
use Cart;
use Auth;

use App\Models\ColorDetail;
use App\Models\Color;

class CartController extends Controller
{
    public function addToCart(Request $request){

        $product = Product::findOrFail($request->product_id);

        // dd($request->all());
        
       if(Auth::guard('customer')->check()){
            $cartItem = CartUser::where('product_id', $product->id)->first();
            if($cartItem != NULL){
                $cartItem->qty = $cartItem->qty + $request->qty;
                $cartItem->save();
            }
            else{

                
            $cart = new CartUser();
            $cart->user_id = Auth::guard('customer')->user()->id;
            $cart->product_id = $product->id;
            $cart->qty = $request->qty;
            $cart->save();
            }
            return response(['status'=>'success', 'message'=>'Đã thêm vào giỏ hàng!']);
       }
       else{
            return response(['status'=>'error', 'message'=>'Bạn cần đăng nhập để tiếp tục!']);

       }
      

    }

    public function cartDetails(){
        
        if(Auth::guard('customer')->check()){
            $cartItems = CartUser::where('user_id', Auth::guard('customer')->user()->id)->latest()->get();

            $total = 0;
            foreach($cartItems as $item){
             $total += $item->product->offer_price * $item->qty;
            }
             // dd($total);
             return view('frontend.pages.cart-detail', compact('cartItems', 'total'));
        }
        else {
            return view('login');
        }
       
    }
    public function updateQuantity(Request $request){
        
      
       $cart = CartUser::where('user_id', Auth::guard('customer')->user()->id)->where('id', $request->rowId)->first();
      $product = Product::where('id', $cart->product_id)->first();
        $cart->qty = $request->quantity;

        $cart->save();
        $productTotal = $product->offer_price * $cart->qty;
        $total = CartUser::where('user_id', Auth::guard('customer')->user()->id)
                     ->join('products', 'cart_users.product_id', '=', 'products.id')
                     ->sum(\DB::raw('cart_users.qty * products.offer_price'));

        $text = number_format($productTotal, 0, ',', '.');
        return response(['status'=> 'success', 'message'=> 'Cập nhật số lượng sản phẩm thành công!', 'product_total' => $text, 'total' => number_format($total, 0, ',', '.')]);
    }

    public function getProductTotal( $rowId){
        
        $product = CartUser::get($rowId);
        $productItem = Product::where('id', $product->product_id)->first();
        $total = $productItem->offer_price * $product->qty;
        return $total;


    }


    public function clearCart(){
        $cartItems = CartUser::where('user_id', Auth::guard('customer')->user()->id)->get();
        // dd($cart);

        foreach ($cartItems as $cartItem) {
            $cartItem->delete();
        }
        
        return response(['status' => 'success' , 'message' => 'Xoá thành công!']);

    }

    public function removeProduct($id){
        $cartItem = CartUser::findOrFail($id);
    
       
        $cartItem->delete();
        toastr()->success('Xóa thành công!');
        
        return redirect()->back();

    }

    public function getCartCount(){

        $cartItems = CartUser::where('user_id',Auth::guard('customer')->user()->id)->get();
        return $cartItems->count();
        
    }

    public function getCartProducts(){

        $cartItems = CartUser::where('user_id',Auth::guard('customer')->user()->id)->get();
        return $cartItems;
        
    }

    public function cartTotal($user_id){
        $total = 0;
        foreach(CartUser::where('user_id', $user_id)->get() as $item){
            $product = Product::where('id', $item->product_id)->first();

            $total += $product->offer_pric * $item->qty;
        }

        return $total;
    }

    public function getProduct($id)
        {
            // Lấy thông tin sản phẩm từ $id
            $product = Product::findOrFail($id);

            // Trả về dữ liệu của sản phẩm dưới dạng JSON
            return response()->json($product);
        }
    

    public function applyCoupon(Request $request){
        if($request->coupon_code == null){
            return response(['status'=>'error', 'message' => 'Bạn cần nhập mã giảm giá để tiếp tục.']);
        }
       
    }


}
