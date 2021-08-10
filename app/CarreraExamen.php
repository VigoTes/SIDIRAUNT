<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarreraExamen extends Model
{
    protected $table = "carrera_examen";
    protected $primaryKey = "codCarreraExamen";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'cantidadVacantes','codExamen','codCarrera','puntajeMinimoPostulante','puntajeMaximoPostulante','puntajeMinimoPermitido'
    ];

    public function getPuntajeMaximoPostulante(){
        $postulaciones = ExamenPostulante::where('codExamen','=',$this->codExamen)
            ->where('codCarrera','=',$this->codCarrera)
            ->where('codCondicion','=','1')
            ->get();


        $maximo = 0;
        $codPostulacionMaximo = 0;
        foreach ($postulaciones as $postulacion) {
            if($postulacion->puntajeTotal > $maximo){
                $maximo = $postulacion->puntajeTotal;
                $codPostulacionMaximo = $postulacion->codExamenPostulante;    
            } 
        }

        return $maximo;

    }


    public function getCantidadIngresantes(){
        $postulaciones = ExamenPostulante::where('codExamen','=',$this->codExamen)
            ->where('codCarrera','=',$this->codCarrera)
            ->where('codCondicion','=','1')
            ->get();

 

        return count($postulaciones);

    }


    public function getPuntajeMinimoPostulante(){
        $postulaciones = ExamenPostulante::where('codExamen','=',$this->codExamen)
            ->where('codCarrera','=',$this->codCarrera)
            ->where('codCondicion','=','1')
            ->get();


        $minimo = 500;
        $codPostulacionMinimo = 0;
        foreach ($postulaciones as $postulacion) {
            if($postulacion->puntajeTotal < $minimo){
                $minimo = $postulacion->puntajeTotal;
                $codPostulacionMinimo = $postulacion->codExamenPostulante;    
            } 
        }

        return $minimo;
    }

    public function getPuntajeMinimoPermitido(){
        $postulaciones = ExamenPostulante::where('codExamen','=',$this->codExamen)
        ->where('codCarrera','=',$this->codCarrera)
        ->where('codCondicion','=','1')
        ->get();

        return $postulaciones[0]->puntajeMinimoPermitido;
        

    }
     


}
