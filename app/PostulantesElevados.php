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

    public function examenAnterior(){
        return ExamenPostulante::findOrFail($this->codExamenPostulanteAnterior);
    }
    public function examenActual(){
        return ExamenPostulante::findOrFail($this->codExamenPostulante);
    }
    public function postulante(){
        $examen=$this->examenActual();
        return Actor::findOrFail($examen->codActor);
    }



}
