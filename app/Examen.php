<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    protected $table = "examen";
    protected $primaryKey = "codExamen";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'año','fechaRendicion','nroVacantes','nroPostulantes','asistentes','codModalidad','codSede','codEstado','valoracionRespuestasJSON'
    ];
}
