<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\City;
use App\Models\Order;
use App\Models\Product;
use App\Models\CartUser;
use App\Models\OrderProduct;
use App\Models\Transaction;
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
            $order = new Order();
            $order->invoice_id = rand(1,999999);
            $order->user_id = Auth::guard('customer')->user()->id;
            $order->sub_total = getCartTotal(Auth::guard('customer')->user()->id);
            $order->amount = $order->sub_total;
            $cartItems = CartUser::where('user_id', Auth::guard('customer')->user()->id)->get();
            $order->product_qty = $cartItems->count();
            $order->payment_method = 'Tiền mặt';
            $order->payment_status = 1;
            $order->order_address = json_encode(Session::get('address'));
            $order->order_status= 0;
            $order->save();

            foreach($cartItems as $item){
                $product = Product::find($item->product_id);
                $orderProduct = new OrderProduct();
                $orderProduct->order_id = $order->id;
                $orderProduct->product_id = $item->product_id;
                $orderProduct->product_name = $product->name;
                $orderProduct->unit_price = $product->offer_price;
                $orderProduct->qty = $item->qty;
                $orderProduct->status = 0;
                $orderProduct->save();

            }

            $transaction = new Transaction();
            $transaction->order_id = $order->id;
            $transaction->transaction_id = '';
            $transaction->payment_method =$order->payment_method;
            $transaction->amount = getCartTotal(Auth::guard('customer')->user()->id);
            $transaction->save();
            foreach ($cartItems as $cart) {
                $cart->delete();
            }
        }
        
        return response(['status'=>'success', 'message'=>'Đặt hàng thành công!', 'redirect' => route('user.orders.index')]);
    }
}
