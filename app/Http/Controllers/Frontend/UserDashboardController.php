<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Customer;
use App\Models\CheckCoupon;

class UserDashboardController extends Controller
{
    public function index(){
        return view('frontend.dashboard');
    }
    public function couponIndex(){
        $coupons = CheckCoupon::where('user_id', Auth::guard('customer')->user()->id)->orderBy('status', 'desc')->get();

        return view('frontend.account.voucher.index', compact('coupons'));
    }

    public function logout(){
        Auth::guard('customer')->logout();
        return redirect()->route('login');
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

        if(Auth::guard('customer')->attempt($credential)) {
            toastr()->success('Đăng nhập thành công!');
            return redirect()->route('user.dashboard');
        }else {
            toastr()->error('Thông tin đăng nhập không chính xác!');

            return redirect()->route('login');
        }
    }

    public function updateProfile(Request $request){

        $request->validate([
            'name' => ['required' , 'max:100'],
            'image' => ['image', 'max:2048']
        ]);
        $user = Customer::where('id', Auth::guard('customer')->user()->id)->first();

        if($request->hasFile('image')){
            if(File::exists(public_path($user->image))){
                File::delete(public_path($user->image));
            }
            $image = $request->image;
            $imageN = rand().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageN);
            $path = 'uploads/'.$imageN;
            $user->image = $path;
        }
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->save();

        toastr()->success('Cập nhật thành công!');
        return redirect()->back();
    }
}
