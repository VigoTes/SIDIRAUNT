<?php

namespace App\Http\Controllers;

use App\Examen;
use App\ExamenPostulante;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamenPostulanteController extends Controller
{
    //


    /* 
    
    Retorna la vista en la que se listan todos los postulantes de un examen
    */
    public function listarDeExamen($codExamen){
        $examen = Examen::findOrFail($codExamen);
        $listaExamenes = ExamenPostulante::where('codExamen','=',$codExamen)->get();
            
        return view('Examenes.ListarPostulantesDeExamen',compact('examen','listaExamenes'));   

    }



}
