<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElementoAnalisis extends Model
{
    //ESTA CLASE NO ES UN MODELO, ES LA CLASE MADRE DE GrupoPatron, GrupoIguales, PostlantesElevados. Aqui pondré funciones que las 3 deben tener

    public function getObservacion(){
        return Observacion::findOrFail($this->codObservacion);
    }
    //si tiene alguna observacion, se la pinta de naranja
    public function getColorFila(){
        if(!$this->estaObservado())
            return "";
        

        $obs = Observacion::findOrFail($this->codObservacion);
        switch($obs->codEstado){
            case 1: //observacion planteada
                return "yellow";
                break;
            case 2: //dejado pasar
                return "rgb(86, 206, 86)";
                break;

            case 3: //anulados
                return "rgb(255, 171, 75)";
                break;

        }

    }
    
    public function estaObservado(){
        if(is_null($this->codObservacion ))
            return false;
        return true;

    }

}
