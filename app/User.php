<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "usuario";
    protected $primaryKey = "codUsuario";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
       'usuario', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function usuario(){
        return $this->hasOne('App\Usuario','codUsuario','codUsuario');
    }

    /*
    public static function getEmpleadoLogeado(){
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

    public static function hayEmpleadoLogeado(){
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
    */
}
