<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartUser;
use App\Models\Discount;
use App\Models\CheckCoupon;
use Cart;
use Auth;
use Session;

use App\Models\ColorDetail;
use App\Models\Color;

class CartController extends Controller
{
    public function addToCart(Request $request){

        $product = Product::findOrFail($request->product_id);

        // dd($request->all());
        
       if(Auth::guard('customer')->check()){
            $cartItem = CartUser::where([
                                            'product_id' => $product->id,
                                            'color_id' =>  $request->color_id
                                        ])->first();
            if($cartItem != NULL){
                $cartItem->qty = $cartItem->qty + $request->qty;
                $cartItem->save();
            }
            else{

                
            $cart = new CartUser();
            $cart->user_id = Auth::guard('customer')->user()->id;
            $cart->product_id = $product->id;
            $cart->color_id =  $request->color_id;
            $cart->qty = $request->qty;
            $cart->product_price = $request->product_price;
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
            if(count($cartItems) == 0){
                Session::forget('coupon');
            }else {
                foreach($cartItems as $item){
                    $total += $item->product_price * $item->qty;
                   }
            }
             return view('frontend.pages.cart-detail', compact('cartItems', 'total'));
        }
        else {
            return view('login');
        }
       
    }
    public function updateQuantity(Request $request){
        
      
       $cart = CartUser::where('user_id', Auth::guard('customer')->user()->id)->where('id', $request->rowId)->first();
      $product = Product::where('id', $cart->product_id)->first();
      $quantityColor = ColorDetail::where(['product_id' => $cart->product_id, 'color_id' => $cart->color_id])->first();
        if($request->quantity > ($quantityColor->quantity - $quantityColor->sale)){
            $cart->qty = $quantityColor->quantity - $quantityColor->sale;
        }else {
            $cart->qty = $request->quantity;

        }

        $cart->save();
        $productTotal = $cart->product_price * $cart->qty;
        $total = CartUser::where('user_id', Auth::guard('customer')->user()->id)
                     ->sum(\DB::raw('cart_users.qty * cart_users.product_price'));

        $text = number_format($productTotal, 0, ',', '.');
        return response(['status'=> 'success', 'message'=> 'Cập nhật số lượng sản phẩm thành công!', 'product_total' => $text, 'total' => number_format($total, 0, ',', '.')]);
    }

    public function getProductTotal( $rowId){
        
        $product = CartUser::get($rowId);
        $total = $product->product_price * $product->qty;
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

            $total += $item->product_price * $item->qty;
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

        if(Session::get('coupon')){
            Session::forget('coupon');
        }
        if(Auth::guard('customer')->check()){
            $user_id =  Auth::guard('customer')->user()->id;
            $total = getCartTotal($user_id);
            $cart_total = number_format($total, 0, ',', '.').'₫';
        }
        if($request->coupon_code == null){
            
            return response(['status'=>'error', 'message' => 'Bạn cần nhập mã giảm giá để tiếp tục!', 'cart_total' => $cart_total]);
        }
        $coupon = Discount::where('code', $request->coupon_code)->first();
        
            
        if($coupon == null){
           
            return response(['status'=>'error', 'message' => 'Mã giảm giá không tồn tại!', 'cart_total' => $cart_total]);

        }else {
            $checkCoupon = CheckCoupon::where([ 
                'user_id' => Auth::guard('customer')->user()->id,    
                'coupon_id' => $coupon->id, 
                'status' => 0
            ])->first();
            if($checkCoupon){
                if($coupon->start_date > date('Y-m-d')){
                
                    return response(['status'=>'error', 'message' => 'Mã giảm giá chưa tới ngày bắt đầu!', 'cart_total' => $cart_total]);
                }else if($coupon->end_date < date('Y-m-d')){
                    
                    return response(['status'=>'error', 'message' => 'Mã giảm giá đã hết hạn!', 'cart_total' => $cart_total]);
                    
                }else if($coupon->value - $coupon->check_use == 0){
                    
                    return response(['status'=>'error', 'message' => 'Mã giảm giá đã dùng hết rồi!', 'cart_total' => $cart_total]);
    
                }else {
                    if($coupon->type == 1){
                        Session::put('coupon', [
                            'coupon_id' => $coupon->id,
                            'coupon_name' => $coupon->name,
                            'coupon_code' => $coupon->code,
                            'coupon_type' => 1,
                            'coupon_min_price' => $coupon->min_price,
                            'coupon_min_order' => $coupon->min_order,
                            'coupon_max_price' => $coupon->max_price,
    
                        ]);
                    }else if($coupon->type == 0){
                        Session::put('coupon', [
                            'coupon_id' => $coupon->id,
                            'coupon_name' => $coupon->name,
                            'coupon_code' => $coupon->code,
                            'coupon_type' => 0,
                            'coupon_min_price' => $coupon->min_price,
                            'coupon_min_order' => $coupon->min_order,
                            'coupon_max_price' => $coupon->max_price,
    
                        ]);
                    }
                    return  response(['status'=>'success', 'message' => 'Áp mã thành công!']);
                }
            }
            else if($checkCoupon == NULL){
                return  response(['status'=>'error', 'message' => 'Mã đã được sử dụng rồi!', 'cart_total' => $cart_total]);
            }
            
        }
       
    }

    public function couponCalculation(){
        $user_id = Auth::guard('customer')->user()->id;
        if(Session::get('coupon')){
            
            $coupon = Session::get('coupon');
            $subTotal = getCartTotal($user_id);
            if($subTotal >= $coupon['coupon_min_order']){
                if($coupon['coupon_type'] == 1){
                    
                    $total = $subTotal - $coupon['coupon_min_price'];
                    $cart_total = number_format($total, 0, ',', '.'). '₫';
                    $discount_total = number_format($coupon['coupon_min_price'], 0, ',', '.'). '₫' ;
                    $discount_code = number_format($coupon['coupon_min_price'], 0, ',', '.') . '₫';
                    return response(['status' => 'success','message' => 'Áp mã thành công!', 'cart_total' => $cart_total, 'discount' => $discount_total, 'discount_code' => $discount_code]);
                }
                if($coupon['coupon_type'] == 0){
                    $discount = $subTotal * $coupon['coupon_min_price'] / 100;
                    if($discount <= $coupon['coupon_max_price']){
                        $discount = $subTotal * $coupon['coupon_min_price'] / 100;
                        $total = $subTotal - $discount;
                        $cart_total = number_format($total, 0, ',', '.'). '₫';
                        $discount_total = number_format($discount, 0, ',', '.'). '₫';
                        $discount_code = $coupon['coupon_min_price'] . '%';
                        // $cart_total = number_format($total, 0, ',', '.');
                    return response(['status' => 'success','message' => 'Áp mã thành công!', 'cart_total' => $cart_total, 'discount' => $discount_total, 'discount_code' => $discount_code]);

                    }else if($discount > $coupon['coupon_max_price']) {
                        $discount = $coupon['coupon_max_price'];
                        $total = $subTotal - $discount;
                        $cart_total = number_format($total, 0, ',', '.'). '₫';
                        $discount_total = number_format($discount, 0, ',', '.'). '₫';
                        $discount_code = $coupon['coupon_min_price'] . '%';
                    return response(['status' => 'success','message' => 'Áp mã thành công!', 'cart_total' => $cart_total, 'discount' => $discount_total, 'discount_code' => $coupon['coupon_min_price']]);
                    }
                }
            }else{
                Session::forget('coupon');
                $total = $subTotal;
                $cart_total = number_format($total, 0, ',', '.');
                return response(['status' => 'error', 'message' => 'Đơn hàng không đủ điều kiện để sử dụng mã này!', 'cart_total' => $cart_total]);

            }
            
            
        }
        else{
            $total = getCartTotal($user_id);
            $cart_total = number_format($total, 0, ',', '.');
            return response(['status' => 'success','cart_total' => $cart_total]);

        }
    }


}
