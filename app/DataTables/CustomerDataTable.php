<?php

namespace App\DataTables;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CustomerDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('status', function($query){
            if($query->status == 'active'){
                $button = '<label class="custom-switch mt-2">
                            <input type="checkbox" checked name="custom-switch-checkbox" data-id="'.$query->id.'" class="  custom-switch-input change-status">
                            <span class="custom-switch-indicator"></span>
                        </label>';
            }else if($query->status == 'inactive'){
                $button = '<label class="custom-switch mt-2">
                        <input type="checkbox" name="custom-switch-checkbox" data-id="'.$query->id.'" class=" custom-switch-input change-status">
                        <span class="custom-switch-indicator"></span>
                    </label>';
            }
            
            return $button;
        })
        ->addColumn('action', function($query){
            $viewBtn = "<a href='".route('admin.customer.show', $query->id)."' class='status-btn btn btn-info mr-1' ><i class='fas fa-eye  '></i></a>";
            $deleteBtn = "<a href='".route('admin.product.destroy', $query->id)."'  class=' status-btn btn btn-danger  delete-item'><i class=' fas fa-trash-alt'></i></a>";
            return $viewBtn.$deleteBtn;
        })
        ->addColumn('image', function($query){
            return $img = "<img width='60px' height='60px' src='".asset($query->image)."'> </img>";
        })
        ->rawColumns([  'status', 'image', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Customer $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('customer-table')
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
            Column::make('name')->title('Họ tên')->addClass('align-middle'),
            Column::make('image')->title('Avatar')->addClass('text-center')->addClass('align-middle'),
            Column::make('email')->title('Email')->addClass('align-middle'),
            Column::make('phone')->title('Số điện thoại')->addClass('text-center')->addClass('align-middle'),

            Column::computed('status')->title('Khóa/Mở')->addClass('text-center')->addClass('align-middle')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::computed('action')->title('Tùy biến')->addClass('text-center')->addClass('align-middle')
            ->exportable(false)
            ->printable(false)
            ->width(100)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Customer_' . date('YmdHis');
    }
}