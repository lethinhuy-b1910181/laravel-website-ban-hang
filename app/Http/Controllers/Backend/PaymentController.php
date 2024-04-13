<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\CartUser;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\City;
use App\Models\Transaction;
use App\Models\OrderTotal;
use App\Models\Discount;
use App\Models\CheckCoupon;
use App\Models\ColorDetail;
use Session;
use Auth;
class PaymentController extends Controller
{
    public function index(){

    }


    public function vnPay(Request $request){
    
        $request->validate([
            'shipping_address_id' => ['required', 'integer'],
        ]);
        $shippingAddress = UserAddress::findOrFail($request->shipping_address_id)->toArray();
        if($shippingAddress){
            Session::put('address', $shippingAddress);

            $order = new OrderTotal();
            $order->invoice_id = rand(1,999999);
            $order->user_id = Auth::guard('customer')->user()->id;
            $order->sub_total = getCartTotal(Auth::guard('customer')->user()->id);
            $order->amount = $order->sub_total;
            $cartItems = CartUser::where('user_id', Auth::guard('customer')->user()->id)->get();
            $order->product_qty = $cartItems->count();
            $order->payment_method = 'VNPay';
            $order->payment_status = 1;

            if(Session::has('coupon')){
                $order->order_coupon = json_encode(Session::get('coupon'));

            }else{
            $order->order_coupon = NULL;

            }
            $order->order_address = json_encode(Session::get('address'));
            $order->order_status= 0;
            $order->save();
            if($order->order_coupon !=  NULL ){
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

                $productColor = ColorDetail::where(['product_id'=> $item->product_id, 'color_id' =>$item->color_id])->first();
                if($productColor){
                    $productColor->sale += $item->qty;
                    $productColor->save();
                }

            }

            // $transaction = new Transaction();
            // $transaction->order_id = $order->id;
            // $transaction->transaction_id = '';
            // $transaction->payment_method =$order->payment_method;
            // $transaction->amount = getCartTotal(Auth::guard('customer')->user()->id);
            // $transaction->save();


                $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                $vnp_Returnurl = "http://127.0.0.1:8000/cart-details";
                $vnp_TmnCode = "4QCE9E4O";//Mã website tại VNPAY 
                $vnp_HashSecret = "OFPYPRXEHVMZZSMZMEJAYMLMHJCXTIAC"; //Chuỗi bí mật
    
                $vnp_TxnRef = rand(00,9999); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
                $vnp_OrderInfo = "Thanh toán hóa đơn";
                $vnp_OrderType = "Camera Shop";
                $vnp_Amount = $request->total * 100;
                $vnp_Locale = "VN";
                $vnp_BankCode ="NCB";
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
                
                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $vnp_TxnRef,
                
                );
    
                if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }
                // if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                //     $inputData['vnp_Bill_State'] = $vnp_Bill_State;
                // }
    
                //var_dump($inputData);
                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }
    
                $vnp_Url = $vnp_Url . "?" . $query;
                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }
                foreach ($cartItems as $cart) {
                    $cart->delete();
                }
                $returnData = array('code' => '00'
                    , 'message' => 'success'
                    , 'data' => $vnp_Url);
                    if (isset($_POST['redirect'])) {
                        header('Location: ' . $vnp_Url);
                        die();
                    } else {
                        echo json_encode($returnData);
                    }
                
                    
         
                Session::forget('coupon');
        }
        else{
            toastr()->error('Địa chỉ nhận hàng chưa được chọn!');
            return redirect()->back();
        }
        
    }
}
