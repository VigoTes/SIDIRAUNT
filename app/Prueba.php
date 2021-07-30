<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{
    protected $table = "prueba";
    protected $primaryKey = "codPrueba";
    public $timestamps = false;  //para que no trabaje con los campos fecha 

    protected $fillable = [
       'codPrueba', 'cadena','puntaje'
    ];
}
