<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Quyen;
use App\Models\City;
use App\Models\OrderTotal;
use App\Models\ChiTietQuyen;
use App\Models\Statistical;
use App\DataTables\CustomerDataTable;
use App\DataTables\AdminDataTable;
use App\DataTables\AdminShipperDataTable;
use App\Mail\Websitemail;
use Carbon\Carbon;
use Hash;
use Auth;

class AdminController extends Controller
{
    public function dashboard(){
        $products = Product::where('sales' ,'>', 0)->orderBy('sales', 'desc')->take(10)->get();
        $total_order = Statistical::sum('total_order');
        $total_sale = Statistical::sum('sales');
        $total_profit = Statistical::sum('profit');


        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;


        $isCurrentMonth = $currentMonth == $currentMonth;

        $total_order = OrderTotal::whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $currentMonth)
                    ->count();

        $newOrders = OrderTotal::whereYear('created_at', $currentYear)
        ->whereMonth('created_at', $currentMonth)
        ->where('order_status', 0)
        ->count();

        // Lọc và tính tổng số đơn hàng đang giao (order_status = 2)
        $shippingOrders = OrderTotal::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->where('order_status', 2)
            ->count();

        // Lọc và tính tổng số đơn hàng đã hoàn thành (order_status = 3)
        $completedOrders = OrderTotal::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->where('order_status', 3)
            ->count();

            $canceledOrders = OrderTotal::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->where('order_status', 4)
            ->count();
        return view('admin.dashboard', compact('products', 'total_order', 'total_sale', 'total_profit', 'completedOrders', 'shippingOrders', 'newOrders', 'isCurrentMonth', 'canceledOrders'));
    }

    public function indexStaff(AdminDataTable $dataTable)
    {
        return $dataTable->render('admin.staff.index');
    }

    public function indexCustomer(CustomerDataTable $dataTable)
    {
        return $dataTable->render('admin.customer.index');
    }

    public function indexShipper(AdminShipperDataTable $dataTable)
    {
        return $dataTable->render('admin.shipper.index');
    }
    public function login(){
        return view('admin.auth.login');
    }

    public function createStaff(){
        $quyens = Quyen::get();
        return view('admin.staff.create', compact('quyens'));
    }

    public function createCustomer(){
        $cities = City::orderBy('name')->get();

        return view('admin.customer.create', compact('cities'));
    }
    public function showCustomer($id){
        $user = Customer::where('id', $id)->first();
        return view('admin.customer.show', compact('user'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required',
            'quyen_id' => 'required',
        ]);

        $obj = new Admin();
        $obj->name = $request->name;
        $obj->email = $request->email;
        $obj->password = Hash::make($request->password);
        $obj->type = 2;
        $obj->save();

        if($obj->save()){
            $items = $request->quyen_id;
             
            if(!empty($items)){
                foreach($items as $item){
                    
                    $data = new ChiTietQuyen();
                    $data->admin_id = $obj->id;
                    $data->quyen_id = $item;
                    $data->coquyen = 1;
                    $data->save();
                }
            }
        }

        toastr()->success('Thêm tài khoản thành công!');
        

        return redirect()->route('admin.staff.index');
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

        if(Auth::guard('admin')->attempt($credential)) {
            $user = Auth::guard('admin')->user();
            if ($user->isSuperAdmin()) {
                toastr()->success('Đăng nhập thành công!');
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasPermission(['product'])) {
                toastr()->success('Đăng nhập thành công!');
                return redirect()->route('admin.product.index');
            }elseif ($user->hasPermission(['receipt'])) {
                toastr()->success('Đăng nhập thành công!');
                return redirect()->route('admin.receipt.index');
            }elseif ($user->hasPermission(['order'])) {
                toastr()->success('Đăng nhập thành công!');
                return redirect()->route('admin.order.index');
            }elseif ($user->hasPermission(['blog'])) {
                toastr()->success('Đăng nhập thành công!');
                return redirect()->route('admin.slider.index');
            }
        }else {
            toastr()->error('Thông tin đăng nhập không chính xác!');

            return redirect()->route('admin.login');
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }


/**Profile Controller */
    public function profile(){
        return view('admin.profile.index');
    }


/** End Profile Controller */

    public function changeStatus(Request $request){
        $brand = Admin::findOrFail($request->id);
        
        $brand->status = $request->status ? 1 : 0;
        $brand->save();

        return response(['message' => 'Cập nhật trạng thái thành công!']);
    }

    public function loginAs(Admin $admin)
    {
        // dd($admin->email);
        
        Auth::guard('admin')->logout(); 
    
        if (Auth::guard('admin')->attempt(['email' => $admin->email, 'password' => 'password'])) {
            $user = Auth::guard('admin')->user();
            if ($user->hasPermission(['product'])) {
                toastr()->success('Đăng nhập thành công!');
                return redirect()->route('admin.product.index');
            } elseif ($user->hasPermission(['receipt'])) {
                toastr()->success('Đăng nhập thành công!');
                return redirect()->route('admin.receipt.index');
            } elseif ($user->hasPermission(['order'])) {
                toastr()->success('Đăng nhập thành công!');
                return redirect()->route('admin.order.index');
            } elseif ($user->hasPermission(['blog'])) {
                toastr()->success('Đăng nhập thành công!');
                return redirect()->route('admin.slider.index');
            }
        } else {
            return back()->with('error', 'Đăng nhập không thành công!');
        }
    } 
    

    
}
