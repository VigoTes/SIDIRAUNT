<?php

namespace App\Http\Controllers;

use App\Debug;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Facultad;

class FacultadController extends Controller
{
    public function index()
    {
        try {
            $facultad = Facultad::get();
            return view('Facultades.Listar',compact('facultad'));
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    public function create()
    {
        try {
            return view('Facultades.Crear');
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    public function store(Request $request)
    {
        try {
            $facultad = new Facultad();
            $facultad->nombre = $request->nombre;
            $facultad->save();
    
            return redirect()->route('facultad.index');
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }


    public function show($id)
    {
    }

    public function edit($id)
    {
        try {
            $facultad = Facultad::find($id);
            return view('Facultades.Editar',compact('facultad'));
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $facultad = Facultad::find($id);
            $facultad->nombre = $request->nombre;
            $facultad->save();
    
            return redirect()->route('facultad.index');
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    /*
    public function destroy($id)
    {
        $facultad = Facultad::find($id);
        $facultad->delete();

        return redirect()->route('facultad.index');
    }*/

    public function eliminar($id)
    {
        try {
            $facultad = Facultad::find($id);
            $facultad->delete();
    
            return redirect()->route('facultad.index');
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }
}
