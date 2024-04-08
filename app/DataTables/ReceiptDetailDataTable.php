<?php

namespace App\DataTables;

use App\Models\ReceiptDetail;
use App\Models\Product;
use App\Models\Color;
use App\Models\ColorDetail;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReceiptDetailDataTable extends DataTable
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
            $deleteBtn = "<a href='".route('admin.receipt-detail.destroy', $query->id)."'  class='btn    ml-2 delete-item'><i class='icon-size text-danger bx bx-x-circle'></i></a>";
            return $deleteBtn;
        })
        ->addColumn('product_id', function($query) {
            $product = "<span>";
            $receiptDetail = Product::findOrFail($query->product_id);
            $product .= $receiptDetail->name; // Giả sử cột khóa chính của ReceiptDetail là id
            
            $product .= "</span>";
            return $product;
        })
        ->addColumn('color_id', function($query) {
            $product = "<span>";
            $receiptDetail = Color::findOrFail($query->color_id);
            $product .= $receiptDetail->name; // Giả sử cột khóa chính của ReceiptDetail là id
            
            $product .= "</span>";
            return $product;
        })

        ->addColumn('price', function($query) {
            $product = "<span>";
            $product .= number_format($query->price, 0, ',', '.') ; // Giả sử cột khóa chính của ReceiptDetail là id
            
            $product .= "</span>";
            return $product;
        })
        
        
        
        ->rawColumns([ 'action', 'product_id', 'color_id', 'price'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ReceiptDetail $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('receiptdetail-table')
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
            Column::make('product_id')->width(220)->title('Tên sản phẩm')->addClass('align-middle'),
            Column::make('color_id')->width(80)->title('Màu sắc')->addClass('align-middle'),
            Column::make('quantity')->width(80)->title('Số lượng')->addClass('align-middle'),
            Column::make('price')->width(140)->title('Đơn giá')->addClass('align-middle'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(50)
                  
                  ->title('Tùy biến'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ReceiptDetail_' . date('YmdHis');
    }
}
