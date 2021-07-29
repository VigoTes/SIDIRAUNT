<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoActor extends Model
{
    protected $table = "tipo_actor";
    protected $primaryKey = "codTipoActor";
    public $timestamps = false; 


    protected $fillable = [
       'nombre'
    ];
}
