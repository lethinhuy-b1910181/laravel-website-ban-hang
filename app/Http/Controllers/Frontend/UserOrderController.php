<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\UserOrderDataTable;
use App\Models\OrderTotal;
use App\Models\OrderProduct;
use App\Models\ColorDetail;
use App\Models\ProductReview;
use App\Models\OrderReview;
use Auth;

class UserOrderController extends Controller
{
    public function index(Request $request){
        if($request->has('search')){
            $orders = OrderTotal::where(function($query) use ($request) {
                $query->where('id', 'like', '%'.$request->search.'%');
                     
            })->get();
            
        }else{
            $orders = OrderTotal::where('user_id', Auth::guard('customer')->user()->id)->orderBy('order_status', 'asc')->get();
        }
        
        return view('frontend.account.order.index', compact('orders'));

    }

    public function indexWaitConfirm(){
        $orders = OrderTotal::where('user_id', Auth::guard('customer')->user()->id)->where('order_status', 0)->latest()->get();
        $orderCount = $orders->count();
        return view('frontend.account.order.wait_confirm', compact('orders', 'orderCount'));
    }

    public function indexWaitShip(){
        $orders = OrderTotal::where([
            'user_id' => Auth::guard('customer')->user()->id,
            'order_status' => 1,
        ])->latest()->get();
        $orderCount = $orders->count();
        return view('frontend.account.order.wait_ship', compact('orders', 'orderCount'));
    }

    public function indexShipping(){
        $orders = OrderTotal::where([
            'user_id' => Auth::guard('customer')->user()->id,
            'order_status' => 2,
        ])->latest()->get();
        $orderCount = $orders->count();
        return view('frontend.account.order.shipping', compact('orders', 'orderCount'));
    }

    public function indexCompleted(){
        $orders = OrderTotal::where([
            'user_id' => Auth::guard('customer')->user()->id,
            'order_status' => 3,
        ])->latest()->get();
        $orderCount = $orders->count();
        return view('frontend.account.order.completed', compact('orders', 'orderCount'));
    }

    public function indexCanceled(){
        $orders = OrderTotal::where([
            'user_id' => Auth::guard('customer')->user()->id,
            'order_status' => 4,
        ])->latest()->get();
        $orderCount = $orders->count();
        return view('frontend.account.order.canceled', compact('orders', 'orderCount'));
    }

    public function show(string $id){

        $order = OrderTotal::findOrFail($id);
        $orderDetail = OrderProduct::where('order_id', $order->id)->get();
       
        return view('frontend.account.order.show', compact('order', 'orderDetail'));
    }


    public function cancelOrder(Request $request){

        
        $order = OrderTotal::where('id', $data['id'])->first();
        $orderProduct = OrderProduct::where('order_id', $order->id)->get();
        foreach($orderProduct as $item){
            $colorDetail = ColorDetail::where(['product_id'=> $item->product_id, 'color_id' =>$item->color_id])->first();
            $colorDetail->sale -= $item->qty;
            $colorDetail->save();
        }
        $order->reason_customer = $data['lydo'];
        $order->order_status = $data['order_status'];
        
        $order->save();
        

    }

    public function productReview(Request $request){
    
        $review = new ProductReview();
        $review->user_id = $request->user_id;
        $review->product_id = $request->product_id;
        $review->order_id = $request->order_id;
        $review->color_id = $request->color_id;
        $review->star = $request->star;
        $review->review = $request->review;
        $review->status = 1;
        $review->save();

        $orderProduct = OrderProduct::where(['order_id' => $request->order_id, 'product_id' => $request->product_id, 'color_id' => $request->color_id])->first();
        $orderProduct->status = 1;
        $orderProduct->save();

        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
        


    }

    public function orderReview(Request $request){
        $review = new OrderReview();
        $review->user_id = $request->user_id;
        $review->order_id = $request->order_id;
        $review->star = $request->star;
        $review->review = $request->review;
        $review->status = 1;
        $review->save();

        $order = OrderTotal::where('id' , $request->order_id)->first();
        $order->order_review = 1;
        $order->save();

        return redirect()->back()->with('success', 'Cảm ơn bạn đã gửi phản hồi đơn hàng!');
        


    }

   
}
