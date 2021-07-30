<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table = "carrera";
    protected $primaryKey = "codCarrera";
    public $timestamps = false; 


    protected $fillable = [
       'nombre', 'codAreaActual', 'codFacultad'
    ];
}
