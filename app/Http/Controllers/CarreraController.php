<?php

namespace App\Http\Controllers;

use App\Area;
use App\Carrera;
use App\Facultad;
use App\Http\Controllers\Controller;
use App\Modalidad;
use App\Sede;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    public const PAGINACION = 20;

    public function listar()
    {
        $carreras=Carrera::where('codCarrera','>','0')->paginate($this::PAGINACION);
        return view('Carreras.Listar',compact('carreras'));
    }

    public function Crear(){
        $areas=Area::all();
        $facultades=Facultad::all();
        return view('Carreras.Crear',compact('areas','facultades'));

    }
}
