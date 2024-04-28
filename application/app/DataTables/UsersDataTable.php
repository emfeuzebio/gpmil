<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            // ->addColumn('action', 'users.action')
            ->editColumn('created_at', function ($param) { return date("d/m/Y H:i:s", strtotime($param->created_at)); })
            ->editColumn('updated_at', function ($param) { return date("d/m/Y H:i:s", strtotime($param->updated_at)); })
            ->setRowId('id');
    }

    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('users-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    // ->dom('Bfrtip')
                    ->orderBy(2, 'asc')
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        // Button::make('reset'),
                        // Button::make('reload')
                    ])
                    ->parameters([
                        'paging' => true,
                        'searching' => true,
                        'pageLength' => 10,
                        'lengthMenu' => [5, 10, 25, 50, 100],
                        'language' => [
                            'url' => url('vendor/datatables/DataTables.pt_BR.json')
                        ],
                    ]);
    }

    public function getColumns(): array
    {

        return [
            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('text-center'),
            Column::make('id'),
            Column::make('name'),
            Column::make('email'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];

        // return [
        //     Column::computed('action')
        //           ->exportable(false)
        //           ->printable(false)
        //           ->width(60)
        //           ->addClass('text-center'),
        //     Column::make('id'),
        //     Column::make('add your columns'),
        //     Column::make('created_at'),
        //     Column::make('updated_at'),
        // ];
    }

    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
