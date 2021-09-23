<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Area;
use App\Debug;

class AreaController extends Controller
{
    
    public function index()
    {
        try {
            $area = Area::get();
            return view('Areas.ListarArea',compact('area'));
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    public function create()
    {
        try {
            return view('Areas.CrearArea');
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    public function store(Request $request)
    {
        try {
            $area = new Area();
            $area->area = $request->area;
            $area->descripcion = $request->descripcion;
            $area->save();
    
            return redirect()->route('area.index');
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
            $area = Area::find($id);
            return view('Areas.EditarArea',compact('area'));
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $area = Area::find($id);
            $area->area = $request->area;
            $area->descripcion = $request->descripcion;
            $area->save();
    
            return redirect()->route('area.index');
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
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
        try {
            $area = Area::find($id);
            $area->delete();
    
            return redirect()->route('area.index');
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }
}
