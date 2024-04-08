<?php

namespace App\DataTables;

use App\Models\Admin;
use App\Models\Quyen;
use App\Models\ChiTietQuyen;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        // ->addColumn('action', function($query){
        //     $editBtn = "<a href='".route('admin.role.edit', $query->id)."' class=' status-btn btn btn-primary'><i class='far fa-edit'></i></a>";
        //     return $editBtn;
        // })
        ->addColumn('email', function($query){
            $editBtn = "<a href='".route('admin.loginAs', $query)."' class=''>$query->email</a>";
            return $editBtn;
        })
        ->addColumn('product', function($query) {
            $quyen_id = 1;
            $coquyenClass = $query->check_is_product() ? 'text-success' : 'text-danger';
            $coquyenIcon = $query->check_is_product() ? 'bx bx-check font-28' : 'bx bx-x font-28';
            return "<a href='#'  data-id='".$query->id."' data-quyen-id='".$quyen_id."' class='".$coquyenClass." status-btn btn change-role-btn'><i class='".$coquyenIcon."'></i></a>";
        })
        
        
        
        
        ->addColumn('order', function($query){

            $quyen_id = 3;
            $coquyenClass = $query->check_is_order() ? 'text-success' : 'text-danger';
            $coquyenIcon = $query->check_is_order() ? 'bx bx-check font-28' : 'bx bx-x font-28';
            return "<a href='#' data-id='".$query->id."' data-quyen-id='".$quyen_id."' class='".$coquyenClass." status-btn btn change-role-btn'><i class='".$coquyenIcon."'></i></a>";
            
            
        })

        ->addColumn('blog', function($query){
            
            $quyen_id = 4;
            $coquyenClass = $query->check_is_blog() ? 'text-success' : 'text-danger';
            $coquyenIcon = $query->check_is_blog() ? 'bx bx-check font-28' : 'bx bx-x font-28';
            return "<a href='#' data-id='".$query->id."' data-quyen-id='".$quyen_id."' class='".$coquyenClass." status-btn btn change-role-btn'><i class='".$coquyenIcon."'></i></a>";
            
        })
        ->addColumn('receipt', function($query){
            
            $quyen_id = 2;
            $coquyenClass = $query->check_is_receipt() ? 'text-success' : 'text-danger';
            $coquyenIcon = $query->check_is_receipt() ? 'bx bx-check font-28' : 'bx bx-x font-28';
            return "<a href='#' data-id='".$query->id."' data-quyen-id='".$quyen_id."' class='".$coquyenClass." status-btn btn change-role-btn'><i class='".$coquyenIcon."'></i></a>";
            
        })
            ->rawColumns([ 'product', 'order', 'blog', 'receipt', 'action', 'email'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Admin $model): QueryBuilder
    {
        return $model::where('type',2)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('admin-table')
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
            Column::make('name')->title('Tên nhân viên')->addClass('text-center')->addClass('align-middle'),
            Column::make('email')->title('Email')->addClass('text-center')->addClass('align-middle'),
            Column::make('product')->title('Quyền Sản Phẩm')->addClass('text-center')->addClass('align-middle'),
            Column::make('order')->title('Quyền Duyệt Đơn')->addClass('text-center')->addClass('align-middle'),
            Column::make('blog')->title('Quyền Bài Viết')->addClass('text-center')->addClass('align-middle'),
            Column::make('receipt')->title('Quyền Kiểm Kho')->addClass('text-center')->addClass('align-middle'),
            // Column::computed('action')
            // ->exportable(false)
            // ->printable(false)
            // ->width(100)
            // ->addClass('text-center')
            // ->addClass('align-middle')
            // ->title('Tùy biến'),
           
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Admin_' . date('YmdHis');
    }
}
