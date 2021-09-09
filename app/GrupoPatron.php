<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoPatron extends ElementoAnalisis
{
    protected $table = "grupo_patron";
    protected $primaryKey = "codGrupoPatron";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'codAnalisis','nroIncorrectas','nroCorrectas','puntajeAdquirido','respuestasCoincidentesJSON','vectorExamenPostulante'
    ];

    public function getCantidadPreguntas(){
        return $this->nroCorrectas + $this->nroIncorrectas;

    }
    public function getPromedioPostulantes(){
        $lista = $this->getListaPostulantes();
        $sum = 0;
        foreach ($lista as $post) {
           
            $sum+=$post->puntajeTotal;
        }
        return $sum/count($lista);
    }

    public function getListaPostulantes(){
        $array = explode(',',$this->vectorExamenPostulante);
        return ExamenPostulante::whereIn('codExamenPostulante',$array)->get();

    }


    public function identificador(){
        $number = $this->codGrupoPatron;
        $length = 8;
        return substr(str_repeat(0, $length).$number, - $length);
    }
    public function cantidadPostulantes(){
        $arr = explode(',', $this->vectorExamenPostulante);
        return count($arr);
    }
    public function respuestasResumen(){
        $resumen="";
        $respuestasProbando=json_decode($this->respuestasCoincidentesJSON,true);
        for ($i=1; $i <= 100; $i++) { 
            if(isset($respuestasProbando[$i])){
                $resumen=$resumen.', '.$i.'.'.$respuestasProbando[$i];
            }
            
        }

        $resumen = trim($resumen,',');
        return $resumen;
        return substr($resumen, 1,120)." ...";
    }


    public function añadirExamenPostulante($codExamenPostulante){
        $this->vectorExamenPostulante = $this->vectorExamenPostulante.",".$codExamenPostulante;
        
    }

    public static function buscar($vectorRespuestasIguales,$codAnalisis){
        return GrupoPatron::where('codAnalisis','=',$codAnalisis)
            ->where('respuestasCoincidentesJSON','=',$vectorRespuestasIguales)
            ->get();


    }




    /*
        Compara los json de 2 grupo patron
        y retorna un vector con las respuestas coincidentes
    */
    public static function compararCoincidencias($json1,$json2){
         
        $obj1 = json_decode($json1,true);
        $obj2 = json_decode($json2,true);
 
        $preguntasCoincidentes = [];
        foreach ($obj1 as $posicion => $pregunta){
            if(array_key_exists($posicion,$obj2))//verificamos si existe esa key    
                if($obj2[$posicion]==$obj1[$posicion]) //verificamos si en esa key está el mismo valor que en el json1
                    $preguntasCoincidentes[$posicion] = $pregunta;
        }
        return $preguntasCoincidentes;

    }
}
