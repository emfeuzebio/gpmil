<?php

namespace App\DataTables;

// use App\Models\User;
use App\Models\NivelAcesso;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class NivelAcessosDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('ativo', function ($circulo) {
                return '<span style="color:' . ( $circulo->ativo == 'SIM' ? 'blue' : 'red' ) . '">' . $circulo->ativo . '</span>';
            })            
            ->rawColumns(['ativo'])
            ->setRowId('id');    }

    public function query(NivelAcesso $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        // https://stackoverflow.com/questions/76383452/ordering-a-yajra-datatable-by-created-at-column-in-laravel
        return $this->builder()
                    ->setTableId('nivel-acesso-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    // ->dom('Bfrtip')     
                    ->orderBy(0,'asc')
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

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {

        return [
            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(100)
            //       ->addClass('text-center'),
            Column::make('id')->addClass('text-center'),
            Column::make('nome')->addClass('text-bold'),
            Column::make('sigla'),
            Column::make('descricao'),
            Column::make('ativo')->addClass('text-center'),
        ];
    }
}
