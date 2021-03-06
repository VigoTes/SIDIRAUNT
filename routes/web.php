<?php

use App\Actor;
use App\AnalisisExamen;
use App\CarreraExamen;
use App\CondicionPostulacion;
use App\Debug;
use App\Examen;
use App\ExamenPostulante;
use App\GestionPermisos;
use App\GestorConexiones;
use App\GrupoIguales;
use App\GrupoPatron;
use App\MaracsoftBot;
use App\Observacion;
use App\Parametros;
use App\PostulantesElevados;
use App\Pregunta;
use App\Sede;
use App\Tasa;
use App\TipoActor;
use App\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;



/* RUTAS PARA INGRESO Y REGISTRO DE USUARIO Y CLIENTE */
Route::get('/login', 'UserController@verLogin')->name('user.verLogin'); //para desplegar la vista del Login
Route::post('/ingresar', 'UserController@logearse')->name('user.logearse');
Route::get('/cerrarSesion','UserController@cerrarSesion')->name('user.cerrarSesion');



Route::get('/', 'UserController@home')->name('user.home');

Route::get('/login', 'UserController@verLogin')->name('user.verLogin'); //para desplegar la vista del Login
Route::post('/ingresar', 'UserController@logearse')->name('user.logearse'); //post

Route::get('/editarPassword','UserController@editarPassword')->name('user.editarPassword');
Route::post('/guardarPassword','UserController@guardarPassword')->name('user.guardarPassword');

Route::get('/cerrarSesion','UserController@cerrarSesion')->name('user.cerrarSesion');


Route::get('/probarArchivos','ExamenController@procesarResultados')->name('probarArchivos');

Route::get('/Error','UserController@error')->name('user.error');


Route::get('/probandoCosas',function(){
    return ExamenPostulante::generarNombreUsuario("RODRIGUEZ PAREDES YANELY ANTHONELLA");
/* 
    RODRIGLEN854
    RODRIGLEN104
    RODRIGLEN163
    RODRIGLEN130
 */

});
 
 
Route::get('/probandoCosas2',function(){
    $usuarios=User::where('contraseña','=','1234')->get();
    foreach ($usuarios as $item) {
        $item->contraseña='postulante';
        $item->password=hash::make('postulante');
        $item->save();
    }
});

