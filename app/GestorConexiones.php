<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class GestorConexiones 
{
    //


    /* 
        Cambia la conexión de la base de datos a la especificada en el parametro
        (solo cambia el username, los demás parametros quedan iguales)
    */
    private static function cambiarConexion($mysql_username){

        //Obtenemos la configuracion actual de la conexión
        $config = Config::get('database.connections.mysql');
        $config['username'] = $mysql_username; //cambiamos el username segun el que se nos haya pasado por parametro
        
        config()->set('database.connections.mysql', $config);
        //hasta aquí ya estaría
        /* Pero añadiré una validación para confirmar que efectivamente se cambió */
        $configVerificacion = Config::get('database.connections.mysql');
        if($configVerificacion['username']!=$mysql_username)
            throw new Exception("Ha ocurrido un error en GestorConexiones::cambiarConexion.",1);

        
    }


    public static function cambiarConexionSegunLogeado(){

        $actorLogeado = Actor::getActorLogeado();
        if($actorLogeado==false){
            $nombreActor = 'anonimo';
        }else{
            $nombreActor = $actorLogeado->getTipoActor()->nombre;
        }
        
        switch ($nombreActor) {
            case 'Postulante':
                $nombreUsuarioMySQL = 'postulante';
                break;
            case 'Consejo Universitario':
                $nombreUsuarioMySQL = 'representante';
                break;
            case 'Dirección de Sistemas y Comunicaciones':
                $nombreUsuarioMySQL = 'director';
                break;
            case 'anonimo':
                $nombreUsuarioMySQL = 'anonimo';
            default:
                # code...
                break;
        }
        
        GestorConexiones::cambiarConexion($nombreUsuarioMySQL);
        Debug::mensajeSimple("Conexión cambiada exitosamente");

    }

}


