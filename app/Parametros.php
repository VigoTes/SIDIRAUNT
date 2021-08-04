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

    public static function getTasa($nombre){
        $obj = Parametros::where('campo','=',$nombre)->get()[0];
        return $obj->valor;
    }
}
