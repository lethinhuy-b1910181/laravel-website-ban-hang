<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\District;
use App\Models\Ward;
use App\Models\UserAddress;
use Auth;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = UserAddress::where('user_id',Auth::guard('customer')->user()->id)->latest()->get();
        return view('frontend.account.address.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::orderBy('name')->get();
        return view('frontend.account.address.create', compact('cities'));
        
    }
    public function getDistrict($city_id)
    {
        $districts = District::where('city_id', $city_id)->get();
    
        return response()->json($districts);
    }

    public function getWard($district_id)
    {
        $wards = Ward::where('district_id', $district_id)->get();
        return response()->json($wards);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           
            'address' => ['required'],
            'phone' =>['required'],
            'name' =>['required'],
            'city_id' =>['required'],
            'district_id' =>['required'],
            'ward_id' =>['required'],

        ]);

       
        $address = new UserAddress();
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->user_id = Auth::guard('customer')->user()->id;
        $address->city_id = $request->city_id;
        $address->district_id = $request->district_id;
        $address->ward_id = $request->ward_id;
        $address->save();

        toastr()->success('Thêm địa chỉ thành công!');
        return redirect()->route('user.address.index');
        
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
        $address = UserAddress::findOrFail($id);
        $wards = Ward::get();

        $districts = District::get();
        $cities = City::get();

        
        return view('frontend.account.address.edit', compact('address', 'cities','wards' ,'districts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
           
            'address' => ['required'],
            'phone' =>['required'],
            'name' =>['required'],
            'city_id' =>['required'],
            'district_id' =>['required'],
            'ward_id' =>['required'],

        ]);

       
        $address = UserAddress::findOrFail($id);
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->user_id = Auth::guard('customer')->user()->id;
        $address->city_id = $request->city_id;
        $address->district_id = $request->district_id;
        $address->ward_id = $request->ward_id;
        $address->save();

        toastr()->success('Cập nhật địa chỉ thành công!');
        return redirect()->route('user.address.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $address = UserAddress::findOrFail($id);
    
        $address->delete();
        
        return response(['status' => 'success' , 'message' => 'Xóa thành công!']);
    }
}
