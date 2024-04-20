<?php

namespace App\DataTables;

use App\Models\Brand;
use App\Models\Category;
use App\Models\BrandCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BrandDataTable extends DataTable
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
                $editBtn = "<a href='".route('admin.brand.edit', $query->id)."' class='btn btn-info status-btn' ><i class='far fa-edit'></i></a>";
                $deleteBtn = "<a href='".route('admin.brand.destroy', $query->id)."'  class='btn btn-danger status-btn ml-2 delete-item'><i class='far fa-trash-alt'></i></a>";
                return $editBtn.$deleteBtn;
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
            ->addColumn('category', function($query){
                $product = "<span class='text-warning font-weight-bold'>";
                $chitetquyens = BrandCategory::where('brand_id', $query->id)->where('status', 1)->get();
                foreach ($chitetquyens as $item) {
                    $quyen = Category::find($item->category_id);
                    if ($quyen) {
                        $product .= $quyen->name . ", ";
                    }
                }
                // Loại bỏ dấu phẩy cuối cùng nếu có
                $product = rtrim($product, ', ');
                $product .= "</span>";
                return $product;
            })
            ->rawColumns(['image', 'action', 'status', 'category'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Brand $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('brand-table')
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
            Column::make('id')->width(80)->title('ID')->addClass('text-center')->addClass('align-middle'),
            Column::make('name')->width(250)->title('Tên Thương Hiệu')->addClass('align-middle text-dark font-weight-bold'),
            Column::make('category')->width(250)->title('Danh Mục Sản Phẩm')->addClass('align-middle'),
            Column::make('status')->title('Hiển thị')->addClass('text-center')->addClass('align-middle'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(150)
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
        return 'Brand_' . date('YmdHis');
    }
}
