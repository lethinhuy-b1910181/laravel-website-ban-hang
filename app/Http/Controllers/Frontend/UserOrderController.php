<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\UserOrderDataTable;
use App\Models\Order;
use App\Models\OrderProduct;
use Auth;

class UserOrderController extends Controller
{
    public function index(Request $request){
        if($request->has('search')){
            $orders = Order::where(function($query) use ($request) {
                $query->where('id', 'like', '%'.$request->search.'%');
                     
            })->get();
            
        }else{
            $orders = Order::where('user_id', Auth::guard('customer')->user()->id)->latest()->get();
        }
        
        return view('frontend.account.order.index', compact('orders'));

    }

    public function indexWaitConfirm(){
        $orders = Order::where('user_id', Auth::guard('customer')->user()->id)->where('order_status', 0)->latest()->get();
        $orderCount = $orders->count();
        return view('frontend.account.order.wait_confirm', compact('orders', 'orderCount'));
    }

    public function indexWaitShip(){
        $orders = Order::where([
            'user_id' => Auth::guard('customer')->user()->id,
            'order_status' => 1,
        ])->latest()->get();
        $orderCount = $orders->count();
        return view('frontend.account.order.wait_ship', compact('orders', 'orderCount'));
    }

    public function indexShipping(){
        $orders = Order::where([
            'user_id' => Auth::guard('customer')->user()->id,
            'order_status' => 2,
        ])->latest()->get();
        $orderCount = $orders->count();
        return view('frontend.account.order.shipping', compact('orders', 'orderCount'));
    }

    public function indexCompleted(){
        $orders = Order::where([
            'user_id' => Auth::guard('customer')->user()->id,
            'order_status' => 3,
        ])->latest()->get();
        $orderCount = $orders->count();
        return view('frontend.account.order.completed', compact('orders', 'orderCount'));
    }

    public function indexCanceled(){
        $orders = Order::where([
            'user_id' => Auth::guard('customer')->user()->id,
            'order_status' => 4,
        ])->latest()->get();
        $orderCount = $orders->count();
        return view('frontend.account.order.canceled', compact('orders', 'orderCount'));
    }

    public function show(string $id){

        $order = Order::findOrFail($id);
        $orderDetail = OrderProduct::where('order_id', $order->id)->get();
        return view('frontend.account.order.show', compact('order', 'orderDetail'));
    }

   
}
