<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalisisExamen extends Model
{
    protected $table = "analisis_examen";
    protected $primaryKey = "codAnalisis";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'tasaIrregularidad','codExamen'
    ];


    public function generarGruposIguales(){

        $listaExamenes = ExamenPostulante::where('codExamen','=',$this->codExamen)->orderBy('respuestasJSON','ASC')->get();
        
        /*
            Recorremos el vector entero, 
            en cada elemento recorremos  nuevamente el vector pero desde esa posicion para adelante y preguntando uno por uno si el elemento1 == elemento2
            Si sí: creamos un nuevo grupo y añadimos a todos los que encontremos a ese grupo
            Si no: ignoramos y seguimos iterando al siguiente elemento del vector
        
        */
     
        $cantidadExamenesPostulantes = count($listaExamenes);
        
        for ($i=0; $i < $cantidadExamenesPostulantes - 1 ; $i++) {

            if($listaExamenes[$i]->puntajeTotal!=0){
                $grupo = "";
                for ($j=$i+1; $j < $cantidadExamenesPostulantes; $j++) {


                    Debug::mensajeSimple('iterando'.$i."/".$j."// ".$listaExamenes[$i]->nroCarnet); 
                    if($listaExamenes[$i]->respuestasJSON ==  $listaExamenes[$j]->respuestasJSON) //si coincide
                    {
                        if($grupo=="")//si aun no hay un grupo creado para este elemento
                        {
                            $grupo = new GrupoIguales();
                            $grupo->codAnalisis = $this->codAnalisis;
                            $grupo->puntajeAP = $listaExamenes[$i]->puntajeAPT;
                            $grupo->puntajeCON = $listaExamenes[$i]->puntajeAPT;
                            $grupo->puntajeTotal = $listaExamenes[$i]->puntajeAPT;
                            $grupo->correctas = 0;
                            $grupo->incorrectas = 0;
                            $grupo->respuestasJSON = $listaExamenes[$i]->respuestasJSON;
                            $grupo->vectorExamenPostulante = $listaExamenes[$i]->codExamenPostulante.",".$listaExamenes[$j]->codExamenPostulante;
                            $grupo->save();

                        }else{
                            $grupo->añadirExamenPostulante($listaExamenes[$j]->codExamenPostulante);
                        }
                    
                    }//si no, cortamos el reocrrido de j porque si no fue igual el proximo siguiente, los demás tampoco (esta ordenado segun las respuestas)
                    else
                    {
                        Debug::mensajeSimple('cortamos el j='.$j);
                        break;
                    }

                }

            }else{
                Debug::mensajeSimple($i.' es 0,no lo contamos. NroCarnet='.$listaExamenes[$i]);

            }

        }


        return $listaExamenes[1];
         
    }
    
    
    public function generarGruposPatron(){


    }
    
    
    public function generarPostulantesElevados(){



    }






}
