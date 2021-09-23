<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoActor extends Model
{
    protected $table = "tipo_actor";
    protected $primaryKey = "codTipoActor";
    public $timestamps = false; 


    protected $fillable = [
       'nombre'
    ];

    public function getPermisosPredefinidos(){
        $nombreActor = $this->nombre;
        switch ($nombreActor) {
            case 'Postulante':
                $nombreUsuarioMySQL = 'postulante';
                $vectorPermisos = [
                    'permiso_Select' => 'Y',
                    'permiso_Insert' => 'N',
                    'permiso_Update' => 'N',
                    'permiso_Delete' => 'N'

                ];

                break;
            case 'Consejo Universitario':
                $nombreUsuarioMySQL = 'representante';
                $vectorPermisos = [
                    'permiso_Select' => 'Y',
                    'permiso_Insert' => 'Y',
                    'permiso_Update' => 'Y',
                    'permiso_Delete' => 'Y'

                ];

                break;
            case 'Dirección de Sistemas y Comunicaciones':
                $nombreUsuarioMySQL = 'director';
                $vectorPermisos = [
                    'permiso_Select' => 'Y',
                    'permiso_Insert' => 'Y',
                    'permiso_Update' => 'Y',
                    'permiso_Delete' => 'Y'

                ];

                break;
            default:
                # code...
                break;
        }
        return $vectorPermisos;

    }
}
