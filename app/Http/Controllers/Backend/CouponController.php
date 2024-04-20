<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;
use App\Models\CheckCoupon;
use App\Models\Customer;
use App\DataTables\CouponDataTable;
use Mail;
use Carbon\Carbon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CouponDataTable $dataTable)
    {
        return $dataTable->render('admin.coupon.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupon.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:200'],
            'code' => ['required', 'max:200'],
            'value' => ['required', 'max:200', 'integer'],
            'min_price' => ['required', 'integer'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'type' => ['required'],
        ]);

        $coupon = new Discount();
        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->value = $request->value;
        $coupon->min_price = $request->min_price;
        $coupon->min_order = $request->min_order;
        $coupon->max_price = $request->max_price;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->type = $request->type;
        $coupon->check_use = 0;
        $coupon->save();
        toastr('Thêm mã thành công!', 'success', 'Thành công');
        return redirect()->route('admin.coupon.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(string $id)
    {
        $coupon = Discount::findOrFail($id);
        return view('admin.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:200'],
            'code' => ['required', 'max:200'],
            'value' => ['required', 'max:200', 'integer'],
            'min_price' => ['required', 'integer'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'type' => ['required'],
        ]);
        $coupon = Discount::findOrFail($id);
        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->value = $request->value;
        $coupon->min_price = $request->min_price;
        $coupon->min_order = $request->min_order;
        $coupon->max_price = $request->max_price;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->type = $request->type;
        $coupon->check_use = 0;
        $coupon->save();
        toastr('Cập nhật thành công!', 'success', 'Thành công');
        return redirect()->route('admin.coupon.index');
    }

    public function sendIndex($id)
    {
        $coupon = Discount::findOrFail($id);
        $customers = Customer::where('status', 'active')->get();
        return view('admin.coupon.send', compact('coupon', 'customers'));
    }

    public function sendMail(Request $request)
    {
       

        $discount = Discount::findOrFail($request->coupon_id);
        $coupon = array(
            'name' => $discount->name,
            'code' => $discount->code,
            'type' => $discount->type,
            'value' => $discount->value,
            'min_price' => $discount->min_price,
            'max_price' => $discount->max_price,
            'min_order' => $discount->min_order,
            'start_date' => $discount->start_date,
            'end_date' => $discount->end_date,
        );
        
        if($request->type == 1){
            $customers = Customer::where('status' ,'active')->get();
            $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
            $title_email = $discount->name;
            $data = [];
            foreach($customers as $vip){
                $checkCoupon = CheckCoupon::where([ 
                    'user_id' => $vip->id,    
                    'coupon_id' => $discount->id, 
                ])->first();
                if(!$checkCoupon){
                    $temp = new CheckCoupon();
                    $temp->user_id = $vip->id;
                    $temp->coupon_id = $discount->id;
                    $temp->status = 0;
                    $temp->save();
                }

                $data['email'][] = $vip->email;
            }
            Mail::send('admin.coupon.mail', ['coupon'=>$coupon], function($message)use ($title_email, $data){
                $message->to($data['email'])->subject($title_email);
                $message->from($data['email'], $title_email);
            });
            toastr('Mã khuyến mãi đã được gửi đến tất cả khách hàng!', 'success');
    
        }else if($request->type == 2){
            $customer_vip = Customer::where(['vip'=> 1, 'status' => 'active'])->get();
            $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
            $title_email = $discount->name;
            $data = [];
            foreach($customer_vip as $vip){
                $checkCoupon = CheckCoupon::where([ 
                    'user_id' => $vip->id,    
                    'coupon_id' => $discount->id, 
                ])->first();
                if(!$checkCoupon){
                    $temp = new CheckCoupon();
                    $temp->user_id = $vip->id;
                    $temp->coupon_id = $discount->id;
                    $temp->status = 1;
                    $temp->save();
                }
                $data['email'][] = $vip->email;
            }
            Mail::send('admin.coupon.mail', ['coupon'=>$coupon], function($message)use ($title_email, $data){
                $message->to($data['email'])->subject($title_email);
                $message->from($data['email'], $title_email);
            });
            toastr('Mã khuyến mãi đã được gửi đến khách hàng VIP!', 'success');

        }else if($request->type == 3){
            $customer = Customer::where(['vip'=> 0, 'status' => 'active'])->get();
            $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
            $title_email = $discount->name;
            $data = [];
            foreach($customer as $vip){
                $checkCoupon = CheckCoupon::where([ 
                    'user_id' => $vip->id,    
                    'coupon_id' => $discount->id, 
                ])->first();
                if(!$checkCoupon){
                    $temp = new CheckCoupon();
                    $temp->user_id = $vip->id;
                    $temp->coupon_id = $discount->id;
                    $temp->status = 1;
                    $temp->save();
                }
                $data['email'][] = $vip->email;
            }
            Mail::send('admin.coupon.mail', ['coupon'=>$coupon], function($message)use ($title_email, $data){
                $message->to($data['email'])->subject($title_email);
                $message->from($data['email'], $title_email);
            });
            toastr('Mã khuyến mãi đã được gửi đến khách hàng!', 'success');

        }
        else if($request->type == 4){
            if($request->customer_email){
                $customer = $request->customer_email;
               
                $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
                $title_email = $discount->name;
                $data = [];
                foreach($customer as $vip){
                    $checkCoupon = CheckCoupon::where([ 
                        'user_id' => Customer::where('email', $vip )->id,    
                        'coupon_id' => $discount->id, 
                    ])->first();
                    if(!$checkCoupon){
                        $temp = new CheckCoupon();
                        $temp->user_id = Customer::where('email', $vip )->id;
                        $temp->coupon_id = $discount->id;
                        $temp->status = 1;
                        $temp->save();
                    }
                    $data['email'][] = $vip;
                }
               
                Mail::send('admin.coupon.mail', ['coupon'=>$coupon], function($message)use ($title_email, $data){
                    $message->to($data['email'])->subject($title_email);
                    $message->from($data['email'], $title_email);
                });
                toastr('Mã khuyến mãi đã được gửi khách hàng!', 'success');
    
            }
            toastr('Vui lòng chọn  tài khoản khách hàng cần gửi!', 'error');

            
        }
       
       return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
