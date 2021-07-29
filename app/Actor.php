<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $table = "actor";
    protected $primaryKey = "codActor";
    public $timestamps = false; 


    protected $fillable = [
       'apellidos', 'nombres', 'codUsuario', 'codTipoActor', 'dni'
    ];

}
