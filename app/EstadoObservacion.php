<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoObservacion extends Model
{
    protected $table = "estado_observacion";
    protected $primaryKey = "codEstado";
    public $timestamps = false; 

    

}
