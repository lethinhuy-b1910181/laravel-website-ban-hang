<?php

namespace App\DataTables;

use App\Models\OrderTotal;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Auth;

class ShipperDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($query){
                if($query->shipper_status == 0){
                    $viewBtn = "<a href='".route('shipper.shipper.show',  $query->id)."' >Xem đơn</a>";
                    return $viewBtn;
                }else if($query->shipper_status == 2){
                    $viewBtn = "<a href='".route('shipper.shipper.show',  $query->id)."' class='status-btn btn btn-info mr-2 mb-2'><i class='far fa-eye '></i></a>";
                    return $viewBtn;
                }
                
                else if($query->order_status == 2){
                    $viewBtn = "<a href='".route('shipper.shipper.show',  $query->id)."' class='status-btn btn btn-info mr-2 mb-2'><i class='far fa-eye '></i></a>";
                    $editBtn = "<button data-id='".$query->id."' class='status-btn btn btn-success  mr-2 change-status  mb-2'><i class='bx bx-check-circle '></i></button>";
    
                    $deleteBtn = "<a href='".route('admin.receipt.destroy', $query->id)."' class='delete-item status-btn btn btn-danger mr-1'><i class='far fa-trash-alt'></i></a>";
                    return $viewBtn.$editBtn.$deleteBtn;
                }else if($query->order_status == 3){
                    $viewBtn = "<a href='".route('shipper.shipper.show',  $query->id)."' class='status-btn btn btn-info mr-2 mb-2'><i class='far fa-eye '></i></a>";
                    return $viewBtn;
                }
                else if($query->order_status == 5){
                    $viewBtn = "<a href='".route('shipper.shipper.show',  $query->id)."' class='status-btn btn btn-info mr-2 mb-2'><i class='far fa-eye '></i></a>";
                    return $viewBtn;
                }
                
            })
            ->addColumn('user_id', function($query){
                $address = json_decode($query->order_address);
                $city = \App\Models\City::where('id', $address->city_id)->first();
                $district = \App\Models\District::where('id', $address->district_id)->first();
                $ward = \App\Models\Ward::where('id', $address->ward_id)->first();
                
            
                
                
                return "<b>$address->name</b><div>$address->phone</div><div>$address->address, $ward->name, $district->name, $city->name</div>";
            })
            // ->addColumn('date', function($query){
            //     return date('d-m-Y', strtotime($query->created_at));
            // })

            ->addColumn('amount',  function($query) {
                if($query->payment_method == 'VNPay'){
                    return "<b class='text-danger'>0</b>";
                }else{
                    $product = "<b class='text-danger'>";
                    $product .= number_format($query->amount, 0, ',', '.') ; // Giả sử cột khóa chính của ReceiptDetail là id
                    
                    $product .= "&#8363;</b>";
                    return $product;
                }
                
            })

            ->addColumn('payment_method',  function($query) {
                if($query->payment_method == 'VNPay'){
                    $product = "<b class='text-success '>";
                    $product .= $query->payment_method ; // Giả sử cột khóa chính của ReceiptDetail là id
                    
                    $product .= "</b>";
                }else {
                    $product = "<b class='text-dark'>";
                    $product .= $query->payment_method ; // Giả sử cột khóa chính của ReceiptDetail là id
                    
                    $product .= "</b>";
                }
                
                return $product;
            })
 
            ->addColumn('order_status',  function($query) {
                if($query->order_status == 0){
                    $button = '<span class="btn btn-info btn-sm">Chờ duyệt <i class="fas fa-clock"></i> </span>';
                }else if($query->order_status == 1  && $query->shipper_status == 0){
                    $button = '<span class="btn btn-primary btn-sm">Chờ vận chuyển <i class="fas fa-hourglass-half"></i></span>';
                }else if($query->order_status == 2){
                    $button = '<span class="btn btn-warning btn-sm" >Đang giao hàng <i class="fas fa-truck"></i></span>';
                }
                else if($query->order_status == 3){
                    $button = '<span class="btn btn-success btn-sm">Hoàn thành <i class="fa fa-check"></i></span>';
                }
                else if($query->order_status == 4){
                    $button = '<span class="btn btn-dangerdanger btn-sm">Đã hủy <i class="bx bx-x-circle"></i></span>';
                }
                else if($query->order_status == 5){
                    $button = '<span class="btn btn-danger btn-sm">Không hoàn thành<i class="bx bx-x-circle"></i></span>';
                }
                else if($query->order_status == 1 && $query->shipper_status == 2){
                    $button = '<span class="btn btn-dark btn-sm">Từ chối <i class="bx bx-x-circle"></i></span>';
                }
                
                return $button;
                
            })
            ->rawColumns([ 'amount',  'user_id', 'payment_method', 'order_status', 'action'])

            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(OrderTotal $model): QueryBuilder
    {
        return $model::where('shipper_id', Auth::guard('shipper')->user()->id)->orderBy('order_status', 'asc')->latest()->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('order-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(5,'desc')
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            
            Column::make('id')->title('ID')->addClass('text-center')->addClass('align-middle'),
            Column::make('user_id')->title('Thông tin khách hàng')->addClass('align-middle'),
            Column::make('amount')->title('Tổng thu')->addClass('text-center')->addClass('align-middle'),
            Column::make('payment_method')->title('Phương thức thanh toán')->addClass('text-center')->addClass('align-middle'),
            // Column::make('date')->title('Ngày đặt')->addClass('text-center')->addClass('align-middle'),
            Column::make('order_status')->title('Trạng thái đơn hàng')->addClass('text-center')->addClass('align-middle'),
            Column::computed('action')->title('Tùy biến')->addClass('text-center')->addClass('align-middle')
                  ->exportable(false)
                  ->printable(false)
                  ->width(110)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'OrderTotal_' . date('YmdHis');
    }
}
