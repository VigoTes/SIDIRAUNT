<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


/* RUTAS PARA INGRESO Y REGISTRO DE USUARIO Y CLIENTE */


Route::get('/', 'UserController@home')->name('user.home');

Route::get('/login', 'UserController@verLogin')->name('user.verLogin'); //para desplegar la vista del Login
Route::post('/ingresar', 'UserController@logearse')->name('user.logearse'); //post

Route::get('/cerrarSesion','UserController@cerrarSesion')->name('user.cerrarSesion');



Route::get('/generarRegistros',function(){
    


});



Route::get('/probandoCosas',function(){
    /* 
        aptitud: 
            correcta -> 4.070
            incorrecta -> 1.019
    */
    $valorCorrecta = 4.07;
    $valorIncorrecta = 1.019;
    $cantidadPreguntasAptitud = 40;
    $vector = [55.949,49.853,47.815,59.006,46.790,44.764,66.133,51.891,40.688,38.650,47.809,56.974,49.847,26.440,47.815,36.618,40.688,56.974,29.491,34.586,39.669,41.707,40.688,39.681,45.777,37.631,40.694,27.459,46.796,26.440,37.637,42.726,38.656,51.885,42.726,44.758,48.834,53.917,39.675,37.637,47.815,26.440,42.726,28.484,33.567,26.446,44.758,29.497,42.726,32.542];
    $cadena = "";
    $adicion ="";
    foreach($vector as $item){
        $band = true;
         
        //para cada valor, le buscamos combinaciones de valores que generen ese numero 
        for ($i=0; $i < 40 && $band; $i++) {  
            for ($j=0; $j < 40 && $band; $j++) { 
                if($i*$valorCorrecta - $j*$valorIncorrecta == $item)
                {
                    $adicion = $item." i=".$i." j=".$j."  /";
                    $band = false;
                }
            } 

        }

        if($band){
            $adicion= $item." noV /";
        }

        $cadena = $cadena.$adicion."<br>";
    }
    
    return $cadena;

});

