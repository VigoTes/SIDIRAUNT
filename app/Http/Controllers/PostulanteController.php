<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostulanteController extends Controller
{
    //

    public function listar(Request $request){


        $listaPostulantes = Actor::where('codTipoActor','=',1);
        $nombresYapellidos = "";

        if($request->nombresYapellidos!=""){
            $listaPostulantes = $listaPostulantes->where('apellidosYnombres','like','%'.$request->nombresYapellidos.'%');
            $nombresYapellidos = $request->nombresYapellidos;
        }

        $listaPostulantes = $listaPostulantes->get();

        return view('Postulantes.ListarPostulantes',compact('listaPostulantes','nombresYapellidos'));

    }


    public function verPerfil($codPostulante){
        $postulante = Actor::findOrFail($codPostulante);

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
    }


    //REPORTES EXCEL
    public function exportarPostulantes(Request $request){
        $listaPostulantes = Actor::where('codTipoActor','=',1);
        $nombresYapellidos = "";

        if($request->nombresYapellidos!=""){
            $listaPostulantes = $listaPostulantes->where('apellidosYnombres','like','%'.$request->nombresYapellidos.'%');
            $nombresYapellidos = $request->nombresYapellidos;
        }

        $listaPostulantes = $listaPostulantes->get();

        return view('Postulantes.ReporteExcel',compact('listaPostulantes'));
    }

}
