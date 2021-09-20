<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AnalisisExamen extends Model
{
    protected $table = "analisis_examen";
    protected $primaryKey = "codAnalisis";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'tasaIrregularidad','codExamen'
    ];

    public function getExamen(){
        return Examen::findOrFail($this->codExamen);
    }




    /* 
    Le entra:
        parametros del objeto actual
    Tablas alteradas:
        GrupoIguales
    
    */
    public function generarGruposIguales(){
        $codExamen = $this->codExamen;
        /* 
        $consultaSQL = "SELECT 
            GROUP_CONCAT(codExamenPostulante) as 'vectorPostulaciones',
            respuestasJSON, 
            count(*) as 'cantEstudiantes' 
                FROM `examen_postulante`
                where codExamen = $codExamen and puntajeTotal>0
                GROUP by respuestasJSON
                HAVING count(*)>1";
        */

        //Lo convertimos en un SP
        $consultaSQL = "CALL `sp_consultarExamenesIguales`($codExamen);";

        $listaGruposSelect = DB::select($consultaSQL); 
         
        //obtenemos un vector en el que cada elemento es [vectorPostulaciones,respuestasJSON,cantEstudiantes]
        
        foreach ($listaGruposSelect as $itemGrupoSelect){
            $vectorPostulaciones = explode(",",$itemGrupoSelect->vectorPostulaciones);
            $postulacion =ExamenPostulante::findOrFail($vectorPostulaciones[0]);

            $grupo = new GrupoIguales();
            $grupo->codAnalisis = $this->codAnalisis;
            $grupo->puntajeAP =    $postulacion->puntajeAPT;
            $grupo->puntajeCON =   $postulacion->puntajeCON;
            $grupo->puntajeTotal = $postulacion->puntajeTotal;
            $grupo->correctas =    $postulacion->nroCorrectas;
            $grupo->incorrectas =  $postulacion->nroIncorrectas;
            $grupo->respuestasJSON = $itemGrupoSelect->respuestasJSON;
            $grupo->vectorExamenPostulante =  $itemGrupoSelect->vectorPostulaciones;
            $grupo->save();
        }
        return "1";

    }
    
    /* 
    Le entra:
        Parametros del obj actual

    Tablas alteradas:
        GrupoPatron
    
    */
    public function generarPreGruposPatron(){
        $cantidadMinimaDePuntajeAdquirido = 50;
        $maximaDiferenciaDePuntajeParaComparar = 0.3; // si sus puntajes difieren más del 40% que el mayor, no se compararán
        $listaExamenes = ExamenPostulante::where('codExamen','=',$this->codExamen)
            ->where('puntajeTotal','>',$cantidadMinimaDePuntajeAdquirido)
            ->orderBy('puntajeTotal','DESC')
            ->get();
        
        /*
            Recorremos el vector entero, 
            en cada elemento recorremos  nuevamente el vector pero desde esa posicion para adelante, en cada una contamos la cantidad de respuestas iguales, obtenemos segun el puntaje la tasa de tolerancia.
                Evaluamos booleano cantRespuestasMarcadas*TasaTolerancia < CantRespuestasIgualesEntreLosDos
                    Si sí: creamos un nuevo grupo guardando en este el patron
                    Si no: ignoramos y seguimos iterando al siguiente elemento del vector

            En esta etapa de PRE, cada grupoPatron tendrá unicamente 2 postulaciones, 
                debido a que el análisis fue realizado comparando solo 2.
            En la Etapa POST, se eliminarán estos grupoPatron de PRE, para generar los de POST. 
                Los cuales son los de PRE pero agrupados por similitud

        */
        
        $cantidadExamenesPostulantes = count($listaExamenes);
        $examen = Examen::findOrFail($this->codExamen);
        $cantidadMinimaDePreguntasParaPatron = 5; //aqui jalar de parametros
       
        $listaTasas= Tasa::All();
        
        $listaGruposPatronGenerados = [];

        for ($i=0; $i < $cantidadExamenesPostulantes - 1 ; $i++) {
            $tasa = $listaExamenes[$i]->getTasaTolerancia($listaTasas); //AQUI JALAR DE PARAMETROS

            error_log('generarGruposPatron iterando i='.$i."// ".$listaExamenes[$i]->nroCarnet  ); 
            $cantRespuestasMarcadas = $listaExamenes[$i]->getCantidadRespuestasMarcadas();
            $limiteDelVecindario = $listaExamenes[$i]->puntajeTotal*(1-$maximaDiferenciaDePuntajeParaComparar);

            $grupo = "";
            $estaEnVecindario = true;
            for ($j=$i+1; $j < $cantidadExamenesPostulantes && $estaEnVecindario; $j++) {
                /* 
                $diferenciaPorcentual = ($listaExamenes[$i]->puntajeTotal-$listaExamenes[$j]->puntajeTotal)/
                                                                                                    $listaExamenes[$i]->puntajeTotal;
                 */         
                $puntajeJ = $listaExamenes[$j]->puntajeTotal;
                
                if($limiteDelVecindario < $puntajeJ ){
                    // ['1'=>'A']
                    //en este vector las posiciones son las keys y las respuestas con los value
                    $vectorRespuestasIguales = ExamenPostulante::compararRespuestas($listaExamenes[$i]->respuestasJSON,$listaExamenes[$j]->respuestasJSON);
                    
                    //  cantRespuestasLimite para romper tolerancia < cantRespuestasIguales
                    $cantRespuestasIguales = count($vectorRespuestasIguales);
                    $cantidadRespuestasLimite = $cantRespuestasMarcadas*$tasa; // si cantRespuestasIguales pasa de este limite, se detecta irreg
                    
                    error_log('-- i='.$i." j=$j// ".$listaExamenes[$i]->nroCarnet ." cantidadRespuestasLimite=$cantidadRespuestasLimite   cantRespuestasIguales=$cantRespuestasIguales" ); 
                
                    if( $cantidadRespuestasLimite < $cantRespuestasIguales
                        && $cantRespuestasIguales > $cantidadMinimaDePreguntasParaPatron) 
                        {//Si se rompe la tolerancia y supera la cantidad minima de preguntas para un patron, SE DETECTA IRREGULARIDAD

                        //Siempre crearemos un nuevo grupoPatron. Ya en el análisis post lo reduciremos
                        error_log("---------- IRREGULARIDAD DETECTADA i=$i j=$j nroCarnet:".$listaExamenes[$i]->nroCarnet." cantRespuestasIguales=$cantRespuestasIguales // $cantidadRespuestasLimite");
                        
                        // obtenemos nroCorrectas, nroIncorrectas y el puntajeAdquirido
                        $vectorCorrectasIncorrectasPuntajes = Examen::compararVectorEspecialPosiciones($vectorRespuestasIguales,$examen); 
                        if($vectorCorrectasIncorrectasPuntajes['puntajeAdquirido'] > $cantidadMinimaDePuntajeAdquirido){
                            $grupo = new GrupoPatron();
                            $grupo->codAnalisis = $this->codAnalisis;
                            $grupo->nroCorrectas = $vectorCorrectasIncorrectasPuntajes['nroCorrectas'];
                            $grupo->nroIncorrectas = $vectorCorrectasIncorrectasPuntajes['nroIncorrectas'];
                            $grupo->puntajeAdquirido = $vectorCorrectasIncorrectasPuntajes['puntajeAdquirido'];
                            $grupo->respuestasCoincidentesJSON = json_encode($vectorRespuestasIguales);
                            $grupo->vectorExamenPostulante = $listaExamenes[$i]->codExamenPostulante.",".$listaExamenes[$j]->codExamenPostulante;       
                            
                            //no guardaremos aquí el modelo, lo meteremos en este vector para que sea insertado en BD luego.
                            $listaGruposPatronGenerados[] = $grupo; 
                            //esto para mejorar la eficiencia del algoritmo n2

                        }   
                    }

                }else{ //si es mayor, significa que de aquí para adelante solo habrá diferencias mayores. Por lo cual rompemos este for j
                    $estaEnVecindario = false;
                    Debug::mensajeSimple('ROMPIENDO VECINDARIO');
                }
                    
            }
        }



        foreach ($listaGruposPatronGenerados as $grupoPatron) {
            Debug::mensajeSimple('GUARDANDO GRUPO'.json_encode($grupoPatron));
            $grupoPatron->save();
        }

        Debug::mensajeSimple("Se finalizó el generarPreGruposPatron, cantidadExamenesPostulantes=".
            $cantidadExamenesPostulantes.
            " cantGruposPatron=".
            count($listaGruposPatronGenerados)
        );
        
        return 1;

    }
    


    /* 
        en base a los grupos patron encontrados en la etapa PRE, este algoritmo hace 5 veces lo siguiente:
         
        1. Recorremos cada par de la lista de grupoPatrones
        2. En cada par evaluamos si el par se parece o no, en caso de que se parezcan SE FUSIONAN (se crea nuevo GP y se eliminan esos,)

    */
    public function generarPostGruposPatron(){
        
        //HACEMOS 5 ITERACIONES
        for ($z=0; $z < 5 ; $z++) { 
            Debug::mensajeSimple("ITERACIÓN $z de generarPostGruposPatron ");
            $listaGrupos  = GrupoPatron::where('codAnalisis','=',$this->codAnalisis)
                ->orderBy('puntajeAdquirido','DESC')
                ->get();
            $examen = $this->getExamen();
            $porcentajeSimilitudParaUnificar = 0.5; 
            //si al comparar 2 grupoPatron, tienen más de este porcentaje de similitud, los unificaremos en uno solo.
            $nuevosGP = [];
            $cantidadPar = count($listaGrupos) - count($listaGrupos)%2; //Si fuera 9, se convierte en 8. c = 9 - 1 o c = 8 - 0

            for ($i=0; $i < $cantidadPar; $i=$i+2) { 
                $j = $i+1;
                $grupoi = $listaGrupos[$i];
                $grupoj = $listaGrupos[$j];
            
                $preguntasCoincidentes = GrupoPatron::compararCoincidencias($grupoi->respuestasCoincidentesJSON,$grupoj->respuestasCoincidentesJSON);
                    
                $cantPreguntasTotali = $grupoi->getCantidadPreguntas();
                $porcentajeSimilitud = count($preguntasCoincidentes)/$cantPreguntasTotali;

                error_log("i=$i j=$j CantPregCoincid=".count($preguntasCoincidentes)." cantPreg=$cantPreguntasTotali  /psimilitud=$porcentajeSimilitud");
                if($porcentajeSimilitud > $porcentajeSimilitudParaUnificar){ //UNIFICAMOS

                    $vectorCorrectasIncorrectasPuntajes = Examen::compararVectorEspecialPosiciones($preguntasCoincidentes,$examen);
                    error_log("Uniendo el i=$i con el j=$j");
                    $nuevoGPUnificado = new GrupoPatron();
                    $nuevoGPUnificado->codAnalisis = $this->codAnalisis;
                    $nuevoGPUnificado->nroCorrectas = $vectorCorrectasIncorrectasPuntajes['nroCorrectas'];
                    $nuevoGPUnificado->nroIncorrectas = $vectorCorrectasIncorrectasPuntajes['nroIncorrectas'];
                    $nuevoGPUnificado->puntajeAdquirido = $vectorCorrectasIncorrectasPuntajes['puntajeAdquirido'];
                    $nuevoGPUnificado->respuestasCoincidentesJSON = json_encode($preguntasCoincidentes);

                    $vi = explode(',',$grupoi->vectorExamenPostulante);
                    $vj = explode(',',$grupoj->vectorExamenPostulante);
                    $unionPostulantes = array_merge($vi,$vj);
                    $nuevoVectorSinRepetidos = array_unique($unionPostulantes);
                    $nuevoGPUnificado->vectorExamenPostulante = implode(',',$nuevoVectorSinRepetidos); 
                    
                    $nuevoGPUnificado->save();
                    
                    $grupoi->delete();
                    $grupoj->delete();
                    
                    $nuevosGP[] = $nuevoGPUnificado;
                }
            }
        }
        return 1;

 

    }




    /* 
    Le entra:
        Parametros del obj actual

    Tablas alteradas:
        PostulantesElevados
    
    */
    public function generarPostulantesElevados(){

        $tasaToleranciaSubida = Parametros::getTasa('tasaToleranciaSubida'); //si la diferencia es de mas del 80% del examen anterior, es una irregularidad
        $listaExamenes = ExamenPostulante::where('codExamen','=',$this->codExamen)->get();
        foreach ($listaExamenes as $examenPostulante) {
            $examenAnterior = $examenPostulante->getAnteriorExamenPostulante();
            if($examenAnterior!="" && $examenPostulante->puntajeTotal > 60){ //si hubo un examen anterior y este examen sacó distinto a 0, comparamos
                
                $ptjeAnterior = $examenAnterior->puntajeTotal;
                $ptjeActual = $examenPostulante->puntajeTotal;
                
                $puntajeDiferencia = $ptjeActual - $ptjeAnterior; 
                
                if($ptjeAnterior == 0)
                    if($puntajeDiferencia>100) //de 0 subió a más de 100 
                        $porcentajeElevacion = 0.65;
                    else
                        $porcentajeElevacion = 0.4;
                else
                    $porcentajeElevacion = $puntajeDiferencia / $ptjeAnterior;
                
                Debug::mensajeSimple('ExamenPostulante:'.$examenPostulante->codExamenPostulante.' codActorActual='.$examenPostulante->codActor.' codActorAnt='.$examenAnterior->codActor.' nroCarnet actual:'.$examenPostulante->nroCarnet." puntajeActual=".$ptjeActual." ptjeAnt=".$ptjeAnterior.' %elevacion='.$porcentajeElevacion);
                if($porcentajeElevacion >= $tasaToleranciaSubida){
                    $postulanteElevado = new PostulantesElevados();
                    $postulanteElevado->codAnalisis = $this->codAnalisis;
                    $postulanteElevado->porcentajeElevacion = $porcentajeElevacion;
                    $postulanteElevado->puntajeDiferencia = $puntajeDiferencia;
                    $postulanteElevado->codExamenPostulanteAnterior = $examenAnterior->codExamenPostulante;
                    $postulanteElevado->codExamenPostulante = $examenPostulante->codExamenPostulante;
                    $postulanteElevado->save();
                }


            }
            
        }

        return "OK";
    }

    public function calcularTasaIrregularidad(){
        $examen = $this->getExamen();

        $nroAsistentes = $examen->asistentes;
        $porcentajeUnificadorGI = Parametros::getTasa('porcentajeUnificadorGI');
        $porcentajeUnificadorGP = Parametros::getTasa('porcentajeUnificadorGP');
        $porcentajeUnificadPE = Parametros::getTasa('porcentajeUnificadPE');
        
        $pesoTasaGI = Parametros::getTasa('pesoTasaGI');
        $pesoTasaGP = Parametros::getTasa('pesoTasaGP');
        $pesoTasaPE = Parametros::getTasa('pesoTasaPE');
        

        //                
        $cantPertenecientesEI = 0;
        $listaEI =GrupoIguales::where('codAnalisis','=',$this->codAnalisis)->get();
        foreach ($listaEI as  $grupoIgual) {
            $cantPertenecientesEI += count( explode(','  ,  $grupoIgual->vectorExamenPostulante) );  
        }
        $tasaGI = $cantPertenecientesEI/($nroAsistentes*$porcentajeUnificadorGI);

 
        $cantPertenecientesGP = 0;
        $listaGP = GrupoPatron::where('codAnalisis','=',$this->codAnalisis)->get();
        foreach ($listaGP as  $grupoPatron) {
            $cantPertenecientesGP += count( explode(','  ,  $grupoPatron->vectorExamenPostulante) );  
        }
        $tasaGP = $cantPertenecientesGP/($nroAsistentes*$porcentajeUnificadorGP);



 
        $listaPE = PostulantesElevados::where('codAnalisis','=',$this->codAnalisis)->get();
        $cantPertenecientesPE = count($listaPE);
        $tasaPE = $cantPertenecientesPE/($nroAsistentes*$porcentajeUnificadPE);
        


        $tasaIrregularidad = 
                ($pesoTasaGI * $tasaGI + 
                $pesoTasaGP * $tasaGP + 
                $pesoTasaPE *$tasaPE) /
                                        ($pesoTasaGI + $pesoTasaGP + $pesoTasaPE) ;

        return [
            'tasaGI'=> $tasaGI,
            'tasaGP'=> $tasaGP,
            'tasaPE'=> $tasaPE,
            'tasaIrregularidad' => $tasaIrregularidad
        ];


        /*  */
        
    }

     


}
