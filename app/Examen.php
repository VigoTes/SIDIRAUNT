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
            
        $archivo = fopen('../storage/app/examenes/'.$this->getNombreArchivoPreguntas(),'r'); //abrimos el archivo en modo lectura (reader)

        $nroPregunta = 1;
        while ($linea = fgets($archivo)) { //recorremos cada linea del archivo
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

    public function procesarArchivoRespuestas(){

        
        $archivo = fopen('../storage/app/examenes/'.$this->getNombreArchivoRespuestas(),'r'); //abrimos el archivo en modo lectura (reader)
 
        $cant = 0;
        while ($linea = fgets($archivo)) { //recorremos cada linea del archivo
            if(mb_strlen($linea)>5) //si no es una linea de datos
            {   
                 
                //$linea = utf8_encode($linea);
                
                $vector = mb_str_split($linea);

                $segundoCaracter = $vector[1];
                if(is_numeric($segundoCaracter))
                {
                    //AQUI YA SE PUEDE DECIR QUE LA LINEA DE DATOS ES DE POSTULANTE
                    
                    //                                      posicion inicial , longitud
                    $orden =                mb_substr($linea,1,4);
                    $carnet=                mb_substr($linea,6,4);
                    $apellidosYNombres=     trim(mb_substr($linea,13,43));
                    $puntajeAPT=            trim(mb_substr($linea,56,7));
                    $puntajeCON=            trim(mb_substr($linea,65,7));
                    $puntajeTotal=          trim(mb_substr($linea,74,7));
                    $puntajeMinimo=         trim(mb_substr($linea,83,7));
                    $escuela=               trim(mb_substr($linea,94,26));
                    $observaciones =        mb_substr($linea,120,7); //este no lo puedo agarrar completo porque varía la longitud, y si me paso agarro el salto de linea
                    
                    $vectorColumnas = [
                            'codExamen'=>$this->codExamen,
                            'respuestasJSON'=>"A",
                            'orden'=>$orden,
                            'carnet'=>$carnet,
                            'apellidosYNombres'=>$apellidosYNombres,
                            'puntajeAPT'=>$puntajeAPT,
                            'puntajeCON'=>$puntajeCON,
                            'puntajeTotal'=>$puntajeTotal,
                            'puntajeMinimo'=>$puntajeMinimo,
                            'escuela'=>$escuela,
                            'observaciones'=>$observaciones
                        ];
                    
                    Debug::imprimirVector($vectorColumnas);   
                    
                    //Debug::imprimir($linea);

                    $cant++;
                }
            }

        }
        
        Debug::mensajeSimple('la cantidad de postulantes es:'.$cant);


    }
 




}
