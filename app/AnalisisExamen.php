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




    /* 
    Le entra:
        parametros del objeto actual
    Tablas alteradas:
        GrupoIguales
    
    */
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
                            $grupo->puntajeCON = $listaExamenes[$i]->puntajeCON;
                            $grupo->puntajeTotal = $listaExamenes[$i]->puntajeTotal;
                            $grupo->correctas = $listaExamenes[$i]->nroCorrectas;
                            $grupo->incorrectas = $listaExamenes[$i]->nroIncorrectas;
                            $grupo->respuestasJSON = $listaExamenes[$i]->respuestasJSON;
                            $grupo->vectorExamenPostulante = $listaExamenes[$i]->codExamenPostulante.",".$listaExamenes[$j]->codExamenPostulante;
                            $grupo->save();

                        }else{
                            $grupo->añadirExamenPostulante($listaExamenes[$j]->codExamenPostulante);
                            //aunque lo pinte de rojo, cuando llega acá es pq ya es un objeto instanciado
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
    
    /* 
    Le entra:
        Parametros del obj actual

    Tablas alteradas:
        GrupoPatron
    
    */
    public function generarGruposPatron(){

        $listaExamenes = ExamenPostulante::where('codExamen','=',$this->codExamen)->get();
        
        /*
            Recorremos el vector entero, 
            en cada elemento recorremos  nuevamente el vector pero desde esa posicion para adelante, en cada una contamos la cantidad de respuestas iguales, obtenemos segun el puntaje la tasa de tolerancia.
                Evaluamos booleano cantRespuestasMarcadas*TasaTolerancia < CantRespuestasIgualesEntreLosDos
                    Si sí: creamos un nuevo grupo guardando en este el patron
                    Si no: ignoramos y seguimos iterando al siguiente elemento del vector
        
        */
        
        $cantidadExamenesPostulantes = count($listaExamenes);
        $examen = Examen::findOrFail($this->codExamen);
        $cantidadMinimaDePreguntasParaPatron = 5; //aqui jalar de parametros
        $cantidadMinimaDePuntajeAdquirido = 20;
        $listaTasas= Tasa::All();

        for ($i=0; $i < $cantidadExamenesPostulantes - 1 ; $i++) {
            $tasa = $listaExamenes[$i]->getTasaTolerancia($listaTasas); //AQUI JALAR DE PARAMETROS


            if($listaExamenes[$i]->puntajeTotal!=0){
                $grupo = "";
                for ($j=$i+1; $j < $cantidadExamenesPostulantes; $j++) {


                    Debug::mensajeSimple('generarGruposPatron iterando'.$i."/".$j."// ".$listaExamenes[$i]->nroCarnet); 
                    
                    //en este vector las posiciones son las keys y las respuestas con los value
                    $vectorRespuestasIguales = ExamenPostulante::compararRespuestas($listaExamenes[$i]->respuestasJSON,$listaExamenes[$j]->respuestasJSON);
                    $cantRespuestasMarcadas = $listaExamenes[$i]->getCantidadRespuestasMarcadas();
                    
                    if($cantRespuestasMarcadas*$tasa < count($vectorRespuestasIguales) && count($vectorRespuestasIguales) > $cantidadMinimaDePreguntasParaPatron
                    ) //
                    {

                        $listaGrupos = GrupoPatron::buscar($vectorRespuestasIguales,$this->codAnalisis); //vemos si ya hay un grupoPatron con ese JSON, aumentamos 1 en ese 
                        if(count($listaGrupos)>0)
                        {
                            $grupo = $listaGrupos[0];
                            $grupo->añadirExamenPostulante($listaExamenes[$j]->codExamenPostulante);
                            //aunque lo pinte de rojo, cuando llega acá es pq ya es un objeto instanciado

                        }
                        else{

                            $vectorCorrectasIncorrectasPuntajes = Examen::compararVectorEspecialPosiciones($vectorRespuestasIguales,$examen); 
                        
                            if($vectorCorrectasIncorrectasPuntajes['puntajeAdquirido'] > $cantidadMinimaDePuntajeAdquirido){
                                    
                                $grupo = new GrupoPatron();
                                $grupo->codAnalisis = $this->codAnalisis;
                                $grupo->nroCorrectas = $vectorCorrectasIncorrectasPuntajes['nroCorrectas'];
                                $grupo->nroIncorrectas = $vectorCorrectasIncorrectasPuntajes['nroIncorrectas'];
                                $grupo->puntajeAdquirido = $vectorCorrectasIncorrectasPuntajes['puntajeAdquirido'];
                                

                                $grupo->respuestasCoincidentesJSON = json_encode($vectorRespuestasIguales);
    
                                $grupo->vectorExamenPostulante = $listaExamenes[$i]->codExamenPostulante.",".$listaExamenes[$j]->codExamenPostulante;
                                $grupo->save();
                        
                            }
                        }


                    
                    }//si no, cortamos el reocrrido de j porque si no fue igual el proximo siguiente, los demás tampoco (esta ordenado segun las respuestas)
                    else
                    {
                        Debug::mensajeSimple('cortamos el j='.$j);
                        
                    }

                }

            }else{
                Debug::mensajeSimple($i.' es 0,no lo contamos. NroCarnet='.$listaExamenes[$i]->nroCarnet);

            }

        }


        return $listaExamenes[1];

    }
    
    /* 
    Le entra:
        Parametros del obj actual

    Tablas alteradas:
        PostulantesElevados
    
    */
    public function generarPostulantesElevados(){



    }






}
