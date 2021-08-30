<?php

use App\Actor;
use App\AnalisisExamen;
use App\CarreraExamen;
use App\CondicionPostulacion;
use App\Debug;
use App\Examen;
use App\ExamenPostulante;
use App\GrupoIguales;
use App\GrupoPatron;
use App\MaracsoftBot;
use App\Parametros;
use App\PostulantesElevados;
use App\Pregunta;
use App\Tasa;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::get('/Carrera/VerHistorico', 'CarreraController@verHistorico')->name('Carrera.verHistorico');
Route::get('/Carrera/{id}/VerHistorico', 'CarreraController@actualizarHistorico')->name('Carrera.actualizarHistorico');

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

/* RUTAS PARA INGRESO Y REGISTRO DE USUARIO Y CLIENTE */
Route::get('/login', 'UserController@verLogin')->name('user.verLogin'); //para desplegar la vista del Login
Route::post('/ingresar', 'UserController@logearse')->name('user.logearse');
Route::get('/cerrarSesion','UserController@cerrarSesion')->name('user.cerrarSesion');



Route::get('/', 'UserController@home')->name('user.home');

Route::get('/login', 'UserController@verLogin')->name('user.verLogin'); //para desplegar la vista del Login
Route::post('/ingresar', 'UserController@logearse')->name('user.logearse'); //post

Route::get('/cerrarSesion','UserController@cerrarSesion')->name('user.cerrarSesion');



Route::get('/probarArchivos','ExamenController@procesarResultados')->name('probarArchivos');

Route::get('/probandoCosas',function(){
     
     MaracsoftBot::enviarMensaje('hola');
     
});

/* 
ProcedimientoAlmacenado _ABBBBBBBBABBBBBBBBBABBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBD
Procedimiento en PHP:   _ABBBBBBBBABBBBBBBBBABBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBD
*/
 
Route::get('/probandoCosas2',function(){
    

});


Route::get('/borrarTodo',function(){
    

    Pregunta::where('codPregunta','>','0')->delete();
    ExamenPostulante::where('codExamen','>','0')->delete();
    AnalisisExamen::where('codAnalisis','>','0')->delete();
    CarreraExamen::where('codExamen','>','0')->delete();

    GrupoIguales::where('codAnalisis','>','0')->delete();
    GrupoPatron::where('codAnalisis','>',0)->delete();
    PostulantesElevados::where('codAnalisis','>','0')->delete();
    
    User::where('contraseña','=','123')->delete();
    Actor::where('codTipoActor','=',1)->delete();

    //Seteamos todos los examenes como archivos cargados
    $listaExamenes = Examen::All();
    foreach ($listaExamenes as $examen) {
        $examen->codEstado = 8;
        $examen->save();
    }
    

});



/* *********************************** EXAMENES ************************************* */

Route::get('/Examen/{id}/verPostulantes','ExamenPostulanteController@listarDeExamen')->name('Examen.VerPostulantes');
Route::get('/Examen/{id}/descargarReportePostulantes/','ExamenPostulanteController@exportarPostulantes')->name('Examen.ExportarPostulantes');

Route::get('/Examenes/Director/Listar','ExamenController@listar')->name('Examen.Director.Listar');

Route::get('/Examenes/Director/Crear','ExamenController@Crear')->name('Examen.Director.Crear');

Route::get('/Examen/{id}/Director/VerCargarResultados','ExamenController@verCargarResultados')->name('Examen.Director.VerCargar');
Route::post('/Examen/Director/CargarResultados','ExamenController@cargarResultados')->name('Examen.Director.cargarResultados');

Route::get('/Examen/{id}/Director/analizarExamen','ExamenController@analizarExamen')->name('Examen.Director.analizarExamen');
Route::get('/Examen/{id}/Director/IniciarLecturaDatos','ExamenController@IniciarLecturaDatos')->name('Examen.Director.IniciarLecturaDatos');

