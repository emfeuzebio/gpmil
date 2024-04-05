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
use App\Models\PgradsModel;

class PgradsDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        //https://www.itsolutionstuff.com/post/how-to-add-action-button-in-laravel-yajra-datatablesexample.html#google_vignette
        // https://github.com/yajra/laravel-datatables-html/blob/master/src/Html/Parameters.php
        // https://stackoverflow.com/questions/53808675/how-to-add-action-with-html-button-in-laravel-datatables-8
        // https://doc.hotexamples.com/pt/class/yajra.datatables.html/Builder#method-addAction
        // https://stackoverflow.com/questions/69430580/how-to-make-delete-in-databales-yajra-laravel-8
        // https://medium.com/@boolfalse/laravel-yajra-datatables-1847b0cbc680
        return (new EloquentDataTable($query))
            ->setRowId('id')        
            // ->addColumn('action', 'users.action')
            ->addColumn('action', function($row){
                $btn  = '<a href="javascript:editar()" class="btnEdit btn btn-info btn-sm">View</a>';
                //$btn .= '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Edit</a>';
                //$btn .= '<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])            
            // ->setRowClass('{{ $id % 2 == 0 ? "alert-success" : "alert-warning" }}')
            // ->setRowClass(function ($PgradsModel) {
            //     return $PgradsModel->ativo == 'SIM' ? 'alert-success' : 'alert-warning';
            // })       
        ;
    }

    public function query(PgradsModel $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        //https://yajrabox.com/docs/laravel-datatables/master/html-builder-macro
        //https://github.com/yajra/laravel-datatables-html/blob/master/src/Html/HasEditor.php
        return $this->builder()
                    ->setTableId('pgrads-table')
                    ->columns($this->getColumns())
                    // ->minifiedAjax()
                    // ->minifiedAjax('/pgrads/datatablesAjax', null, ['foo' => 'bar'])                    
                    // ->ajax([
                    //     'url' => route('users.index'),
                    //     'type' => 'GET',
                    //     'data' => 'function(d) { d.key = "value"; }',
                    // ])                    
                    // ->dom('Bfrtip')     //só funciona com DataTables2
                    ->orderBy(1)
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
                        // 'serverSide' => false,
                        // 'processing' => false,
                    ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('id'),
            Column::make('descricao'),
            Column::make('sigla'),
            Column::make('ativo'),
            // Column::make('created_at'),
            // Column::make('updated_at'),
        ];
    }

    protected function filename(): string
    {
        return 'Pgrads_' . date('YmdHis');
    }
}
