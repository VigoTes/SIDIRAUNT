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
       'apellidos', 'nombres', 'codUsuario', 'codTipoActor', 'dni'
    ];

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
        

    
    public function getUsuario(){
        try{
            $usuario = User::findOrFail($this->codUsuario);
        }catch(Throwable $th){
            Debug::mensajeError('MODELO EMPLEADO', $th);
            return "usuario no encontrado.";
        }
        return $usuario;
        
    }

    
    public function getNombreCompleto(){
        return $this->apellidos.' '.$this->nombres;
    }
}