/* Middleware que cambia la conexión que está usando el usuario con la de su tipo de actor en mysql */
Route::group(['middleware'=>"CambiadorConexiones"],function()
{
    
    /* Aqui van las rutas que pueden usar los anonimos */
    Route::get('/Examenes/Anonimo/Listar','ExamenController@listar')->name('Examen.Anonimo.Listar');
    Route::get('/Examen/{id}/descargarPDF/','ExamenController@descargarPDF')->name('Examen.descargarPDF');

    Route::get('/Examen/{id}/VerPDF/','ExamenController@VerPDF')->name('Examen.VerPDF');

    Route::get('/Examen/verPostulantes/{codExamen}','ExamenPostulanteController@listarDeExamen')->name('Examen.VerPostulantes');
            
    Route::get('/Postulante/verPerfil/{codActor}','PostulanteController@verPerfil')
                ->name('Postulante.VerPerfil'); 

    
    Route::get('/MiPerfil','PostulanteController@MiPerfil') //solo para cuando se logea un postulante
        ->name('MiPerfil'); 
    
    
                
    Route::get('/Examen/VerReporteIrregularidades/{codExamenPostulante}/ModalPreguntasDePostulante','ExamenController@getModalPreguntasDePostulante');
            
    Route::get('/Examen/{id}/descargarReportePostulantes/','ExamenPostulanteController@exportarPostulantes')->name('Examen.ExportarPostulantes');

    /*HISTORICO DE CARRERAS */
    Route::get('/CarreraExamen/VerHistorico', 'CarreraController@verHistorico')->name('CarreraExamen.verHistorico');
    Route::get('/CarreraExamen/{id}/VerHistorico', 'CarreraController@actualizarHistorico')->name('CarreraExamen.actualizarHistorico');

    /* Middleware que valida que haya alguien logeado */
    Route::group(['middleware'=>"ValidarSesion"],function(){

        Route::get('/borrarTodo',function(){
        

            Pregunta::where('codPregunta','>','0')->delete();
            ExamenPostulante::where('codExamen','>','0')->delete();
            AnalisisExamen::where('codAnalisis','>','0')->delete();
            CarreraExamen::where('codExamen','>','0')->delete();
    
            GrupoIguales::where('codAnalisis','>','0')->delete();
            GrupoPatron::where('codAnalisis','>',0)->delete();
            PostulantesElevados::where('codAnalisis','>','0')->delete();

            Observacion::where('codObservacion','>','0')->delete();

            User::where('contraseña','=','postulante')->delete();
            Actor::where('codTipoActor','=',1)->delete();
            
            //Seteamos todos los examenes como archivos cargados
            $listaExamenes = Examen::All();
            foreach ($listaExamenes as $examen) {
                $examen->codEstado = 8;
                $examen->save();
            }
            return "Todo se ha borrado.";
    
        });




        /* *********************************** EXAMENES ************************************* */

            
            Route::get('/Examenes/Director/Listar','ExamenController@listar')->name('Examen.Director.Listar');

            Route::get('/Examenes/Director/Crear','ExamenController@Crear')->name('Examen.Director.Crear');

            Route::get('/Examen/{id}/Director/VerCargarResultados','ExamenController@verCargarResultados')->name('Examen.Director.VerCargar');
            Route::post('/Examen/Director/CargarResultados','ExamenController@cargarResultados')->name('Examen.Director.cargarResultados');

            Route::get('/Examen/{id}/Director/analizarExamen','ExamenController@analizarExamen')->name('Examen.Director.analizarExamen');
            Route::get('/Examen/{id}/Director/IniciarLecturaDatos','ExamenController@IniciarLecturaDatos')->name('Examen.Director.IniciarLecturaDatos');

            Route::get('/Examen/{id}/Resetear','ExamenController@resetear')->name('Examen.Director.Resetear');

            Route::get('/Examen/{id}/Director/PrepararArchivosExamen','ExamenController@PrepararArchivosExamen')->name('Examen.Director.PrepararArchivosExamen');
            Route::get('/Examen/{id}/descargarPDF/','ExamenController@descargarPDF')->name('Examen.descargarPDF');
             



            Route::post('/examenes/director/guardar','ExamenController@guardar')->name('Examen.Director.Guardar');

            Route::get('/Examen/{id}/VerReporteIrregularidades','ExamenController@VerReporteIrregularidad')->name('Examen.VerReporteIrregularidades');
            Route::get('/Examen/{id}/VerReporteIrregularidades/pdf','ExamenController@ExportarPDF')->name('Examen.ReporteIrregularidadesPDF');
            //modales
            Route::get('/Examen/VerReporteIrregularidades/{codGrupo}/ModalExamenesIguales','ExamenController@getModalExamenesIguales');
            Route::get('/Examen/VerReporteIrregularidades/{codGrupo}/ModalGrupoRespuestasIguales','ExamenController@getModalGrupoRespuestasIguales');
            
            
            Route::get('/Examen/VerReporteIrregularidades/{codPostulanteElevado}/ModalPostulanteElevado','ExamenController@getModalPostulanteElevado');
            
            
            /* 
            Route::get('/Examen/{codExamenPostulante}/Historial','ExamenController@VerHistorialPostulante')
                ->name('Examen.VerReporteIrregularidades.VerHistorialPostulante');
            */
            Route::post('/Examen/Consejo/AprobarExamen','ExamenController@aprobarExamen')->name('Examen.Consejo.aprobarExamen');
            
            Route::get('/Examen/ObservarAlgo/{cadena}','ExamenController@ObservarAlgo'); // desde JS
            
            Route::get('/Examen/eliminarObservacion/{codObservacion}','ExamenController@eliminarObservacion');// desde JS
            
            Route::get('/Examen/pasarObservacion/{codObservacion}','ExamenController@pasarObservacion');// desde JS
            Route::get('/Examen/anularExamenesObservacion/{codObservacion}','ExamenController@anularExamenesObservacion');// desde JS
            
            
            Route::get('/Postulante/listar','PostulanteController@listar')
                ->name('Postulante.Listar'); 
            
            Route::get('/Postulante/descargarReportePostulantes','PostulanteController@exportarPostulantes')
                ->name('Postulante.ExportarPostulantes'); 
            /*                     en realidad es codActor */
            
            
            
            // Modalidad 
            Route::get('/Modalidades/Listar', 'ModalidadController@Listar')->name('Modalidades.Listar');
            Route::get('/Modalidades/{idmodalidad}/edit', 'ModalidadController@Editar')->name('Modalidades.Editar');
            Route::get('/Modalidades/{idmodalidad}/delete', 'ModalidadController@Eliminar')->name('Modalidades.Eliminar');
            Route::get('/Modalidades/crear', 'ModalidadController@Crear')->name('Modalidades.Crear');
            Route::post('/Modalidades/guardar', 'ModalidadController@Guardar')->name('Modalidades.Guardar');
            Route::post('/Modalidades/actualizar', 'ModalidadController@Actualizar')->name('Modalidades.Actualizar');
            
            // Sedes 
            Route::get('/sede', 'SedeController@index')->name('sede');
            Route::get('/sede/{idmodalidad}/edit', 'SedeController@edit')->name('sede.editar');
            Route::get('/sede/{idmodalidad}/delete', 'SedeController@destroy')->name('sede.eliminar');
            Route::get('/sede/crear', 'SedeController@create')->name('sede.crear');
            Route::post('/sede/guardar', 'SedeController@store')->name('sede.guardar');
            Route::post('/sede/actualizar', 'SedeController@update')->name('sede.actualizar');
            
            


            //AREA
            Route::resource('area','AreaController');
            Route::get('/area/{id}/eliminar', 'AreaController@eliminar')->name('area.eliminar');

            //FACULTAD
            Route::resource('facultad','FacultadController');
            Route::get('/facultad/{id}/eliminar', 'FacultadController@eliminar')->name('facultad.eliminar');

            //CARRERAS
            Route::get('/Carrera/listar', 'CarreraController@listar')->name('Carrera.listar');
            Route::get('/Carrera/crear', 'CarreraController@crear')->name('Carrera.crear');
            Route::post('/Carrera/guardar', 'CarreraController@guardar')->name('Carrera.guardar');
            Route::get('/Carrera/{id}/editar', 'CarreraController@editar')->name('Carrera.editar');
            Route::post('/Carrera/update', 'CarreraController@update')->name('Carrera.update');
            Route::get('/Carrera/{id}/eliminar', 'CarreraController@eliminar')->name('Carrera.eliminar');

            

            //TASAS
            Route::get('/Tasas', 'DashboardController@listar')->name('Dashboard.listar');
            Route::post('/Tasas/actualizar', 'DashboardController@actualizar')->name('Dashboard.actualizar');

            //ACTORES (DIRECTOR-CONSEJO UNIVERSITARIO)
            Route::get('/Actor/Listar', 'ActorController@listar')->name('Actor.listar');
            Route::get('/Actor/crear', 'ActorController@crear')->name('Actor.crear');
            Route::post('/Actor/guardar', 'ActorController@guardar')->name('Actor.guardar');

            Route::get('/Actor/{codActor}/editarActor', 'ActorController@editarActor')->name('Actor.editarActor');
            Route::post('/Actor/guardarActor', 'ActorController@guardarActor')->name('Actor.guardarActor');

            Route::get('/Actor/{codActor}/editarUsuario', 'ActorController@editarUsuario')->name('Actor.editarUsuario');
            Route::post('/Actor/guardarUsuario', 'ActorController@guardarUsuario')->name('Actor.guardarUsuario');

            Route::get('/Actor/{codActor}/eliminar', 'ActorController@eliminar')->name('Actor.eliminar');


    });



});