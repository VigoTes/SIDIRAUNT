<?php

use App\CondicionPostulacion;
use App\Debug;
use App\Examen;
use App\ExamenPostulante;
use App\GrupoPatron;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


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

/* RUTAS PARA INGRESO Y REGISTRO DE USUARIO Y CLIENTE */


Route::get('/', 'UserController@home')->name('user.home');

Route::get('/login', 'UserController@verLogin')->name('user.verLogin'); //para desplegar la vista del Login
Route::post('/ingresar', 'UserController@logearse')->name('user.logearse'); //post

Route::get('/cerrarSesion','UserController@cerrarSesion')->name('user.cerrarSesion');



Route::get('/probarArchivos','ExamenController@procesarResultados')->name('probarArchivos');

Route::get('/probandoCosas',function(){
    

    return GrupoPatron::buscar('{"1":"A","2":"A","3":"B","8":"B","13":"B","15":"B","23":"B","31":"B","54":"B","59":"B","71":"B","79":"B","94":"B"}',40);

    //   posBuenas=[12,19,20,4,24,8,17,9,3,18]  posMalas[29,25,26,23,6,22]
    //                       EADBEECDCEADDAAECDBEBDDCEAEADC      
    $respuestasCorrectas = "_EADBEECDCEADDAAECDBEBDDCEAEADC"; 
    $vectorAPT = 
        [
            'buenas'=>30,
            'malas'=>0,
        ];

    return Examen::respuestasAleatoriasDePostulante($respuestasCorrectas, $vectorAPT,1,30);


});



/* *********************************** EXAMENES ************************************* */



Route::get('/Examenes/Director/Listar','ExamenController@listar')->name('Examen.Director.Listar');

Route::get('/Examenes/Director/Crear','ExamenController@Crear')->name('Examen.Director.Crear');

Route::get('/Examen/{id}/Director/VerCargarResultados','ExamenController@verCargarResultados')->name('Examen.Director.VerCargar');
Route::post('/Examen/Director/CargarResultados','ExamenController@cargarResultados')->name('Examen.Director.cargarResultados');

Route::get('/Examen/{id}/Director/IniciarProcesamiento','ExamenController@procesar')->name('Examen.Director.Procesar');


Route::get('/Examen/{id}/Director/generarRespuestasPostulantes','ExamenController@generarRespuestasPostulantes')->name('Examen.Director.generarRespuestasPostulantes');


Route::post('/examenes/director/guardar','ExamenController@guardar')->name('Examen.Director.Guardar');

Route::get('/Examen/{id}/VerReporteIrregularidades','ExamenController@VerReporteIrregularidad')->name('Examen.VerReporteIrregularidades');
//modales
Route::get('/Examen/VerReporteIrregularidades/{codGrupo}/ModalExamenesIguales','ExamenController@getModalExamenesIguales');
Route::get('/Examen/VerReporteIrregularidades/{codGrupo}/ModalGrupoRespuestasIguales','ExamenController@getModalGrupoRespuestasIguales');
Route::get('/Examen/VerReporteIrregularidades/{codPostulanteElevado}/ModalPreguntasDePostulante','ExamenController@getModalPreguntasDePostulante');










// Modalidad 
Route::get('/modalidad', 'ModalidadController@index')->name('modalidad');
Route::get('/modalidad/{idmodalidad}/edit', 'ModalidadController@edit')->name('modalidad.editar');
Route::get('/modalidad/{idmodalidad}/delete', 'ModalidadController@destroy')->name('modalidad.eliminar');
Route::get('/modalidad/crear', 'ModalidadController@create')->name('modalidad.crear');
Route::post('/modalidad/guardar', 'ModalidadController@store')->name('modalidad.guardar');
Route::post('/modalidad/actualizar', 'ModalidadController@update')->name('modalidad.actualizar');


