<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;

class Examen extends Model
{
    protected $table = "examen";
    protected $primaryKey = "codExamen";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'año','fechaRendicion','nroVacantes','nroPostulantes','asistentes','codModalidad','codSede','codEstado','valoracionRespuestasJSON','periodo','codArea'
    ];


    /* FORMATO DE NOMBRES DE LOS ARCHIVOS    
        Examen-000002-respuestas
        Examen-000002-preguntas
        Examen-000002-examenEscaneado
    */

    public function nombreGeneral(){
        $modalidad=Modalidad::findOrFail($this->codModalidad);
        $sede=Sede::findOrFail($this->codSede);

        return $modalidad->nombre.' '.$this->periodo.' - '.$sede->nombre;
    }
    
    public function getNombreArchivoRespuestas(){
        return "Examen-".Debug::rellernarCerosIzq($this->codExamen,6)."-respuestas.txt";
    }

    public function getNombreArchivoRespuestasPreparado(){
        return "Examen-".Debug::rellernarCerosIzq($this->codExamen,6)."-respuestasPreparado.txt";
    }

    public function getNombreArchivoPreguntas(){
        return "Examen-".Debug::rellernarCerosIzq($this->codExamen,6)."-preguntas.txt";
    }

    public function getNombreArchivoExamenEscaneado(){
        return "Examen-".Debug::rellernarCerosIzq($this->codExamen,6)."-examenEscaneado.pdf";
    }

    public function getListaPreguntas(){
        return Pregunta::where('codExamen','=',$this->codExamen)->get();
    }
    public function getTasaAusentismo(){
        
        return number_format($this->ausentes*100/$this->nroPostulantes,4);
    
    }

    public function getFechaRendicion(){

        return Fecha::formatoParaVistas($this->fechaRendicion);
    }

    public function getModalidad(){

        return Modalidad::findOrFail($this->codModalidad);
    }
    public function getArea(){

        return Area::findOrFail($this->codArea);
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

    //retorna true si ya fue cargado el archivo con los resultados 
    public function tieneResultados(){
        return $this->verificarEstadoVarios(['Aprobado','Cancelado','Analizado','Datos Insertados']);
    }

    
    public function verificarEstadoVarios($vectorNombresEstados){
        foreach ($vectorNombresEstados as $nombreEstado ) {
            if($this->verificarEstado($nombreEstado))
                return true;
        }
        return false;

    }

    public function getCantidadIngresantes(){
        $codExamen = $this->codExamen;
        $codCondicionIngresante =  CondicionPostulacion::getCondicionIngresante()->codCondicion;
        $cantidad = DB::select("
            SELECT 
                count(codExamenPostulante) as 'cantidad'
            FROM
                examen_postulante
            WHERE
                codExamen = '$codExamen' AND
                codCondicion = '$codCondicionIngresante';
        ");

        return $cantidad[0]->cantidad;
    }

    public function tieneAnalisis(){
        return count(AnalisisExamen::where('codExamen','=',$this->codExamen)->get()) > 0;
    }



    /* Inserta en la tabla historial "CarreraExamen" la combinacion de los datos actuales que están en Carrera,Examen, asi como los datos estadisticos de cada uno */
    public function generarCarrerasExamen(){


        //aqui mejorar eficiencia pq estoy recorriendo demasiados registros para solo obtener las carreras
        $postulaciones = ExamenPostulante::where('codExamen','=',$this->codExamen)->get();
        $vectorCarrerasDeEsteExamen = [];
        
        foreach ($postulaciones as $postulacion) {
            if(!in_array($postulacion->codCarrera,$vectorCarrerasDeEsteExamen))
                $vectorCarrerasDeEsteExamen[] = $postulacion->codCarrera;
        }

        $carrerasDeEsteExamen = Carrera::whereIn('codCarrera',$vectorCarrerasDeEsteExamen)->get();   
        
        /* Solo insertaremos en la tabla CarreraExamen las carreras de ese examen  */

        foreach ($carrerasDeEsteExamen as $carrera) {
            $nuevaCE = new CarreraExamen();
            $nuevaCE-> codExamen = $this->codExamen;
            $nuevaCE->codCarrera = $carrera->codCarrera;
 

            $nuevaCE->puntajeMinimoPostulante = $nuevaCE->getPuntajeMinimoPostulante();
            $nuevaCE->puntajeMaximoPostulante = $nuevaCE->getPuntajeMaximoPostulante();
            $nuevaCE->puntajeMinimoPermitido = $nuevaCE->getPuntajeMinimoPermitido();
            $nuevaCE->cantidadVacantes = $nuevaCE->getCantidadIngresantes();
            
            $nuevaCE->save();
        }


    }

    //lee el archivo de las preguntas y las inserta en la base de datos
    public function procesarArchivoPreguntas(){
             
        $archivo = fopen('examenes/'.$this->getNombreArchivoPreguntas(),'r'); //abrimos el archivo en modo lectura (reader)

        $nroPregunta = 1;
        while ($linea = fgets($archivo)) { //recorremos cada linea del archivo
            $respuesta = mb_substr($linea,1,1);
            $enunciado = mb_substr($linea,4,(mb_strlen($linea)-6)); //Son 6 porque 4 son de inicio (la respuesta) y los otros dos son de fin de linea e inicio de linea
            
            error_log('pregunta="'.$enunciado.'" respuesta="'.$respuesta.'" nro="'.$nroPregunta.'" lengt='.(mb_strlen($linea)-6) );
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
        //comentar esto
        //ExamenPostulante::where('codExamenPostulante','>','0')->delete();
        //User::where('codUsuario','>','0')->delete();
        //Actor::where('codActor','>','0')->delete();
        $respuestasCorrectas = $this->getStringRespuestas();
            
        /* 
            INGRESA
            ING. 2-
            NO INGRESA
            AUSENTE
            ANULADO
        */
        $listaCondiciones = CondicionPostulacion::All(); //para calculo de cant ausentes,ingresantes, no ingresantes y  postulantes totales 

        $conteoCondiciones = [];
        foreach ($listaCondiciones as $condicion) {
            $nombreAcortado = substr($condicion->nombre,0,7);
            $conteoCondiciones[$nombreAcortado] = 0;

        }
        /* 
        $conteoCondiciones = [
            'INGRESA'=>0,
            'ING. 2-'=>0,
            'NO INGR'=>0,
            'AUSENTE'=>0,
            'ANULADO'=>0
        ]; */
        
        

        $archivo = fopen('examenes/'.$this->getNombreArchivoRespuestasPreparado(),'r'); //abrimos el archivo en modo lectura (reader)
        
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
                    $carnet=                mb_substr($linea,6,6);
                    $apellidosYNombres=     trim(mb_substr($linea,13,43));
                    $puntajeAPT=            trim(mb_substr($linea,56,7));
                    $puntajeCON=            trim(mb_substr($linea,65,7));
                    $puntajeTotal=          trim(mb_substr($linea,74,7));
                    $puntajeMinimoPermitido=trim(mb_substr($linea,83,7));
                    $escuela=               trim(mb_substr($linea,94,24));
                    $respuestas =           mb_substr($linea,118,101); /* el primer caracter debe ser vacio para que [1] sea la primera preg */
                    $observaciones =        mb_substr($linea,220,7); //este no lo puedo agarrar completo porque varía la longitud, y si me paso agarro el salto de linea
                    $correctasEincorrectas = Examen::calcularCorrectasIncorrectas($respuestasCorrectas,$respuestas); //calculamos la cantidad de correctas e incorrectas del postulante
                    
                    $conteoCondiciones[$observaciones] ++;
                    
                    $vectorColumnas = [
                            'codExamen'=>$this->codExamen,
                            'respuestasJSON'=>$respuestas,
                            'orden'=>$orden,
                            'nroCarnet'=>$carnet,
                            'apellidosYnombres'=>$apellidosYNombres,
                            'puntajeAPT'=>$puntajeAPT,
                            'puntajeCON'=>$puntajeCON,
                            'puntajeTotal'=>$puntajeTotal,
                            'puntajeMinimoPermitido'=>$puntajeMinimoPermitido,
                            'escuela'=>$escuela,
                            'observaciones'=>$observaciones,
                            'correctasEincorrectas'=>$correctasEincorrectas
                        ];
                    
                    Debug::imprimirVector($vectorColumnas);   
                    ExamenPostulante::registrar($vectorColumnas,$listaCondiciones);

                    //Debug::imprimir($linea);

                    $cant++;
                }
            }

        }
        Debug::mensajeSimple('Conteo general: ' . json_encode($conteoCondiciones));
        Debug::mensajeSimple('la cantidad de postulantes es:'.$cant);

        $this->nroVacantes = $conteoCondiciones['INGRESA'];
        $this->ausentes = $conteoCondiciones['AUSENTE'];
        $this->asistentes = $conteoCondiciones['INGRESA'] + $conteoCondiciones['NO INGR'] + $conteoCondiciones['ING. 2-'];
        $this->nroPostulantes = $cant;
        $this->save();
    }
 
    //obtiene un string de tipo "_ABBBBBBBBABBBBBBBBBABBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBD
    
    public function getStringRespuestas(){
        
        
        
        /* PHP */
        
        $listaPreguntas = Pregunta::where('codExamen','=',$this->codExamen)->get();
        $cadena = "";
        foreach ($listaPreguntas as $pregunta) {
            $cadena = $cadena.$pregunta->respuestaCorrecta;
        }
        return "_".$cadena;

        
        /* MYSQL MEDIANTE EJECUCIÓN DE LA FUNCION obtenerRespuestas */
        $codExamen = $this->codExamen;
        $sentenciaSQL = "select obtenerRespuestas($codExamen) as 'Resultado'";

        $jsonResultado = json_encode(DB::select($sentenciaSQL)[0]);
        
        $resultado = json_decode($jsonResultado,true)['Resultado'];
        return $resultado;

    }


    /* 
    Le entra:
        String de respuestas correctas del examen
        String de respuestas del postulante

    Le sale:
        vector Cantidad de correctas e incorrectas 
    
    */
    public static function calcularCorrectasIncorrectas($respuestasCorrectas,$respuestas){
        
        error_log($respuestas);
        error_log($respuestasCorrectas);
        $respuestasCorrectas = str_split($respuestasCorrectas);
        $respuestas = str_split($respuestas);
        
        $correctas = 0;
        $incorrectas = 0;
        for ($i=1; $i <= 100 ; $i++) { 
            if($respuestas[$i]!='X'){ //si se marcó
                if($respuestas[$i]== $respuestasCorrectas[$i]) //si marcó bien
                    $correctas++;
                else
                    $incorrectas++;
            }
        }

        return [
            'correctas'=>$correctas,
            'incorrectas'=>$incorrectas
        ];

    }


    /* Genera el reporte de irregularidad (tablas grupos iguales,patron y post elevados). Tambien calcula la tasa */
    public function generarReporteIrregularidad(){
        $analisis = new AnalisisExamen();
        $analisis->codExamen = $this->codExamen;
        
        $analisis->save();
        
        $analisis->generarGruposIguales();
        $analisis->generarPreGruposPatron();
        $analisis->generarPostGruposPatron();
        
        $analisis->generarPostulantesElevados();

   
        $tasas = $analisis->calcularTasaIrregularidad();
        $analisis->tasaGI = $tasas['tasaGI'];
        $analisis->tasaGP = $tasas['tasaGP'];
        $analisis->tasaPE = $tasas['tasaPE'];
        $analisis->tasaIrregularidad = $tasas['tasaIrregularidad'];
        $analisis->save();

        return "si llegamos";

    }





    /* PREPARAR 
    
    ESTO ES PARA GENERAR LA CADENA DE RESPUESTAS DE CADA POSTULANTE,  */
    public function generarRespuestasPostulantes(){
        $valorCorrectaAPT  =$this->valoracionPositivaAPT;
        $valorCorrectaCON  =$this->valoracionPositivaCON;
        $valorIncorrectaAPT=$this->valoracionNegativaAPT;
        $valorIncorrectaCON=$this->valoracionNegativaCON;
        $respuestasCorrectas = $this->getStringRespuestas(); //   _ABCCDDABBEEDBA...

        $tolerancia = 0.001;

        //comentar esto
        //ExamenPostulante::where('codExamenPostulante','>','0')->delete();
        $html = "";
        $archivo = fopen('examenes/'.$this->getNombreArchivoRespuestas(),'r'); //abrimos el archivo en modo lectura (reader)
        
        $vectorPostulantes = [];
        $stringNuevoArchivo = "";

        $cant = 0;
        while ($linea = fgets($archivo)) { //recorremos cada linea del archivo
            if(mb_strlen($linea)>5) //si no es una linea de datos
            {   
                $vector = mb_str_split($linea);
                $segundoCaracter = $vector[1];
                if(is_numeric($segundoCaracter))
                {
                    //AQUI YA SE PUEDE DECIR QUE LA LINEA DE DATOS ES DE POSTULANTE
                    //                                      posicion inicial , longitud
                    $orden =                mb_substr($linea,1,4);
                    $puntajeAPT=            trim(mb_substr($linea,56,7));
                    $puntajeCON=            trim(mb_substr($linea,65,7));

                    
                    $vectorAPT = Examen::encontrarCombinatoria($puntajeAPT,$valorCorrectaAPT,$valorIncorrectaAPT,$tolerancia,30);
                    $vectorCON = Examen::encontrarCombinatoria($puntajeCON,$valorCorrectaCON,$valorIncorrectaCON,$tolerancia,70);
                    
                    Debug::imprimir("ORDEN=".$orden." PuntajeAPT=".$puntajeAPT." PuntajeCON=".$puntajeCON.json_encode($vectorAPT)." ".json_encode($vectorCON));   



                    $respuestaPostulante = 
                        Examen::respuestasAleatoriasDePostulante($respuestasCorrectas,$vectorAPT,1,30)
                        .
                        Examen::respuestasAleatoriasDePostulante($respuestasCorrectas,$vectorCON,31,100);

                    //añadimos en la posicion 119 la cadena de respuestas
                    $nuevaLinea = Debug::stringInsert($linea,$respuestaPostulante,119); 
                    

                    $stringNuevoArchivo .= $nuevaLinea;   

                    //$html = $html."APTITUD:     ".$combinacionAPT."          ///////      CONOCIMIENTOS:".$combinacionCON." <br>";
                    $html = $html."orden=".$orden." APTITUD:     ".json_encode($vectorAPT)."          ///////      CONOCIMIENTOS:".json_encode($vectorCON)." ¡¡¡¡ Rpta:".$respuestaPostulante ."<br>";
                    $cant++;
                }
            }

        }
        
        Debug::mensajeSimple('la cantidad de postulantes es:'.$cant. " las respuesta correctas son:".$respuestasCorrectas);

        //w+ Abre el archivo para escritura y lectura. La lectura o escritura comienza al inicio del archivo, y elimina el contenido previo. Si el archivo no existe, intenta crearlo.
        $nuevoArchivo = fopen('examenes/'.$this->getNombreArchivoRespuestasPreparado(),'w+');
        fwrite($nuevoArchivo,$stringNuevoArchivo);

        return $html ;

    }
 


    //se le pasa un puntaje, y los valores de pregunta correcta e incorrecta
    // retorna la cantidad de preguntas correcta e incorrecta que lo generaron
    //si no encuentra, retorna No encontrado
    public static function encontrarCombinatoria($puntaje,$valorCorrecta,$valorIncorrecta,$tolerancia,$cantidadPreguntas){
        $band = true;
        Debug::mensajeSimple('Encontrando combinatoria para '.$puntaje);
        //para cada valor, le buscamos combinaciones de valores que generen ese numero 
        for ($i=0; $i < $cantidadPreguntas && $band; $i++) {  
            for ($j=0; $j < $cantidadPreguntas && $band; $j++) { 
                 
                $valorAproximado = ($i*$valorCorrecta + $j*$valorIncorrecta);
                $diferencia = $puntaje - $valorAproximado;
                
                if( $diferencia < $tolerancia  && $diferencia > -$tolerancia   )
                {
                    if($diferencia<0.000001) $diferencia=0; // ignorar diferencias de estilo -7.105427357601E-15
                    $vector = [
                        'buenas'=>Debug::rellernarCerosIzq($i,2)
                        ,'malas'=>Debug::rellernarCerosIzq($j,2)
                    ];
                    $band = false;
                }
            } 

        }

        if($band){
            return ['no encontrado'];
        }

        return $vector;
    }


    /*

    Le entra:
        String de respuestas correctas del examen _ABBBBBBBBABBBBBBBBBABBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBD
        cantidad de preguntas buenas y malas que debe tener en APT
        cantidad de preguntas buenas y malas que debe tener en CON
    
    Le sale:
        String de respuestas del estudiante que tenga la cantidad de preguntas buenas y malas indicadas
        ESTO SOLO ES PARA UN SEGMENTO DEL RESP ALEATORIAS FINAL, DEBE CORRERSE UNA VEZ PARA APT y otra vez para CON
    */
    public static function respuestasAleatoriasDePostulante($respuestasCorrectas,$vectorBuenasMalas,$preguntaInferior,$preguntaSuperior){
        $respuestas="";
        
       
        //escogemos las posiciones en las que el postulante acertará la pregunta
        $posicionesBuenas =[];
        for ($i=0; $i < $vectorBuenasMalas['buenas'] ; $i++) { //hacemos esto la "cantidad de preguntas buenas" veces
            $posicionEscogida = rand($preguntaInferior,$preguntaSuperior);
            if( in_array($posicionEscogida,$posicionesBuenas)) //si la posicion ya salió escogida, volvemos a generar un numero aleatorio
                $i--;
            else//si no, lo agregamos y continuamos
                array_push($posicionesBuenas,$posicionEscogida);
        }

        //escogemos las posiciones en las que el postulante ERRARÁ la pregunta
        $posicionesMalas =[];
        for ($i=0; $i < $vectorBuenasMalas['malas'] ; $i++) { //hacemos esto la "cantidad de preguntas malas" veces
            $posicionEscogida = rand($preguntaInferior,$preguntaSuperior);
            if( in_array($posicionEscogida,$posicionesBuenas) || in_array($posicionEscogida,$posicionesMalas)) //si la posicion ya salió escogida, volvemos a generar un numero aleatorio
                $i--;
            else//si no, lo agregamos y continuamos
                array_push($posicionesMalas,$posicionEscogida);
        }


        $vectorRespuestasCorrectas = str_split($respuestasCorrectas);
        //recorremos el vector de respuestas correctas del examen
        // donde deba haber un acierto, copiamos
        //donde deba haber un error, generamos una resp incorrecta aleatoriamente
        for ($i=$preguntaInferior; $i <= $preguntaSuperior ; $i++) { 
            $caracterAñadido="X"; //por defecto la pregunta estará vacía (X)
            
            if(in_array($i,$posicionesBuenas))//Si en esta pos debe haber un acierto
                $caracterAñadido = $vectorRespuestasCorrectas[$i];
            
            if(in_array($i,$posicionesMalas))//Si en esta pos debe haber un error
                $caracterAñadido = Examen::generarRespuestaIncorrecta($vectorRespuestasCorrectas[$i]);

            $respuestas= $respuestas.$caracterAñadido;
        }

        Debug::mensajeSimple('posBuenas='.json_encode($posicionesBuenas)."  posMalas".json_encode($posicionesMalas));
        
        return $respuestas;
    }


    //genera una respuesta incorrecta aleatoria, en base a una correcta
    public static function generarRespuestaIncorrecta($respuestaCorrecta){
        $respuestasPosibles = 
            [// 
                "A",
                'B',
                'C',
                'D',
                'E'
            ];
        
        $pos = rand(0,4);
        while($respuestasPosibles[$pos] == $respuestaCorrecta ){
            
            $pos = rand(0,4);

        }
        return $respuestasPosibles[$pos];

    }



    /* 
    Le entra:
        un vector de posiciones y respuestas
        [
            '2' =>'A',
            '6' => 'B',
            '16'=> 'D'
        ]
        un objeto examen
    Sale:
        un vector de tipo 
            [
                'nroCorrectas' => 15,
                'nroIncorrectas'=> 5,
                'puntajeAdquirido'=> 125.12

            ]
    */
    public static function compararVectorEspecialPosiciones($vectorPosicionesRespuestas,$examen){
        $preguntasCorrectas = $examen->getStringRespuestas();
        $posCON = $examen->valoracionPositivaCON;
        $posAPT = $examen->valoracionPositivaAPT;

        $negCON = $examen->valoracionNegativaCON;
        $negAPT = $examen->valoracionNegativaAPT;

        $nroCorrectasCON = 0;
        $nroIncorrectasCON = 0;
        
        $nroCorrectasAPT = 0;
        $nroIncorrectasAPT = 0;
        
        $puntoDivisionAPTyCON = 30; //esto deberia salir de $examen

        foreach ($vectorPosicionesRespuestas as $key => $value) {
            if($key < $puntoDivisionAPTyCON){ //apt
                if($vectorPosicionesRespuestas[$key] == $preguntasCorrectas[$key] ) //
                {
                    $nroCorrectasAPT++;
                }else{
                    $nroIncorrectasAPT++;
                }

            }else{//CON
                if($vectorPosicionesRespuestas[$key] == $preguntasCorrectas[$key] ) //
                {
                    $nroCorrectasCON++;
                }else{
                    $nroIncorrectasCON++;
                }

            }
          
        }

        $puntajeAdquirido = 
            $nroCorrectasCON*$posCON + $nroIncorrectasCON*$negCON + 
            $nroCorrectasAPT*$posAPT + $nroIncorrectasAPT*$negAPT;

        return [
            'nroCorrectas'=> $nroCorrectasAPT + $nroCorrectasCON,
            'nroIncorrectas'=> $nroIncorrectasAPT + $nroIncorrectasCON,
            'puntajeAdquirido'=> $puntajeAdquirido
        ];
        

    }


    public function getAnalisis(){
        return AnalisisExamen::where('codExamen','=',$this->codExamen)->get()[0];
    }
    //retorna si el Cons univ  puede decidir sobre el examen (si tiene observaciones planteadas, no puede) 
    public function sePuedeDecidir(){
        $codAnalisis =  $this->getAnalisis()->codAnalisis;
        $listaObservaciones = Observacion::where('codAnalisis','=',$codAnalisis)
            ->where('codEstado','=','1') //1= cod estado planteada
            ->get();
        return count($listaObservaciones)==0;

    }
}
