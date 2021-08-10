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

    public function getExamenPostulante($codExamen){
        return ExamenPostulante::where('codExamen','=',$codExamen)->where('codActor','=',$this->codActor)->get()[0];
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


        if(count($actores)<0) //si no encontró el empleado de este user 
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


        if(count($actores)<0) //si no encontró el empleado de este user 
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
    public function getCarreraMásPostulada(){
        $listaExPost = ExamenPostulante::where('codActor','=',$this->codActor)
        ->get();

        $vectorCarreras = [];
        /* 
        [//las keys son el codCarrera y el value es la cantidad de apariciones
            '2'=>1
        ]
        
        */
        foreach ($listaExPost as $postulacion) {
            if (!array_key_exists($postulacion->codCarrera,$vectorCarreras)){ //verificamos si esa carrera ya está en el array
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


    //Retorna la condición de su ultimo examen
    public function getCondicionActual(){
        

        return $this->getUltimaPostulacion()->getCondicion()->nombre;

    }

#endregion FUNCIONES PARA POSTULANTE





}
