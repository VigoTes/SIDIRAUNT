<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamenPostulante extends Model
{
    protected $table = "examen_postulante";
    protected $primaryKey = "codExamenPostulante";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'codExamen', 'respuestasJSON','puntajeAP','puntajeCON','puntajeTotal','codActor','codCarrera','orden','codCondicion'
    ];

    public function getCarrera(){
        return Carrera::findOrFail($this->codCarrera);
    }

    /*
    le ingresa un vector con la linea de resultados, 
        si el postulante no existe, le crea un perfil y le añade este examen a examenPostulante
        si ya existe, le añade este examen a ExamenPostulante 
    */
    public static function registrar($array){
        
        $listaPostulantes = Actor::where('apellidosYnombres','=',$array['apellidosYnombres'])->get();
        if(count($listaPostulantes)==0){ //No existe el postulante en la BD, le creamos un perfil
            
            $usuario = new User();
            $usuario->usuario =  mb_substr($array['apellidosYnombres'],0,7).rand(1000,9999);
            $usuario->contraseña = "123";
            $usuario->save();

            $postulante = new Actor();
            $postulante->apellidosYnombres = $array['apellidosYnombres'];
            $postulante->codTipoActor = 1;//postulante
            $postulante->codUsuario = User::All()->last()->codUsuario;
            $postulante->save();
            Debug::mensajeSimple('NUEVO');

        }else{ //ya existe el postulante en la BD
            $postulante = $listaPostulantes[0];
            Debug::mensajeSimple('YA EXISTE');

        }

        $carrera = Carrera::where('abreviacionMayus','=',$array['escuela'])->get()[0];

        Debug::mensajeSimple('condicionPostulacion="'.$array['observaciones'].'"');
        $condicion = CondicionPostulacion::where('nombre','like',$array['observaciones']."%")->get()[0]; //AQUI ME QUEDE
        

        $examenPostulante = new ExamenPostulante();
        $examenPostulante->codExamen = $array['codExamen'];
        $examenPostulante->respuestasJSON = $array['respuestasJSON'];
        $examenPostulante->puntajeAPT = $array['puntajeAPT'];
        $examenPostulante->puntajeCON = $array['puntajeCON'];
        $examenPostulante->puntajeTotal = $array['puntajeTotal'];
        $examenPostulante->codActor = Actor::All()->last()->codActor;
        $examenPostulante->codCarrera = $carrera->codCarrera;
        $examenPostulante->orden = $array['orden'];
        $examenPostulante->nroCarnet = $array['nroCarnet'];
        
        $examenPostulante->codCondicion = $condicion->codCondicion;

        $examenPostulante->save();

    }


}
