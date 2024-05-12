<?php

namespace App\DataTables;

use App\Models\Receipt;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Auth;

class ReceiptDataTable extends DataTable
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
            if($query->status == 1){
                $viewBtn = "<a href='".route('admin.receipt.show',  $query->id)."' class='status-btn btn btn-primary'><i class='far fa-eye'></i></a>";
                return $viewBtn;
            }else if($query->status == 0){
                $viewBtn = "<a href='".route('admin.receipt.show',  $query->id)."' class='status-btn btn btn-primary mr-1'><i class='far fa-eye '></i></a>";
                if(Auth::guard('admin')->user()->type == 1){
                    $editBtn = "<button data-id='".$query->id."' class='status-btn btn btn-success mr-1 change-status'><i class='bx bx-check-circle'></i></button>";

                }
                else {
                    $editBtn = ''; 
                }
                $deleteBtn = "<a href='".route('admin.receipt.destroy', $query->id)."' class='delete-item status-btn btn btn-danger mr-1'><i class='far fa-trash-alt'></i></a>";
                return $viewBtn.$editBtn.$deleteBtn;
            }
            
        })
        ->addColumn('user_id', function($query){
            $product = "<span>";
            $receiptDetail = User::findOrFail($query->user_id);
            $product .= $receiptDetail->name; // Giả sử cột khóa chính của ReceiptDetail là id
            
            $product .= "</span>";
            return $product;
        })
        ->addColumn('status', function($query){
            if($query->status == 1){
                $text = '<b class="text-success">
                            Đã nhập kho
                        </b>';
            }else if($query->status == 0){
                $text = '<b class="text-warning">
                            Chờ duyệt
                        </b>';
            }
            
            return $text;
        })
        ->addColumn('confirm_date', function($query){
            if($query->status == 1){
                $text = Carbon::parse($query->confirm_date)->format('d-m-y H:i:s');
            }else if($query->status == 0){
                $text = '<b class="text-primary">
                            Chưa xác định
                        </b>';
            }
            
            return $text;
        })
        ->addColumn('input_date', function($query){
            
            $text = Carbon::parse($query->input_date)->format('d-m-y H:i:s');
            return $text;
        })
        ->rawColumns(['action', 'status', 'user_id', 'confirm_date', 'input_date'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Receipt $model): QueryBuilder
    {
        return $model->latest()->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('receipt-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
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
            Column::make('id')->width(50)->title('ID')->addClass('text-center')->addClass('align-middle'),
            Column::make('user_id')->width(120)->title('Người lập phiếu')->addClass('align-middle'),
            // Column::make('note')->width(120)->title('Ghi chú')->addClass('align-middle'),
            Column::make('input_date')->width(140)->title('Ngày nhập')->addClass('align-middle')->addClass('text-center'),
            Column::make('confirm_date')->width(140)->title('Ngày xác nhận')->addClass('align-middle')->addClass('text-center'),
            Column::make('status')->width(100)->title('Trạng thái')->addClass('text-center')->addClass('align-middle'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(100)
                  ->addClass('text-center')
                  ->addClass('align-middle')
                  ->title('Tùy biến'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Receipt_' . date('YmdHis');
    }
}
