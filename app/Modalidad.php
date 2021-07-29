<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modalidad extends Model
{
    protected $table = "modalidad";
    protected $primaryKey = "codModalidad";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'nombre'
    ];
}
