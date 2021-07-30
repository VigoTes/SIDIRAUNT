<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Area;

class AreaController extends Controller
{
    
    public function index()
    {
        $area = Area::get();
        return view('area.listar',compact('area'));
    }

    public function create()
    {
        return view('area.Crear');
    }

    public function store(Request $request)
    {
        $area = new Area();
        $area->area = $request->area;
        $area->descripcion = $request->descripcion;
        $area->save();

        return redirect()->route('area.index');

    }


    public function show($id)
    {
    }

    public function edit($id)
    {
        $area = Area::find($id);
        return view('area.editar',compact('area'));
    }

    public function update(Request $request, $id)
    {
        $area = Area::find($id);
        $area->area = $request->area;
        $area->descripcion = $request->descripcion;
        $area->save();

        return redirect()->route('area.index');
    }

    /*
    public function destroy($id)
    {
        $area = Area::find($id);
        $area->delete();

        return redirect()->route('area.index');
    }*/

    public function eliminar($id)
    {
        $area = Area::find($id);
        $area->delete();

        return redirect()->route('area.index');
    }
}
