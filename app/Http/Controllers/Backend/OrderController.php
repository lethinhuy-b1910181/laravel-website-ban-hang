<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\OrderDataTable;
use App\DataTables\NewOrderDataTable;
use App\DataTables\WaitShipOrderDataTable;
use App\DataTables\ShippingOrderDataTable;
use App\DataTables\CanceledOrderDataTable;
use App\DataTables\CompletedOrderDataTable;

use App\Models\OrderTotal;
use App\Models\City;
use App\Models\Product;
use App\Models\District;
use App\Models\Ward;
use App\Models\Color;
use App\Models\Customer;
use App\Models\OrderProduct;

use Mail;
use Carbon\Carbon;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(OrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.index');
    }

    public function indexNewOrder(NewOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.new_order');
    }

    public function indexWaitShip(WaitShipOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.wait_ship');
    }

    public function indexShipping(ShippingOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.shipping');
    }

    public function indexCompleted(CompletedOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.completed');
    }

    public function indexCanceled(CanceledOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.canceled');
    }


    public function changeStatus1(Request $request, $id)
    {

        
      
        if($request->shipper_id == ''){
            toastr()->error('Bạn chưa chọn người giao hàng!');
            return redirect()->back();
        }

        $order = OrderTotal::findOrFail($id);
        $order->order_status = 1;
        $order->shipper_status = 0;
        $order->shipper_id = $request->shipper_id;
        $order->save();

        $orderProducts = OrderProduct::where('order_id', $order->id)->get();

        $discount_array = '';
        
        if($order->save()){
            $address = json_decode($order->order_address);
            $city = City::where('id', $address->city_id)->first();
            $district = District::where('id', $address->district_id)->first();
            $ward = Ward::where('id', $address->ward_id)->first();
            if( $order->order_coupon != NULL){
                $coupon = json_decode($order->order_coupon);
                $discount_array = array(
                'coupon_id' =>  $coupon->coupon_id,
                'coupon_name' => $coupon->coupon_name,
                'coupon_type' => $coupon->coupon_type,
                'coupon_code' => $coupon->coupon_code,
                'coupon_min_price' => $coupon->coupon_min_price,
                );
              
                
            }
            $customers = Customer::where('id' ,$order->user_id)->first();
            $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');

            $title_email = "Xác nhận đơn hàng tại Camera Shop";

            $data['email'][] =   $customers->email ;
            foreach($orderProducts as $item){
                $cart_array[] = array(
                    'product_name' => $item->product_name,
                    'product_image' => Product::where('id', $item->product_id)->first()->image,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->unit_price*$item->qty,
                    'qty' => $item->qty,
                    'color' => Color::where('id', $item->color_id)->first()->name,
                );
            }
            $date = Carbon::parse($order->created_at)->format('d-m-y H:i:s');
            $info_array = array(
                'customer_name' => $address->name,
                'customer_email' => $customers->email,
                'customer_phone' => $address->phone,
                'customer_address' => $address->address,
                'customer_address_city' => $city->name,
                'customer_address_district' => $district->name,
                'customer_address_ward' => $ward->name,
                'order_id' => $order->id,
                'order_date' => $date,
                'order_sub_total' => $order->sub_total,
                'order_payment_method' => $order->payment_method,
                'order_amount' => $order->amount,
                'order_discount' => $order->sub_total - $order->amount,

            );
            Mail::send('admin.order.mail_confirm', ['cart_array'=>$cart_array, 'info_array'=>$info_array, 'discount_array'=>$discount_array], function($message)use ($title_email, $data){
                $message->to($data['email'])->subject($title_email);
                $message->from($data['email'], $title_email);
            });
            
    
        }

        

        toastr()->success('Duyệt đơn hàng thành công!');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = OrderTotal::findOrFail($id);
        $orderDetail = OrderProduct::where('order_id', $order->id)->get();
        return view('admin.order.show', compact('order', 'orderDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
