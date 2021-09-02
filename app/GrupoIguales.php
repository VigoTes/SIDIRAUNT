<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoIguales extends ElementoAnalisis
{
    protected $table = "grupo_iguales";
    protected $primaryKey = "codGrupo";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'codAnalisis','puntajeAP','puntajeCON','puntajeTotal','correctas','incorrectas','respuestasJSON','vectorExamenPostulante'
    ];
    
     

    public function identificador(){
        //return printf('%04d', $this->codGrupo).'';
        $number = $this->codGrupo;
        $length = 4;
        return substr(str_repeat(0, $length).$number, - $length);
    }
    public function cantidadPostulantes(){
        $arr = explode(',', $this->vectorExamenPostulante);
        return count($arr);
    }


    public function añadirExamenPostulante($codExamenPostulante){
        $this->vectorExamenPostulante = $this->vectorExamenPostulante.",".$codExamenPostulante;
        $this->save();
    }



}
