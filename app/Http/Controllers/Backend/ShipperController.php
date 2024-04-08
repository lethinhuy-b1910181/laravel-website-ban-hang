<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ShipperDataTable;
use App\Models\Order;
use App\Models\OrderProduct;
use Auth;
use Hash;

class ShipperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ShipperDataTable $dataTable)
    {
        return $dataTable->render('shipper.index');
    }

    public function login(){
        return view('shipper.auth.login');
    }


    public function login_submit(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'

        ]);

        $credential = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::guard('shipper')->attempt($credential)) {
        
            toastr()->success('Đăng nhập thành công!');
            return redirect()->route('shipper.shipper.index');
        
        }else {
            toastr()->error('Thông tin đăng nhập không chính xác!');

            return redirect()->route('shipper.login');
        }
    }

    public function logout(){
        Auth::guard('shipper')->logout();
        return redirect()->route('shipper.login');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function newOrder()
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
        return view('shipper.show', compact('order', 'orderDetail'));
    }

    
    public function changeStatus1($id){
       

        $order = Order::findOrFail($id);
        $order->order_status = 2;
        $order->shipper_status = 1;
        $order->save();
        

        toastr()->success('Duyệt đơn hàng thành công!');
        return redirect()->back();
    }
    public function getCartCount(){

        $orderCount = Order::where('order_status', 2)->count();
        return $orderCount;
        
    }

    public function changeStatus2($id){
       

        $order = Order::findOrFail($id);
        $order->order_status = 3;
        $order->save();
        
        toastr()->success('Giao hàng thành công!');
        return redirect()->route('shipper.shipper.index');
    }
    public function changeStatus(Request $request){
        $receipt = Order::findOrFail($request->id);
        $receipt->order_status = $request->status;
        $receipt->save();

        return response(['message' => 'Giao hàng thành công!']);
    }
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
