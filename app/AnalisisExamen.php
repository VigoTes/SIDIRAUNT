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


        //return $listaExamenes[1];
         
    }
    
    /* 
    Le entra:
        Parametros del obj actual

    Tablas alteradas:
        GrupoPatron
    
    */
    public function generarPreGruposPatron(){

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


                    
                    //en este vector las posiciones son las keys y las respuestas con los value
                    $vectorRespuestasIguales = ExamenPostulante::compararRespuestas($listaExamenes[$i]->respuestasJSON,$listaExamenes[$j]->respuestasJSON);
                    $cantRespuestasMarcadas = $listaExamenes[$i]->getCantidadRespuestasMarcadas();
                    Debug::mensajeSimple('generarGruposPatron iterando'.$i."/".$j."// ".$listaExamenes[$i]->nroCarnet."  cantidadLimite=".$cantRespuestasMarcadas*$tasa."  cantidadRespIguales=".count($vectorRespuestasIguales)); 
                    
                    if($cantRespuestasMarcadas*$tasa < count($vectorRespuestasIguales) && count($vectorRespuestasIguales) > $cantidadMinimaDePreguntasParaPatron
                    ) 
                    {
                        Debug::mensajeSimple('---------- IRREGULARIDAD DETECTADA nroCarnet:'.$listaExamenes[$i]->nroCarnet);
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
                                
                            }
                        }


                    
                    }//si 
                    else
                    {
                        Debug::mensajeSimple('cortamos el j='.$j);
                        
                    }

                }

                if($grupo!=""){ //si se creó algun grupo
                    $grupo->save();
                    Debug::mensajeSimple('GUARDANDO GRUPO'.json_encode($grupo));
                }

            }else{
                Debug::mensajeSimple($i.' es 0,no lo contamos. NroCarnet='.$listaExamenes[$i]->nroCarnet);

            }

        }


        return $listaExamenes[1];

    }
    


    /* 
    //en base a los grupos patron encontrados en la etapa PRE, este algoritmo 
        1. Encuentra patrones coincidentes dentro de cada grupoPatron
        2. Elimina los grupoPatron generados en Pre
        3. Inserta los nuevo grupo patron que son más pequeños pero tienen más ocurrencias
    */
    public function generarPostGruposPatron(){
        $listaGrupos  = GrupoPatron::where('codAnalisis','=',$this->codAnalisis)->get();



        //primero generamos el vectorOcurrencias que tendra 
        //      de Keys todas las respuestas de grupoPatron, 
        //         y de valor la cantidad total de ocurrencias en TODO EL EXAMEN DE ADMISION
        $vectorOcurrencias = [];
        /* Aqui se almacenaran la cantidad de ocurrencias de cada respuesta
            {
                "20:A":0,
                "5:B":0,
                "6:B":0
            }
        */

        //inicializamos el vector con valores 0
        foreach ($listaGrupos as $grupoPatron) {
            $respCoincidentes = json_decode($grupoPatron->respuestasCoincidentesJSON,true);
            foreach ($respCoincidentes as $key => $value) {
                $respuesta = $key.":".$value;
                if (!array_key_exists($respuesta,$vectorOcurrencias)){ //verificamos si esa respuesta ya está en el array
                    $vectorOcurrencias[$respuesta] = 0;
                }
            }

        }

        //buscamos en todo el examen contando las ocurrencias de cada respuesta

        
        $examenesPostulanteConPatron = "";
        //recorremos todos los examenPostulante para contar las ocurrencias del patron
        $listaExamenes = ExamenPostulante::where('codExamen','=',$this->codExamen)->get();
        foreach ($listaExamenes as $examenPostulante) {
            //Debug::mensajeSimple('analizando nroCarnet='.$examenPostulante->nroCarnet);
            $respuestaPostulante = str_split($examenPostulante->respuestasJSON);
            foreach ($vectorOcurrencias as $rpta => $cantidadOcurrencias) { //iteramos cada elemento de vectorOcurrencias

                //obtenemos la el nroDePregunta  y la respuesta
                $nuevoVector = explode(':',$rpta); // aqui transformamos la cadena "20:A" en un vector {0=>'20',1=>'A'}
                $nroPregunta = $nuevoVector[0];
                $respuestaPatron = $nuevoVector[1];                
                
                //evaluamos si el postulante tiene esa pregunta marcada así
                if($respuestaPostulante[$nroPregunta] == $respuestaPatron)
                {
                    $vectorOcurrencias[$rpta]++;
                }

            }

        }



        arsort($vectorOcurrencias);
        //return $vectorOcurrencias;
        //Hasta aqui ya tenemos en vectorOcurrencias la lista de respuestas más comunes

        $vectorMaximo = [];
        $anterior = 0;
        //obtenemos la cant de ocurrencias maxima
        foreach ($vectorOcurrencias as $rpta => $cantidadOcurrencias) {
            $valorMaximo = $cantidadOcurrencias;
            break;
        }

        //obtenemos un vector en el que todas sus respuestas tengan cant de ocurrencias maxima hasta -10 ocurrencias
        foreach ($vectorOcurrencias as $rpta => $cantidadOcurrencias) {
            if($cantidadOcurrencias>= $valorMaximo - 10){
                $nuevoVector = explode(':',$rpta); // aqui transformamos la cadena "20:A" en un vector {0=>'20',1=>'A'}
                $vectorPatron[$nuevoVector[0]]=$nuevoVector[1]; //asignamos $vectorPatron[20] = "A"
            }
        }
        //return $vectorPatron;

        //ya tengo en vector patron algo de formato {"20":"A","5":"B","6":"B","4":"B","3":"B","18":"B"}

        
        $examenesPostulanteConPatron = "";
        //recorremos todos los examenPostulante para contar las ocurrencias del patron
        $listaExamenes = ExamenPostulante::where('codExamen','=',$this->codExamen)->get();
        foreach ($listaExamenes as $examenPostulante) {
            Debug::mensajeSimple('analizando nroCarnet='.$examenPostulante->nroCarnet);
            if($examenPostulante->tienePatron($vectorPatron))
                $examenesPostulanteConPatron= $examenesPostulanteConPatron.",".$examenPostulante->codExamenPostulante;
        }


        return $examenesPostulanteConPatron;


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
            if($examenAnterior!=""){ //si hubo un examen anterior, comparamos
                
                $ptjeAnterior = $examenAnterior->puntajeTotal;
                $ptjeActual = $examenPostulante->puntajeTotal;

                $puntajeDiferencia = $ptjeActual - $ptjeAnterior; 
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
                $pesoTasaGI * $tasaGI + 
                $pesoTasaGP*$tasaGP + 
                $pesoTasaPE *$tasaPE;

        return [
            'tasaGI'=> $tasaGI,
            'tasaGP'=> $tasaGP,
            'tasaPE'=> $tasaPE,
            'tasaIrregularidad' => $tasaIrregularidad
        ];
        
    }

     


}
