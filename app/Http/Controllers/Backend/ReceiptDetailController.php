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

    public function store(Request $request)
{
    // Tạo một bản ghi mới của ReceiptDetail
    $receiptDetail = new ReceiptDetail();
    $receiptDetail->product_id = $request->product_id;
    $receiptDetail->color_id = $request->color_id;
    $receiptDetail->price = $request->price;
    $receiptDetail->quantity = $request->quantity;
    $receiptDetail->save();

    $product = $receiptDetail->product;
    $color = $receiptDetail->color;
    $total = number_format($receiptDetail->price, 0, ',', '.'). '₫';

    // Trả về phản hồi JSON chứa thông tin của bản ghi mới và thông tin của sản phẩm
    return response()->json([
        'success' => true,
        'receiptDetail' => $receiptDetail,
        'product' => $product,
        'color' => $color,
        'total' => $total,
    ]);
}

public function getUpdatedValues()
    {
        $sl = ReceiptDetail::sum('quantity');
        $total = ReceiptDetail::sum(\DB::raw('price * quantity'));

        return response()->json([
            'sl' => $sl,
            'total' => number_format($total, 0, ',', '.')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
        
    //     $receiptDetail = new ReceiptDetail();
    //     $receiptDetail->product_id = $request->product_id;
    //     $receiptDetail->color_id = $request->color_id;
    //     $receiptDetail->price = $request->price;
    //     $receiptDetail->quantity = $request->quantity;
    //     $receiptDetail->save();

    //     toastr('Lưu dữ liệu thành công!', 'success');
    //     return redirect()->back();
    // }

    // public function store(Request $request)
    // {
    //     // Thêm dữ liệu mới vào bảng ReceiptDetail
    //     $receiptDetail = new ReceiptDetail();
    //     $receiptDetail->product_id = $request->product_id;
    //     $receiptDetail->color_id = $request->color_id;
    //     $receiptDetail->price = $request->price;
    //     $receiptDetail->quantity = $request->quantity;
    //     $receiptDetail->save();
    
    //     // Trả về HTML của tất cả dữ liệu trong bảng ReceiptDetail
    //     return response()->json(['success' => true, 'message' => 'Dữ liệu đã được thêm thành công!']);
    // }
    
    // public function getAllReceiptDetailsAsHtml()
    // {
    //     // Lấy tất cả dữ liệu từ bảng ReceiptDetail
        
    //     $receiptDetails = ReceiptDetail::all();
    
    //     // Trả về HTML của tất cả dữ liệu trong bảng ReceiptDetail
    //     return view('admin.receipt.create', compact('receiptDetails'))->render();
    // }
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
    {$receiptDetail = ReceiptDetail::findOrFail($id);
        $receiptDetail->delete();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Xóa thành công!'
        ]);
    }

    public function deleteAll(){
        ReceiptDetail::truncate();
        return response(['status' => 'success' , 'message' => 'Xóa thành công!']);

    }
}
