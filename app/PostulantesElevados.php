<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostulantesElevados extends Model
{
    protected $table = "postulantes_elevados";
    protected $primaryKey = "codPostulanteElevado";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'porcentajeElevacion', 'puntajeDiferencia','codExamenPostulanteAnterior','codAnalisis','codExamenPostulante'
    ];
}
