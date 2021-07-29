<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = "area";
    protected $primaryKey = "codArea";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'descripcion'
    ];
}
