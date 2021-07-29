<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamenPostulante extends Model
{
    protected $table = "examen_postulante";
    protected $primaryKey = "codExamenPostulante";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'codExamen', 'respuestasJSON','puntajeAP','puntajeCON','puntajeTotal','codActor','codCarrera','orden','codCondicion'
    ];
}
