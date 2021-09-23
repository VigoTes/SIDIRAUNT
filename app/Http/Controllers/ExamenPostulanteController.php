<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Debug;
use App\Examen;
use App\ExamenPostulante;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamenPostulanteController extends Controller
{
    const PAGINATION = 50;



    /* 
    
    Retorna la vista en la que se listan todos los postulantes de un examen
    */
    public function listarDeExamen($codExamen,Request $request){
         
        try {

            $codExamen = $request->codExamen;
            $examen = Examen::findOrFail($codExamen);
            $apellidosYnombres = "";
            if($request!=[]){
                $vectorCodigosActores = [];
                $apellidosYnombres = $request->apellidosYnombres;
                $listaActoresConEseNombre = Actor::where('apellidosYnombres','like',"%$apellidosYnombres%")->get();
                foreach($listaActoresConEseNombre as $actor){
                    $vectorCodigosActores[] = $actor->codActor;
                }
                
                $listaExamenes = ExamenPostulante::where('codExamen','=',$codExamen)
                    ->whereIn('codActor',$vectorCodigosActores)
                    ->paginate($this::PAGINATION);
            }else{
                $listaExamenes = ExamenPostulante::where('codExamen','=',$codExamen)->paginate($this::PAGINATION);
            }

                           
    
            return view('Examenes.ListarPostulantesDeExamen',compact('examen','listaExamenes','apellidosYnombres'));
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    //REPORTES EXCEL
    public function exportarPostulantes($codExamen){
        try {
            $examen = Examen::findOrFail($codExamen);
            $listaExamenes = ExamenPostulante::where('codExamen','=',$codExamen)->get();
            
            return view('Examenes.ReportePostulantesExcel',compact('examen','listaExamenes'));
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }


}
