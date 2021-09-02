<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    //
    protected $table = "observacion";
    protected $primaryKey = "codObservacion";
    public $timestamps = false; 


    protected $fillable = [
       ''
    ];


    public function getTipoObservacion(){
        return TipoObservacion::findOrFail($this->codTipoObservacion);
    }
    public function getAnalisis(){
        return AnalisisExamen::findOrFail($this->codAnalisis);
    }
    public function getEstado(){
        return EstadoObservacion::findOrFail($this->codEstado);
    }



    public function estaPlanteada(){
        return $this->codEstado == 1;

    }

}
