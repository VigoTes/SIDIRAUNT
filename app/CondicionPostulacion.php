<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CondicionPostulacion extends Model
{
    protected $table = "condicion_postulacion";
    protected $primaryKey = "codCondicion";
    public $timestamps = false; 


    protected $fillable = [
       'nombre'
    ];

    public static function getCondicionIngresante(){
        return CondicionPostulacion::where('nombre','=',"INGRESA")->get()->first();

    }

}
