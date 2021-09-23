<?php

namespace App\Http\Controllers;

use App\Debug;
use App\Http\Controllers\Controller;
use App\Parametros;
use App\Tasa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function listar(){
        try {
            $tasas=Tasa::all();
            $parametros=Parametros::all();
            return view('Tasas.MantenedorTasas',compact('tasas','parametros'));
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    public function actualizar(Request $request){
        try {
            $tasas=Tasa::all();
            foreach ($tasas as $itemTasa) {
                $itemTasa->valorTasa=$request->get('tasa'.$itemTasa->codTasa);
                $itemTasa->save();
            }
            $parametros=Parametros::all();
            foreach ($parametros as $itemParametro) {
                $itemParametro->valor=$request->get('parametro'.$itemParametro->codParametro);
                $itemParametro->save();
            }
            return redirect()->route('Dashboard.listar');
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }
}
