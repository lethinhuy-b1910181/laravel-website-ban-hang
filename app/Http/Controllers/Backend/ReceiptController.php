<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Receipt;
use App\Models\User;
use App\Models\Provider;
use App\Models\ReceiptDetail;
use App\Models\ReceiptProduct;
use App\Models\ColorDetail;
use App\DataTables\ReceiptDataTable;
use App\DataTables\ReceiptDetailDataTable;
use Auth;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\DB;


class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ReceiptDataTable $dataTable)
    {
        return $dataTable->render('admin.receipt.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ReceiptDetailDataTable $dataTable)
    {
        return $dataTable->render('admin.receipt.create');

    }

    public function getProviders(Request $request)
    {
        $colors = ColorDetail::with('color')->where('product_id', $request->id)->get();
        return $colors;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $totalPrice = ReceiptDetail::sum(DB::raw('price * quantity'));
        $receipt = new Receipt();
        $receipt->user_id =  Auth::guard('customer')->user()->id;
        $receipt->provider_id = $request->provider_id;
        $receipt->note = $request->note;
        $current_time = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
        $receipt->input_date = $current_time;
        $receipt->total = $totalPrice;
        $receipt->save();
        if($receipt->save()){
            $receiptDetail = ReceiptDetail::get();
            foreach($receiptDetail as $item){
                $receiptProduct = new ReceiptProduct();
                $receiptProduct->receipt_id = $receipt->id;
                $receiptProduct->product_id = $item->product_id;
                $receiptProduct->color_id = $item->color_id;
                $receiptProduct->price = $item->price;
                $receiptProduct->quantity = $item->quantity;
                $receiptProduct->save();
            }
            ReceiptDetail::truncate();
            
        }

        toastr('Lưu dữ liệu thành công!', 'success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        // $receiptProduct = ReceiptProduct::findOrFail($id);
        $receipt = Receipt::findOrFail($id);
        // $user = User::findOrFail($receipt->user_id);
        // $provider = Provider::findOrFail($receipt->provider_id);
        
        return view('admin.receipt.show', compact('receipt') );
    }

    public function view(string $id)
    {
        dd($id);
        // $receiptProduct = ReceiptProduct::findOrFail($id);
        // $receipt = Receipt::findOrFail($id);
        // $user = User::findOrFail($receipt->user_id);
        // $provider = Provider::findOrFail($receipt->provider_id);
        
        // return view('admin.receipt.show', compact('receipt', 'receiptProduct', 'user') );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $receiptProduct = ReceiptProduct::findOrFail($id);
        // $receipt = Receipt::findOrFail($id);
        // $user = User::findOrFail($receipt->user_id);
        // $provider = Provider::findOrFail($receipt->provider_id);
        
        return view('admin.receipt.show' );
    
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
        $receipt = Receipt::findOrFail($id);
        
        $receiptProduct = ReceiptProduct::where('receipt_id', $id)->delete();
        $receipt->delete();
        return response(['status' => 'success' , 'message' => 'Xóa thành công!']);
    }

    public function changeStatus(Request $request){
        $receipt = Receipt::findOrFail($request->id);
        $receipt->status = $request->status;
        $current_time = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
        $receipt->confirm_date = $current_time;
        $receipt->save();

        return response(['message' => 'Cập nhật trạng thái thành công!']);
    }

    
}
