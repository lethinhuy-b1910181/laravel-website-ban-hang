<?php

namespace App\DataTables;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ReceiptProduct;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
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
                $viewBtn = "<a href='".route('admin.product.show', $query->id)."' class='status-btn btn btn-info mr-1' ><i class='fas fa-eye  '></i></a>";
                $editBtn = "<a href='".route('admin.product.edit', $query->id)."'class='status-btn btn btn-warning mr-1' ><i class='fas fa-edit  '></i></a>";
                $deleteBtn = "<a href='".route('admin.product.destroy', $query->id)."'  class=' status-btn btn btn-danger  delete-item'><i class=' fas fa-trash-alt'></i></a>";
                return $viewBtn.$editBtn.$deleteBtn;
            })
            ->addColumn('image', function($query){
                return $img = "<img width='80px' height='80px' src='".asset($query->image)."'> </img>";
            })
            ->addColumn('qty', function($query){
                $product = "<span>";
                $receiptDetail = ReceiptProduct::where('product_id', $query->id)->sum('quantity');
                if($receiptDetail){
                    $product = $receiptDetail;
                }else{
                    $product = 0;
                }
               
                
                $product .= "</span>";
                return $product;
            })
            ->addColumn('brand_id', function($query) {
                $product = "<span>";
                $receiptDetail = Brand::findOrFail($query->brand_id);
                $product .= $receiptDetail->name; // Giả sử cột khóa chính của ReceiptDetail là id
                
                $product .= "</span>";
                return $product;
            })
            ->addColumn('category_id', function($query) {
                $product = "<span>";
                $receiptDetail = Category::findOrFail($query->category_id);
                $product .= $receiptDetail->name; // Giả sử cột khóa chính của ReceiptDetail là id
                
                $product .= "</span>";
                return $product;
            })
            ->addColumn('status', function($query){
                if($query->status == 1){
                    $button = '<label class="custom-switch mt-2">
                                <input type="checkbox" checked name="custom-switch-checkbox" data-id="'.$query->id.'" class="custom-switch-input change-status">
                                <span class="custom-switch-indicator"></span>
                            </label>';
                }else if($query->status == 0){
                    $button = '<label class="custom-switch mt-2">
                            <input type="checkbox" name="custom-switch-checkbox" data-id="'.$query->id.'" class="custom-switch-input change-status">
                            <span class="custom-switch-indicator"></span>
                        </label>';
                }
                
                return $button;
            })
            ->addColumn('offer_price', function($query) {
                $product = "<b>";
                $product .= number_format($query->offer_price, 0, ',', '.') ; // Giả sử cột khóa chính của ReceiptDetail là id
                
                $product .= "&#8363;</b>";
                return $product;
            })
            ->rawColumns(['image', 'action', 'status', 'text', 'qty', 'category_id', 'brand_id', 'offer_price'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('product-table')
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
            Column::make('image')->width(100)->title('Hình'),
            Column::make('name')->width(180)->title('Tên sản phẩm'),
            Column::make('offer_price')->width(90)->title('Giá')->addClass('align-middle')->addClass('text-center'),
            Column::make('qty')->width(90)->title('Số lượng')->addClass('text-center')->addClass('align-middle'),
            Column::make('category_id')->width(140)->title('Danh mục')->addClass('align-middle')->addClass('text-center'),
            Column::make('brand_id')->width(140)->title('Thương hiệu')->addClass('align-middle')->addClass('text-center'),
            Column::make('status')->width(100)->title('Hiển thị')->addClass('align-middle')->addClass('text-center'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(120)
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
        return 'Product_' . date('YmdHis');
    }
}
