<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ShipperDataTable;
use App\Models\OrderTotal;
use App\Models\Product;
use App\Models\ColorDetail;
use App\Models\OrderProduct;
use Auth;
use Hash;
use App\Models\Statistical;
use App\Models\Customer;
use App\Models\KhoHang;
use Carbon\Carbon;
use Mail;


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
        $order = OrderTotal::findOrFail($id);
        $orderDetail = OrderProduct::where('order_id', $order->id)->get();
        return view('shipper.show', compact('order', 'orderDetail'));
    }

    
    public function changeStatus1($id){
       

        $order = OrderTotal::findOrFail($id);
        $order->order_status = 2;
        $order->shipper_status = 1;
        $order->save();
        

        toastr()->success('Đã nhận đơn, lên xe và giao thôi nào!');
        return redirect()->back();
    }
    public function getCartCount(){

        $orderCount = OrderTotal::where('order_status', 2)->count();
        return $orderCount;
        
    }

    public function changeStatus2($id){
       

        $order = OrderTotal::findOrFail($id);
        $order->order_status = 3;
        $order->save();
        $user_id = $order->user_id;

        if($order->save()){
            $order_date = Carbon::parse($order->created_at)->format('Y-m-d');
            $statistical = Statistical::where('order_date', $order_date)->first();
            $orderProduct = OrderProduct::where('order_id', $order->id)->get();

            $chi_phi = 0;    
            $so_luong = 0;
            foreach($orderProduct as $item){
                $product = Product::where('id', $item->product_id)->first();
                $ratingExists = Rating::where(['user_id' => $user_id, 'product_id' => $product->id])->exists();
                if(!$ratingExists){
                    $rating = new Rating;
                    $rating->user_id = $user_id;
                    $rating->product_id = $product->id;
                    $rating->save();
                }
                $product->sales += $item->qty;
                $product->save();
                $so_luong = $so_luong + $item->qty;
                
                $gia_ban = $item->price;
                $sl_mua = $item->qty;  
                while($sl_mua > 0){
                    $khoHang = KhoHang::where('product_id', $item->product_id)
                    ->where('color_id', $item->color_id)
                    ->where('quantity', '!=', 0)
                    ->first();
                     if($khoHang != ''){
                        $sl_kho = $khoHang->quantity;
                     
                     
                        while( $sl_kho > 0 && $sl_mua > 0){
                            $chi_phi =    $chi_phi +$khoHang->price;
                            $sl_mua  = $sl_mua- 1 ;
                            $sl_kho = $sl_kho - 1;
                            
                        }

                        
                        $khoHang->quantity = $sl_kho ;
                        $khoHang->save();
                     }
                     else break;
                    
                }
            }
           
            if($statistical){
                
                $statistical->sales= $statistical->sales + $order->amount;
                $statistical->quantity+=$so_luong ;
                $statistical->total_order++;
                $statistical->profit = $statistical->profit + $order->amount - $chi_phi;
              
                $statistical->save();
               
            }else{
                $statistical = new Statistical();
                $statistical->order_date = $order_date;
                $statistical->sales= $order->amount;
                $statistical->quantity=$so_luong ;
                $statistical->total_order = 1;
                $statistical->profit = $order->amount - $chi_phi;
                $statistical->save();
            }


      
   
                $address = json_decode($order->order_address);
               
        
                $customers = Customer::where('id' ,$order->user_id)->first();
                $customers->total_money+=$order->sub_total;
                $customers->save();

    
                $title_email = "Đơn hàng #".$order->id." đã giao hàng thành công";
    
                $data['email'][] =   $customers->email ;
                
                $date = Carbon::parse($order->updated_at)->format('d-m-y H:i:s');
                $info_array = array(
                    'customer_name' => $address->name,
                    'order_date' => $date,
                    'order_id' => $order->id,
                   
    
                );
                Mail::send('admin.order.mail_complete', ['info_array'=>$info_array], function($message)use ($title_email, $data){
                    $message->to($data['email'])->subject($title_email);
                    $message->from($data['email'], $title_email);
                });
                
            
        }

        toastr()->success('Giao hàng thành công!');
        return redirect()->route('shipper.shipper.index');
    }


    public function changeStatus(Request $request){
        $receipt = OrderTotal::findOrFail($request->id);
        $receipt->order_status = $request->status;
        $receipt->save();

        return response(['message' => 'Giao hàng thành công!']);
    }




    public function changeStatusCancel(Request $request){

        $order = OrderTotal::findOrFail($request->order_id);
        $order->shipper_status = 2;
        $order->order_status = 1;
        $order->shipper_id = NULL;
        $order->save();
        return redirect()->route('shipper.shipper.index');

    }


    public function failOrder(Request $request ){
        $order = OrderTotal::findOrFail($request->order_id);
        $orderProduct = OrderProduct::where('order_id', $order->id)->get();
        foreach($orderProduct as $item){
            $colorDetail = ColorDetail::where(['product_id'=> $item->product_id, 'color_id' =>$item->color_id])->first();
            $colorDetail->sale -= $item->qty;
            $colorDetail->save();
        }
        $order->order_status = 5;
        $order->fail_reason = $request->reason;
        $order->save();
        return redirect()->route('shipper.shipper.index')->with('Cập nhật trạng thái đơn hàng thành công!'); 
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
