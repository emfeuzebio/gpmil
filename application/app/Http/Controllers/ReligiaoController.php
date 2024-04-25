<?php

namespace App\Http\Controllers;

use App\DataTables\ReligiaosDataTable;

class ReligiaoController extends Controller
{
    public function index(ReligiaosDataTable $dataTable)
    {
        return $dataTable->render('admin/religiaosDatatable');
    }
}

