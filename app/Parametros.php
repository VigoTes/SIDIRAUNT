<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parametros extends Model
{
    protected $table = "parametros";
    protected $primaryKey = "codParametro";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'campo', 'valor'
    ];
}