Route::get('/Examen/{id}/Director/PrepararArchivosExamen','ExamenController@PrepararArchivosExamen')->name('Examen.Director.PrepararArchivosExamen');
Route::get('/Examen/{id}/descargarPDF/','ExamenController@descargarPDF')->name('Examen.descargarPDF');
Route::get('/Examen/{id}/VerPDF/','ExamenController@VerPDF')->name('Examen.VerPDF');




Route::post('/examenes/director/guardar','ExamenController@guardar')->name('Examen.Director.Guardar');

Route::get('/Examen/{id}/VerReporteIrregularidades','ExamenController@VerReporteIrregularidad')->name('Examen.VerReporteIrregularidades');
Route::get('/Examen/{id}/VerReporteIrregularidades/pdf','ExamenController@ExportarPDF')->name('Examen.ReporteIrregularidadesPDF');
//modales
Route::get('/Examen/VerReporteIrregularidades/{codGrupo}/ModalExamenesIguales','ExamenController@getModalExamenesIguales');
Route::get('/Examen/VerReporteIrregularidades/{codGrupo}/ModalGrupoRespuestasIguales','ExamenController@getModalGrupoRespuestasIguales');
Route::get('/Examen/VerReporteIrregularidades/{codExamenPostulante}/ModalPreguntasDePostulante','ExamenController@getModalPreguntasDePostulante');
Route::get('/Examen/VerReporteIrregularidades/{codPostulanteElevado}/ModalPostulanteElevado','ExamenController@getModalPostulanteElevado');



Route::get('/Examen/{codExamenPostulante}/Historial','ExamenController@VerHistorialPostulante')->name('Examen.VerReporteIrregularidades.VerHistorialPostulante');
Route::post('/Examen/Consejo/AprobarExamen','ExamenController@aprobarExamen')->name('Examen.Consejo.aprobarExamen');

Route::get('/Examen/ObservarAlgo/{cadena}','ExamenController@ObservarAlgo'); // desde JS

Route::get('/Examen/eliminarObservacion/{codObservacion}','ExamenController@eliminarObservacion');// desde JS

Route::get('/Examen/pasarObservacion/{codObservacion}','ExamenController@pasarObservacion');// desde JS
Route::get('/Examen/anularExamenesObservacion/{codObservacion}','ExamenController@anularExamenesObservacion');// desde JS


Route::get('/Postulante/listar','PostulanteController@listar')->name('Postulante.Listar'); 
Route::get('/Postulante/verPerfil/{codActor}','PostulanteController@verPerfil')->name('Postulante.VerPerfil'); 
Route::get('/Postulante/descargarReportePostulantes','PostulanteController@exportarPostulantes')->name('Postulante.ExportarPostulantes'); 
/*                     en realidad es codActor */



// Modalidad 
Route::get('/modalidad', 'ModalidadController@index')->name('modalidad');
Route::get('/modalidad/{idmodalidad}/edit', 'ModalidadController@edit')->name('modalidad.editar');
Route::get('/modalidad/{idmodalidad}/delete', 'ModalidadController@destroy')->name('modalidad.eliminar');
Route::get('/modalidad/crear', 'ModalidadController@create')->name('modalidad.crear');
Route::post('/modalidad/guardar', 'ModalidadController@store')->name('modalidad.guardar');
Route::post('/modalidad/actualizar', 'ModalidadController@update')->name('modalidad.actualizar');

// Sedes 
Route::get('/sede', 'SedeController@index')->name('sede');
Route::get('/sede/{idmodalidad}/edit', 'SedeController@edit')->name('sede.editar');
Route::get('/sede/{idmodalidad}/delete', 'SedeController@destroy')->name('sede.eliminar');
Route::get('/sede/crear', 'SedeController@create')->name('sede.crear');
Route::post('/sede/guardar', 'SedeController@store')->name('sede.guardar');
Route::post('/sede/actualizar', 'SedeController@update')->name('sede.actualizar');

