<?php

namespace App\Http\Controllers;

use App\DataTables\CirculosDataTable; 

class CirculoController extends Controller
{
    public function index(CirculosDataTable $dataTable)
    {
        //somente Admin têm permissão
        $this->authorize('is_admin');

        return $dataTable->render('admin/CirculosDatatable');
    }
}

