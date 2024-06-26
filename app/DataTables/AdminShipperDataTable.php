<?php

namespace App\DataTables;

use App\Models\Shipper;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdminShipperDataTable extends DataTable
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
            if($query->status == 1){
                $button = '<label class="custom-switch mt-2">
                            <input type="checkbox" checked name="custom-switch-checkbox" data-id="'.$query->id.'" class="  custom-switch-input change-status">
                            <span class="custom-switch-indicator"></span>
                        </label>';
            }else if($query->status == 0){
                $button = '<label class="custom-switch mt-2">
                        <input type="checkbox" name="custom-switch-checkbox" data-id="'.$query->id.'" class=" custom-switch-input change-status">
                        <span class="custom-switch-indicator"></span>
                    </label>';
            }
            
            return $button;
        })
        
        
            ->rawColumns([  'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Shipper $model): QueryBuilder
    {
        return $model->newQuery();
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
            Column::make('name')->title('Họ tên')->addClass('text-center')->addClass('align-middle'),
            Column::make('image')->title('Avatar')->addClass('text-center')->addClass('align-middle'),
            Column::make('email')->title('Email')->addClass('text-center')->addClass('align-middle'),
            Column::make('phone')->title('Số điện thoại')->addClass('text-center')->addClass('align-middle'),
            Column::make('address')->title('Địa chỉ')->addClass('text-center')->addClass('align-middle'),

            Column::computed('status')->title('Khóa/Mở')->addClass('text-center')->addClass('align-middle')
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
        return 'Shipper_' . date('YmdHis');
    }
}
