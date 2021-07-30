<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalisisExamen extends Model
{
    protected $table = "analisis_examen";
    protected $primaryKey = "codAnalisis";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'tasaIrregularidad','codExamen'
    ];
}
