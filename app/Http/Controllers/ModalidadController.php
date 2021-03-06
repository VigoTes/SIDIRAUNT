<?php

namespace App\Http\Controllers;

use App\Debug;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modalidad;

class ModalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *  
        
        
        
         
     */
    public function Listar()
    {
        try {
            $modalidades = Modalidad::all();

            return view('Modalidades.ListarModalidades', compact('modalidades'));
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Crear(Request $request)
    {
        try {
            return view('Modalidades.CrearModalidad');
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Guardar(Request $request)
    {
        try {
            $modalidad = new Modalidad();
        
            $modalidad->nombre = request()->nombre;
        
            $modalidad->save();
    
            $datos = 'Fue registrada la modalidad'. $modalidad->name .' exitosamente';
    
            return redirect()->route('Modalidades.Listar')->with('datos', $datos);
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function Editar($id)
    {
        try {
            $modalidad = Modalidad::find($id);

            return view('Modalidades.EditarModalidad', compact(['modalidad']));
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function Actualizar(Request $request)
    {
        try {
            $modalidad = Modalidad::find(request()->codModalidad);

            $modalidad->nombre = request()->nombre;
    
            $modalidad->save();
    
            return redirect()->route('Modalidades.Listar')->with('datos', 'Modalidad actualizada correctamente!');
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function Eliminar($id)
    {
        try {
            Modalidad::destroy($id);

            return redirect()->route('modalidad')->with('datos', 'Registro eliminado correctamente!');
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }
}
