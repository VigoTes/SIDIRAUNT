<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoPatron extends Model
{
    protected $table = "grupo_patron";
    protected $primaryKey = "codGrupoPatron";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'codAnalisis','nroIncorrectas','nroCorrectas','puntajeAdquirido','respuestasCoincidentesJSON','vectorExamenPostulante'
    ];


    public function identificador(){
        return printf('%04d', $this->codGrupoPatron).'';
    }
    public function cantidadPostulantes(){
        $arr = explode(',', $this->vectorExamenPostulante);
        return count($arr);
    }
    public function respuestasResumen(){
        return substr($this->respuestasCoincidentesJSON, 0, 10);
    }
}
