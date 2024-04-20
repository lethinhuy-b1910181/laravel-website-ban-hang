<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\City;
use App\Models\OrderTotal;
use App\Models\Product;
use App\Models\CartUser;
use App\Models\OrderProduct;
use App\Models\Transaction;
use App\Models\CheckCoupon;
use App\Models\Discount;
use App\Models\ColorDetail;

use Session;
use Auth;
class CheckOutController extends Controller
{
    public function index(){
        if(Auth::guard('customer')->check()){
            $cities = City::orderBy('name')->get();
            $addresses = UserAddress::where('user_id', Auth::guard('customer')->user()->id)->latest()->get();
            $user_id = Auth::guard('customer')->user()->id;
        
        }
        
        return view('frontend.pages.checkout', compact('addresses', 'cities', 'user_id'));
    }

    public function createAddress(Request $request){

        $request->validate([
           
            'address' => ['required'],
            'phone' =>['required', 'max:200'],
            'name' =>['required', 'max:200'],
            'city_id' =>['required'],
            'district_id' =>['required'],
            'ward_id' =>['required'],

        ]);

       
        $address = new UserAddress();
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->user_id = Auth::guard('customer')->user()->id;
        $address->city_id = $request->city_id;
        $address->district_id = $request->district_id;
        $address->ward_id = $request->ward_id;
        $address->save();

        toastr()->success('Thêm địa chỉ thành công!');
        return redirect()->back();


    }

    public function checkOutFormSubmit(Request $request){
        
        $request->validate([
            'address_id' => ['required', 'integer'],
        ]);
        $shippingAddress = UserAddress::findOrFail($request->address_id)->toArray();
      
        if($shippingAddress){
            Session::put('address', $shippingAddress);
            $order = new OrderTotal();
            $order->invoice_id = rand(1,999999);
            $order->user_id = Auth::guard('customer')->user()->id;
            
           
            $cartItems = CartUser::where('user_id', Auth::guard('customer')->user()->id)->get();
            $order->product_qty = $cartItems->count();
            $order->payment_method = 'Tiền mặt';
            $order->payment_status = 1;
            $order->sub_total = 0;
           

            if(Session::has('coupon')){
                $order->order_coupon = json_encode(Session::get('coupon'));

            }else{
            $order->order_coupon = NULL;

            }
            $order->amount = 0;
            $order->order_address = json_encode(Session::get('address'));
            $order->order_status= 0;
            $order->save();
            foreach($cartItems as $item){
                $product = Product::find($item->product_id);
                $orderProduct = new OrderProduct();
                $orderProduct->order_id = $order->id;
                $orderProduct->product_id = $item->product_id;
                $orderProduct->product_name = $product->name;
                $orderProduct->color_id = $item->color_id;
                $orderProduct->unit_price = $item->product_price;
                $orderProduct->qty = $item->qty;
                $orderProduct->status = 0;
                $orderProduct->save();
                $order->sub_total = $order->sub_total + $item->product_price*$item->qty;
                $productColor = ColorDetail::where(['product_id'=> $item->product_id, 'color_id' =>$item->color_id])->first();
                if($productColor){
                    $productColor->sale += $item->qty;
                    $productColor->save();
                }

            }
            $order->amount =$order->amount + $order->sub_total;
            $order->save();
            

            if($order->order_coupon != NULL){
                $coupon = json_decode($order->order_coupon);
                
                if($coupon->coupon_type == 0){
                    $discount =   $order->sub_total* $coupon->coupon_min_price / 100;
                    
                    if($discount <= $coupon->coupon_max_price){
                        $discount = $order->sub_total * $coupon->coupon_min_price / 100;
                        $order->amount -= $discount;
                        $order->save();
                    }else if($discount > $coupon->coupon_max_price) {
                        $discount = $coupon->coupon_max_price;
                        $order->amount -= $discount;
                        $order->save();
                    }
                }
                else if($coupon->coupon_type == 1){
                    if($coupon->coupon_min_price <= $coupon->coupon_max_price ){
                        $order->amount -= $coupon->coupon_min_price;
                        $order->save();
                    }
                    else if($coupon->coupon_min_price  > $coupon->coupon_max_price ){
                        $order->amount -= $coupon->coupon_max_price;
                        $order->save();
                    }
                }

                
                $checkCoupon = CheckCoupon::where([
                                                    
                                                    'user_id' => Auth::guard('customer')->user()->id,
                                                    'coupon_id' => $coupon->coupon_id,
                                                    'status' => 0
                                                    ])->first();
                if($checkCoupon){
                    $checkCoupon->order_id = $order->id;
                    $checkCoupon->coupon_id = $coupon->coupon_id;
                    $checkCoupon->status = 1;
                    $checkCoupon->save();
                    $updateCoupon = Discount::where('id', $checkCoupon->coupon_id)->first();
                    $updateCoupon->check_use++;
                    $updateCoupon->save();
                    
                    
                }
            }
            
            
            // $transaction = new Transaction();
            // $transaction->order_id = $order->id;
            // $transaction->transaction_id = '';
            // $transaction->payment_method =$order->payment_method;
            // $transaction->amount = getCartTotal(Auth::guard('customer')->user()->id);
            // $transaction->save();
            foreach ($cartItems as $cart) {
                $cart->delete();
            }
        }
        Session::forget('coupon');
        
        return response(['status'=>'success', 'message'=>'Đặt hàng thành công!', 'redirect' => route('user.orders.index')]);
    }
}
