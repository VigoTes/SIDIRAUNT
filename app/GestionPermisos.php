<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class GestionPermisos
{
    
    /* 
    Clase para consultar los permisos de un actor de la tabla de permisos de MySQL
    */


    /* para este punto, se tiene que validar antes que haya un actor logeado */

    // Esta funcion valida que los permisos establecidos en Laravel coincidan con los establecidos en mysql, retorna true o false
    
    //nombrePermiso = Select Insert Update Delete
    /* 
    
    DEPRECADO PQ AHORA CAMBIO LA CONEXION DIRECTAMENTE
    
    public static function tienePermisos(){
        
        $actorLogeado = Actor::getActorLogeado();
        $nombreActor = $actorLogeado->getTipoActor()->nombre;

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
            default:
                # code...
                break;
        }

        $consultaSQL = "SELECT * FROM mysql.db where User = '$nombreUsuarioMySQL'";

        $respuesta = DB::select($consultaSQL)[0];

        //return $respuesta[$nombrePermiso.'_priv'];

        $vectorPermisosMysql = [
            'permiso_Select' => $respuesta->Select_priv,
            'permiso_Insert' => $respuesta->Insert_priv,
            'permiso_Update' => $respuesta->Update_priv,
            'permiso_Delete' => $respuesta->Delete_priv
        ];
        //en cada variable puede estar 'Y'(si) o 'N' (no)
        
        $vectorPermisosLaravel = $actorLogeado->getTipoActor()->getPermisosPredefinidos();
        foreach ($vectorPermisosLaravel as $nombreDelPermiso => $condicion) {
            if($vectorPermisosLaravel[$nombreDelPermiso] != $vectorPermisosMysql[$nombreDelPermiso])
                return false;
        }

        return true;

    }
 */
}
