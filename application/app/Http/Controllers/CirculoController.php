<?php

namespace App\Http\Controllers;

use App\DataTables\CirculosDataTable; 

class CirculoController extends Controller
{
    public function index(CirculosDataTable $dataTable)
    {
        return $dataTable->render('circulos');
    }
}

