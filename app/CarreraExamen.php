<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarreraExamen extends Model
{
    protected $table = "carrera_examen";
    protected $primaryKey = "codCarreraExamen";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'cantidadVacantes','codExamen','codCarrera','puntajeMinimoPostulante','puntajeMaximoPostulante','puntajeMinimoPermitido'
    ];
}
