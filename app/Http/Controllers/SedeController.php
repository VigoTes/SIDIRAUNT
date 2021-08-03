<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sede;

class SedeController extends Controller
{
    public function index()
    {
        $sedes = Sede::all();

        return view('sede.listar', compact('sedes'));
    }

}
