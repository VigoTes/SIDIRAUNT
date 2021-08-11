<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Facultad;

class FacultadController extends Controller
{
    public function index()
    {
        $facultad = Facultad::get();
        return view('Facultad.Listar',compact('facultad'));
    }

    public function create()
    {
        return view('Facultad.Crear');
    }

    public function store(Request $request)
    {
        $facultad = new Facultad();
        $facultad->nombre = $request->nombre;
        $facultad->save();

        return redirect()->route('facultad.index');

    }


    public function show($id)
    {
    }

    public function edit($id)
    {
        $facultad = Facultad::find($id);
        return view('Facultad.Editar',compact('facultad'));
    }

    public function update(Request $request, $id)
    {
        $facultad = Facultad::find($id);
        $facultad->nombre = $request->nombre;
        $facultad->save();

        return redirect()->route('facultad.index');
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
        $facultad = Facultad::find($id);
        $facultad->delete();

        return redirect()->route('facultad.index');
    }
}
