<?php

namespace App\DataTables;

use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CouponDataTable extends DataTable
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
                $sendBtn = "<a href='".route('admin.product.edit', $query->id)."'class='status-btn btn btn-info mr-1 ' title='Gửi mã giảm giá' ><i class='fas fa-paper-plane'></i></a>";
                $editBtn = "<a href='".route('admin.coupon.edit', $query->id)."'class='status-btn btn btn-warning mr-1 ' title='Cập nhật mã giảm giá' ><i class='fas fa-edit  '></i></a>";
                $deleteBtn = "<a href='".route('admin.product.destroy', $query->id)."'  class=' status-btn btn btn-danger   delete-item' title='Xóa mã giảm giá'><i class=' fas fa-trash-alt'></i></a>";
                return $sendBtn.$editBtn.$deleteBtn;
            })
            ->addColumn('code', function($query){
                
                return "<b>$query->code</b>";
            })
            ->addColumn('min_price', function($query){
                if($query->type == 1){
                    return number_format($query->min_price, 0, ',', '.') . ' &#8363;';

                }
                else {
                return $query->min_price. ' &#37;';

                }
            })
            ->addColumn('min_order', function($query){
                return number_format($query->min_order, 0, ',', '.') . ' &#8363;';
            })
            ->addColumn('max_price', function($query){
                return number_format($query->max_price, 0, ',', '.') . ' &#8363;';
            })
            ->addColumn('quantity', function($query){
                return $query->value - $query->check_use;
            })
            ->addColumn('status', function($query){
                if ($query->start_date > date('Y-m-d')) {
                    return "<b class='text-success'>Sắp diễn ra</b>";
                } else if($query->end_date < date('Y-m-d')) {
                    return "<b class='text-danger'>Đã hết hạn</b>";

                }else {
                    return "<b class='text-info'>Đang diễn ra</b>";
                }
            })
            ->rawColumns(['action', 'code', 'min_price', 'value', 'min_order', 'min_price', 'max_price', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Discount $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('discount-table')
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
            
            Column::make('id'),
            Column::make('code')->title('Mã giảm giá'),
            Column::make('quantity')->title('Số lượng'),
            Column::make('min_price')->title('Trị giá')->addClass('text-danger font-weight-bold'),
            Column::make('min_order')->title('Đơn tối thiểu')->addClass(' font-weight-bold'),
            Column::make('max_price')->title('Giảm tối đa')->addClass('font-weight-bold'),
            Column::make('status')->title('Tình trạng'),
            Column::computed('action')
                    ->title('Tùy biến')
                  ->exportable(false)
                  ->printable(false)
                  ->width(125)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Discount_' . date('YmdHis');
    }
}
