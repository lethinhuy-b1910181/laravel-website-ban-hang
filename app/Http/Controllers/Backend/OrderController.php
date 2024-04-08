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

use App\Models\Order;
use App\Models\OrderProduct;


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


    public function changeStatus1(Request $request, $id){
       
        if($request->shipper_id == ''){
            toastr()->error('Bạn chưa chọn người giao hàng!');
            return redirect()->back();
        }

        $order = Order::findOrFail($id);
        $order->order_status = 1;
        $order->shipper_id = $request->shipper_id;
        $order->save();
        

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
        $order = Order::findOrFail($id);
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
