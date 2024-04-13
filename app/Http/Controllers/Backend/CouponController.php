<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;
use App\DataTables\CouponDataTable;

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
