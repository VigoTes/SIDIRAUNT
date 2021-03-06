<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Carrera;
use App\Debug;
use App\Examen;
use App\ExamenPostulante;
use App\Http\Controllers\Controller;
use App\Parametros;
use Exception;
use Illuminate\Http\Request;

class PostulanteController extends Controller
{
     
    public function listar(Request $request){
        try {
            //filtros
            $nombresYapellidos = $request->nombresYapellidos;
            $algunExamen=$request->algunExamen;
            if(is_null($request->algunExamen)){
                $algunExamen="-1";
            }
            
            $algunaCarrera=$request->algunaCarrera;
            if(is_null($request->algunaCarrera)){
                $algunaCarrera="-1";
            }

            $examenesTotales=Examen::all();
            $carrerasTotales=Carrera::all();
            $listaPostulantes = Actor::where('codTipoActor','=',1);
            

            
            if(!is_null($request->algunExamen) && $request->algunExamen!=-1){
                $listaExamenPostulante=ExamenPostulante::where('codExamen','=',$algunExamen)->get();
                $vector=[];
                foreach ($listaExamenPostulante as $item) {
                    $vector[]=$item->codActor;
                }
                $listaPostulantes = Actor::whereIn('codActor',$vector);
                //$listaPostulantes = $listaPostulantes->where('codExamen','=',$algunExamen);
            }
            if(!is_null($request->algunaCarrera) && $request->algunaCarrera!=-1){
                if(!is_null($request->algunExamen) && $request->algunExamen!=-1){
                    $listaExamenPostulante=ExamenPostulante::where('codCarrera','=',$algunaCarrera)->where('codExamen','=',$algunExamen)->get();
                    $vector=[];
                    foreach ($listaExamenPostulante as $item) {
                        $vector[]=$item->codActor;
                    }
                    $listaPostulantes = Actor::whereIn('codActor',$vector);
                }else{
                    $listaExamenPostulante=ExamenPostulante::where('codCarrera','=',$algunaCarrera)->get();
                    $vector=[];
                    foreach ($listaExamenPostulante as $item) {
                        $vector[]=$item->codActor;
                    }
                    $listaPostulantes = Actor::whereIn('codActor',$vector);
                }
            }
            if($request->nombresYapellidos!=""){
                $listaPostulantes = $listaPostulantes->where('apellidosYnombres','like','%'.$request->nombresYapellidos.'%');
            } 
            
            $listaPostulantes = $listaPostulantes->paginate(Parametros::getTasa('paginacionListarPostulantes'));
            // select count(*) as aggregate from `actor` where `codTipoActor` = 1 and `apellidosYnombres` like "%a%" or "1"="1"

            return view('Postulantes.ListarPostulantes',compact('listaPostulantes','nombresYapellidos','algunExamen','algunaCarrera','examenesTotales','carrerasTotales'));
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    public function miPerfil(){
        try {
            $actorLogeado = Actor::getActorLogeado();
            if(!$actorLogeado->verificarActor('Postulante'))
                throw new Exception("Esta funcion solo es v??lida para los postulantes");
    
            return $this->verPerfil($actorLogeado->codActor);
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    public function verPerfil($codActor){
        try {
            $postulante = Actor::findOrFail($codActor);
        
            $puntajesAPT=[];
            $puntajesCON=[];
            $puntajesTotal=[];
            $periodos=[];
            foreach ($postulante->getPostulacionesAsc() as $item) {
                $puntajesAPT[]=$item->puntajeAPT;
                $puntajesCON[]=$item->puntajeCON;
                $puntajesTotal[]=$item->puntajeTotal;
                $periodos[]=$item->getExamen()->periodo;
            }
    
            
            return view ('Postulantes.VerPostulante',compact('postulante','puntajesAPT','puntajesCON','puntajesTotal','periodos'));
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }


    //REPORTES EXCEL
    public function exportarPostulantes(Request $request){
        try {
            $listaPostulantes = Actor::where('codTipoActor','=',1);
            $nombresYapellidos = "";
    
            if($request->nombresYapellidos!=""){
                $listaPostulantes = $listaPostulantes->where('apellidosYnombres','like','%'.$request->nombresYapellidos.'%');
                $nombresYapellidos = $request->nombresYapellidos;
            }
    
            $listaPostulantes = $listaPostulantes->get();
    
            return view('Postulantes.ReporteExcel',compact('listaPostulantes'));
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

}
