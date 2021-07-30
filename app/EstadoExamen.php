<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoExamen extends Model
{
    protected $table = "estado_examen";
    protected $primaryKey = "codEstado";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'descripcion'
    ];
}
