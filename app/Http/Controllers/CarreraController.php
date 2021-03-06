<?php

namespace App\Http\Controllers;

use App\Area;
use App\Carrera;
use App\CarreraExamen;
use App\Debug;
use App\Facultad;
use App\Http\Controllers\Controller;
use App\Modalidad;
use App\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarreraController extends Controller
{
    public const PAGINACION = 100;

    public function listar()
    {
        try {
            $carreras=Carrera::where('codCarrera','>','0')->paginate($this::PAGINACION);
            return view('Carreras.Listar',compact('carreras'));
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    public function Crear(){
        try {
            $areas=Area::all();
            $facultades=Facultad::all();
            return view('Carreras.Crear',compact('areas','facultades'));
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
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
        try {
            $carrera=Carrera::findOrFail($id);

            $areas=Area::all();
            $facultades=Facultad::all();
            return view('Carreras.Editar',compact('areas','facultades','carrera'));
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
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
        try {
            $carrera=Carrera::findOrFail($id);
            $carrera->delete();
    
            return redirect()->route('Carrera.listar')
                ->with('datos','Carrera eliminada.');
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }


    public function verHistorico(){
        try {
            $carrerasExamen=CarreraExamen::all();
            $arr1=[];
            foreach ($carrerasExamen as $item) {
                $arr1[]=$item->codCarrera;
            }
            $carreras=Carrera::whereIn('codCarrera',$arr1)->get();
            $carreraSelected=$carreras[0];

            //para que no se paltee tiene que haber minimo una carrera
            return $this->actualizarHistorico($carreraSelected->codCarrera);
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    public function actualizarHistorico($id){
        try {
            $carrerasExamen=CarreraExamen::all();
            $arr1=[];
            foreach ($carrerasExamen as $item) {
                $arr1[]=$item->codCarrera;
            }
            $carreras=Carrera::whereIn('codCarrera',$arr1)->get();
            $carreraSelected=Carrera::findOrFail($id);
            //$carreras=DB::select('select CAST(fechaHoraLogeo AS DATE) as fecha, COUNT(*) as cantidad from logeo_historial where fechaHoraLogeo>? and fechaHoraLogeo<? group by CAST(fechaHoraLogeo AS DATE)',[$fechaInicio,$fechaFin]);
            
    
            //para que no se paltee tiene que haber minimo una carrera
            $examenesCarrera=DB::TABLE('carrera_examen')
            ->JOIN('examen', 'examen.codExamen', '=', 'carrera_examen.codExamen')
            ->SELECT('carrera_examen.puntajeMinimoPermitido as puntajeMinimoPermitido', 'carrera_examen.puntajeMinimoPostulante as puntajeMinimoPostulante',
                    'carrera_examen.puntajeMaximoPostulante as puntajeMaximoPostulante','examen.periodo as periodo')
            ->where('carrera_examen.codCarrera','=',$carreraSelected->codCarrera)->get();
    
            $puntajesMinimoPermitido=[];
            $puntajesMinimoPostulante=[];
            $puntajesMaximoPostulante=[];
            $periodos=[];
            foreach ($examenesCarrera as $item) {
                $puntajesMinimoPermitido[]=$item->puntajeMinimoPermitido;
                $puntajesMinimoPostulante[]=$item->puntajeMinimoPostulante;
                $puntajesMaximoPostulante[]=$item->puntajeMaximoPostulante;
                $periodos[]=$item->periodo;
            }
    
            return view('Carreras.VerHistorico',compact('carreras','carreraSelected','examenesCarrera','puntajesMinimoPermitido','puntajesMinimoPostulante','puntajesMaximoPostulante','periodos'));
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }
}
