<?php

namespace App\DataTables;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProviderDataTable extends DataTable
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
            $editBtn = "<a href='".route('admin.provider.edit', $query->id)."' class='btn btn-warning status-btn mr-1'><i class='far fa-edit'></i></a>";
            $deleteBtn = "<a href='".route('admin.provider.destroy', $query->id)."'  class='btn btn-danger status-btn ml-1 delete-item'><i class='far fa-trash-alt'></i></a>";
            return $editBtn.$deleteBtn;
        })
        
        ->addColumn('status', function($query){
            if($query->status == 1){
                $text = '<b class="text-success">
                            Đang hợp tác
                        </b>';
            }else if($query->status == 0){
                $text = '<b class="text-danger">
                            Ngừng hợp tác
                        </b>';
            }
            
            return $text;
        })
        ->rawColumns([ 'action', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Provider $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('provider-table')
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
            Column::make('name')->width(160)->title('Tên nhà cung cấp')->addClass('align-middle'),
            Column::make('email')->width(60)->title('Email')->addClass('align-middle'),
            Column::make('phone')->width(140)->title('Số điện thoại')->addClass('align-middle'),
            Column::make('address')->width(180)->title('Đại chỉ')->addClass('align-middle'),
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
        return 'Provider_' . date('YmdHis');
    }
}
