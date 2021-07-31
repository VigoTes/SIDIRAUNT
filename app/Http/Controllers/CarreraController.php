<?php

namespace App\Http\Controllers;

use App\Area;
use App\Carrera;
use App\Debug;
use App\Facultad;
use App\Http\Controllers\Controller;
use App\Modalidad;
use App\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function guardar(Request $request){
        try{
            DB::beginTransaction();

            $carrera=new Carrera();
            $carrera->nombre=$request->nombre;
            $carrera->abreviacionMayus=$request->abreviacion;
            $carrera->codAreaActual=$request->codArea;
            $carrera->codFacultad=$request->codFacultad;
            
            $carrera->save();

 
            DB::commit();
            return redirect()->route('Carrera.listar')
            ->with('datos','Carrera creada.');

        } catch (\Throwable $th) {
            //Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : OBSERVAR',$th);
           
            DB::rollBack();
            
            return redirect()->route('Carrera.listar')
            ->with('datos','Ha ocurrido un error interno.');
        }

    }

    public function editar($id){
        $carrera=Carrera::findOrFail($id);

        $areas=Area::all();
        $facultades=Facultad::all();
        return view('Carreras.Editar',compact('areas','facultades','carrera'));
    }

    public function update(Request $request){
        try{
            DB::beginTransaction();

            $carrera=Carrera::findOrFail($request->codCarrera);
            $carrera->nombre=$request->nombre;
            $carrera->abreviacionMayus=$request->abreviacion;
            $carrera->codAreaActual=$request->codArea;
            $carrera->codFacultad=$request->codFacultad;
            
            $carrera->save();

 
            DB::commit();
            return redirect()->route('Carrera.listar')
            ->with('datos','Carrera editada.');

        } catch (\Throwable $th) {
            //Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : OBSERVAR',$th);
           
            DB::rollBack();
            
            return redirect()->route('Carrera.listar')
            ->with('datos','Ha ocurrido un error interno.');
        }

    }

    public function eliminar($id){
        $carrera=Carrera::findOrFail($id);
        $carrera->delete();

        return redirect()->route('Carrera.listar')
            ->with('datos','Carrera eliminada.');
    }
}
