<?php

namespace App\DataTables;

use App\Models\OrderReview;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReviewOrderDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('user_id', function($query){
                return "<span class='text-dark '>" . $query->user->name . "</span><br><span >".$query->user->email."</span>";
              
            })

            ->addColumn('action', function($query){
                $viewBtn = "<a href='".route('admin.order.order-review.show', $query->order_id)."' class='status-btn ' ><i class='far fa-eye icon-size'></i></a>";
                return $viewBtn;
            })

            ->addColumn('star', function($query){
                $starIcons = '';
                // Duyệt qua 5 sao và tạo các biểu tượng tương ứng
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $query->star) {
                        // Tô màu sao đầy
                        $starIcons .= '<i class="fas fa-star" style="color: #ffcc00;"></i>';
                    } else {
                        // Tô màu sao rỗng
                        $starIcons .= '<i class="far fa-star" style="color: #ccc;"></i>';
                    }
                }

                // Trả về chuỗi HTML của các biểu tượng sao
                return $starIcons;
            })
            
            ->rawColumns(['user_id', 'star', 'action'])
            
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(OrderReview $model): QueryBuilder
    {
        return $model->latest()->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('revieworder-table')
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
            Column::make('id')->title('ID')->addClass('text-center')->addClass('align-middle'),
            Column::make('user_id')->title('Khách hàng')->addClass('align-middle'),
            Column::make('order_id')->title('ID đơn hàng')->addClass('text-center')->addClass('align-middle'),
            Column::make('star')->title('Mức đánh giá')->addClass('text-center')->addClass('align-middle'),
            Column::make('review')->title('Nội dung')->addClass('align-middle'),
            Column::computed('action')->title('Tùy biến')->addClass('text-center')->addClass('align-middle')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'OrderReview_' . date('YmdHis');
    }
}
