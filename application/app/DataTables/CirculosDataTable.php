<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder; 
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Models\Circulo;
// use App\Models\User;

class CirculosDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            // ->addColumn('action', 'circulos.action')
            // ->addColumn('action', 'buttons')  
            ->addColumn('created_at', function ($circulo) {
                return $circulo->created_at->format('d/m/Y');
            })            
            ->addColumn('ativo', function ($circulo) {
                return '<span class="' . ( $circulo->ativo == 'SIM' ? 'text-primary' : 'text-danger' ) . '">' . $circulo->ativo . '</span>';
            })            
            ->rawColumns(['ativo'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Circulo $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        // https://stackoverflow.com/questions/76383452/ordering-a-yajra-datatable-by-created-at-column-in-laravel
        return $this->builder()
                    ->setTableId('circulos-table')
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
                        // 'language' => [
                        //     'url' => url('vendor/datatables/DataTables.pt_BR.json')
                        // ],
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
            Column::make('sigla'),
            Column::make('descricao')->addClass('text-bold'),
            Column::make('ativo')->addClass('text-center'),
            // Column::make('created_at')->addClass('text-center')->title('Criando em'),
            // Column::make('ativo')->addClass('text-center')->render(function () {}),  //não sei como usa
            // Column::make('created_at'),
            // Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Circulos_' . date('YmdHis');
    }
}
