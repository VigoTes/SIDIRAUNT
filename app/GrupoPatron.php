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

   


    public function identificador(){
        $number = $this->codGrupoPatron;
        $length = 4;
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

}
