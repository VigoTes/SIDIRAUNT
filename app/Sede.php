<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $table = "sede";
    protected $primaryKey = "codSede";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'nombre'
    ];
}
