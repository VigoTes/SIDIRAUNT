<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    protected $table = "examen";
    protected $primaryKey = "codExamen";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'año','fechaRendicion','nroVacantes','nroPostulantes','asistentes','codModalidad','codSede','codEstado','valoracionRespuestasJSON'
    ];


    /* FORMATO DE NOMBRES DE LOS ARCHIVOS    
        Examen-000002-respuestas
        Examen-000002-preguntas
        Examen-000002-examenEscaneado
    */

    
    public function getNombreArchivoRespuestas(){
        return "Examen-".Debug::rellernarCerosIzq($this->codExamen,6)."-respuestas.txt";
    }

    public function getNombreArchivoPreguntas(){
        return "Examen-".Debug::rellernarCerosIzq($this->codExamen,6)."-preguntas.txt";
    }

    public function getNombreArchivoExamenEscaneado(){
        return "Examen-".Debug::rellernarCerosIzq($this->codExamen,6)."-examenEscaneado.pdf";
    }

    

    public function getModalidad(){

        return Modalidad::findOrFail($this->codModalidad);
    }

   

    public function getEstado(){
        return EstadoExamen::findOrFail($this->codEstado);
    }
    public function getSede(){
        return Sede::findOrFail($this->codSede);
    }

    public function verificarEstado($nombreEstado){
        $estado = $this->getEstado();

        return $estado->descripcion == $nombreEstado;

    }


    //lee el archivo de las preguntas y las inserta en la base de datos
    public function procesarArchivoPreguntas(){
            
        $archivo = fopen('../storage/app/examenes/'.$this->getNombreArchivoPreguntas(),'r');

        $nroPregunta = 1;
        while ($linea = fgets($archivo)) {
            $respuesta = substr($linea,1,1);
            $enunciado = substr($linea,4,(strlen($linea)-6)); //Son 6 porque 4 son de inicio (la respuesta) y los otros dos son de fin de linea e inicio de linea
            
            Debug::mensajeSimple('pregunta="'.$enunciado.'" respuesta="'.$respuesta.'" nro="'.$nroPregunta.'" lengt='.(strlen($linea)-6) );
            $pregunta = new Pregunta();
            $pregunta->nroPregunta = $nroPregunta;
            $pregunta->enunciado = $enunciado;
            $pregunta->codExamen = $this->codExamen;
            $pregunta->respuestaCorrecta = $respuesta;
            $pregunta->save();
            
            $nroPregunta++;
        }
        

    }







}
