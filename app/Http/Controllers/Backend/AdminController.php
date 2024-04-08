<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Quyen;
use App\Models\ChiTietQuyen;
use App\DataTables\AdminDataTable;
use App\DataTables\AdminShipperDataTable;
use App\Mail\Websitemail;
use Hash;
use Auth;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function indexStaff(AdminDataTable $dataTable)
    {
        return $dataTable->render('admin.staff.index');
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

        // if($obj->save()){
        //     $data = new ChiTietQuyen();

        //     $data->admin_id = $obj->id;
        //     $data->quyen_id = $request->quyen_id;
        //     $data->coquyen = 1;
        //     $data->save();
        // }

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
