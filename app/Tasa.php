<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasa extends Model
{
    protected $table = "tasa";
    protected $primaryKey = "codTasa";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'codTasa'
    ];


    

}
