<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = "pregunta";
    protected $primaryKey = "codPregunta";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'nroPregunta','enunciado','codExamen','respuestaCorrecta'
    ];

}
