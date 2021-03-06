<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Throwable;

class Actor extends Model
{

    protected $table = "actor";
    protected $primaryKey = "codActor";
    public $timestamps = false; 


    protected $fillable = [
       'apellidosYnombres', 'codUsuario', 'codTipoActor'
    ];
    /*
    public function getApellidosYnombresFormateado(){
        return $this->apellidosYnombres;
    }*/
    
    public function puedeVerPerfilesAjenos(){
        return $this->esDirectorAdmision() || $this->esConsejoUniversitario();
    }

    public function getApellidoFormateado(){
        $palabras=explode(" ", ucwords(strtolower($this->apellidosYnombres)));

        return $palabras[0].' '.$palabras[1];
    }
    public function getNombreFormateado(){
        $palabras=explode(" ", ucwords(strtolower($this->apellidosYnombres)));
        $nombres='';
        for ($i=2; $i < count($palabras); $i++) { 
            $nombres=$nombres.$palabras[$i].' ';
        }

        return $nombres;
    }

    public function getTipoActor(){
        return TipoActor::findOrFail($this->codTipoActor);
    }

    public function verificarActor($nombreActor){


        return $this->getTipoActor()->nombre == $nombreActor;

        /* 
       
     */

    }
    public function getExamenPostulante($codExamen){
        return ExamenPostulante::where('codExamen','=',$codExamen)->where('codActor','=',$this->codActor)->get()[0];
    }


    public static function esDirectorAdmision(){
        if(is_null(Auth::id())){
            return false;
        }else{
            $actor=Actor::getActorLogeado();
            if($actor->codTipoActor==3){
                return true;
            }else{
                return false;
            }
        }

    } 

    public static function esConsejoUniversitario(){
        if(is_null(Auth::id())){
            return false;
        }else{
            $actor=Actor::getActorLogeado();
            if($actor->codTipoActor==2){
                return true;
            }else{
                return false;
            }
        }
        
        
    }

    

    public static function getActorLogeado(){
        $codUsuario = Auth::id();         
        
        $actores = Actor::where('codUsuario','=',$codUsuario)->get();
        
        if(is_null(Auth::id())){
            return false;
        }


        if(count($actores)<0) //si no encontr?? el empleado de este user 
        {

            Debug::mensajeError('Empleado','    getEmpleadoLogeado() ');
           
            return false;
        }
        
        return $actores[0]; 
    }


    public static function hayActorLogeado(){
        $codUsuario = Auth::id();         
        $actores = Actor::where('codUsuario','=',$codUsuario)->get();

        if(is_null(Auth::id())){
            return false;
        }


        if(count($actores)<0) //si no encontr?? el empleado de este user 
        {

            Debug::mensajeError('Empleado','    getEmpleadoLogeado() ');
           
            return false;
        }
        return true; 
    }
        

    
    public function getUsuario(){
        try{
            $usuario = User::findOrFail($this->codUsuario);
        }catch(Throwable $th){
            Debug::mensajeError('MODELO EMPLEADO', $th);
            return "usuario no encontrado.";
        }
        return $usuario;
        
    }
 

#region FUNCIONES PARA POSTULANTE
    public function getPostulaciones(){
        return  ExamenPostulante::where('codActor','=',$this->codActor)
        ->orderBy('codExamenPostulante','DESC')    
        ->get();


    }

    public function getPostulacionesAsc(){
        return  ExamenPostulante::where('codActor','=',$this->codActor)
        ->orderBy('codExamenPostulante')    
        ->get();


    }


    public function getUltimoExamen(){
        $listaExPost = ExamenPostulante::where('codActor','=',$this->codActor)
        ->orderBy('codExamenPostulante','DESC')    
        ->get();

        $examen = Examen::findOrFail($listaExPost[0]->codExamen);

        return $examen;
    }

    public function getUltimaPostulacion(){

        $listaExPost = ExamenPostulante::where('codActor','=',$this->codActor)
            ->orderBy('codExamenPostulante','DESC')    
            ->get();
            
        return $listaExPost[0];

    }

    public function getPuntajePromedio(){
        $listaExPost = ExamenPostulante::where('codActor','=',$this->codActor)
    
        ->get();
        $suma = 0;
        foreach ($listaExPost as $exa ) {
            $suma += $exa->puntajeTotal;
        }



        return $suma/count($listaExPost);
    }
    public function getCantidadPostulaciones(){
        $listaExPost = ExamenPostulante::where('codActor','=',$this->codActor)
    
        ->get();
        $suma = 0;
        



        return count($listaExPost);
    }
    public function getCarreraM??sPostulada(){
        $listaExPost = ExamenPostulante::where('codActor','=',$this->codActor)
        ->get();

        $vectorCarreras = [];
        /* 
        [//las keys son el codCarrera y el value es la cantidad de apariciones
            '2'=>1
        ]
        
        */
        foreach ($listaExPost as $postulacion) {
            if (!array_key_exists($postulacion->codCarrera,$vectorCarreras)){ //verificamos si esa carrera ya est?? en el array
                $vectorCarreras[$postulacion->codCarrera] = 0;
            }
            $vectorCarreras[$postulacion->codCarrera]++;   
        }
        
        arsort($vectorCarreras);
        
        $codCarreraMayor = 0;
        $valorMayor = 0;
        foreach ($vectorCarreras as $key => $value) {
            if($value > $valorMayor){
                $codCarreraMayor = $key;
            }
        }


        return Carrera::findOrFail($codCarreraMayor);
    }


    //Retorna la condici??n de su ultimo examen
    public function getCondicionActual(){
        

        return $this->getUltimaPostulacion()->getCondicion()->nombre;

    }

#endregion FUNCIONES PARA POSTULANTE





}
