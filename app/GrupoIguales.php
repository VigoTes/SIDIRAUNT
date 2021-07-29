<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoIguales extends Model
{
    protected $table = "grupo_iguales";
    protected $primaryKey = "codGrupo";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'codAnalisis','puntajeAP','puntajeCON','puntajeTotal','correctas','incorrectas','respuestasJSON','vectorExamenPostulable'
    ];
}
