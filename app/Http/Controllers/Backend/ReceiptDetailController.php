<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReceiptDetail;
use App\DataTables\ReceiptDetailDataTable;
class ReceiptDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ReceiptDetailDataTable $dataTable)
    {
        // return $dataTable->render('admin.receipt.create');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $receiptDetail = new ReceiptDetail();
        $receiptDetail->product_id = $request->product_id;
        $receiptDetail->color_id = $request->color_id;
        $receiptDetail->price = $request->price;
        $receiptDetail->quantity = $request->quantity;
        $receiptDetail->save();

        toastr('Lưu dữ liệu thành công!', 'success');
        return redirect()->back();
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
        $receiptDetail =  ReceiptDetail::findOrFail($id);
        $receiptDetail->delete();

        return response(['status' => 'success' , 'message' => 'Xóa thành công!']);
    }

    public function deleteAll(){
        ReceiptDetail::truncate();
        return response(['status' => 'success' , 'message' => 'Xóa thành công!']);

    }
}
