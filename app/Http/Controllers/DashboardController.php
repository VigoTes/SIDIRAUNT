<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Parametros;
use App\Tasa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function listar(){
        $tasas=Tasa::all();
        $parametros=Parametros::all();
        return view('Tasas.MantenedorTasas',compact('tasas','parametros'));
    }

    public function actualizar(Request $request){
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
    }
}
