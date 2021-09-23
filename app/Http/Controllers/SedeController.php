<?php

namespace App\Http\Controllers;

use App\Debug;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sede;

class SedeController extends Controller
{
    public function index()
    {
        try {
            $sedes = Sede::all();

            return view('Sedes.listar', compact('sedes'));
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    public function create(Request $request)
    {
        try {
            return view('Sedes.crear');
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $sede = new Sede();
        
            $sede->nombre = request()->nombre;
        
            $sede->save();
    
            $message = 'Fue registrada la sede'. $sede->name .' exitosamente';
    
            return redirect()->route('sede')->with('message', $message);
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $sede = Sede::find($id);

            return view('Sedes.editar', compact(['sede']));
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $sede = Sede::find(request()->codSede);

            $sede->nombre = request()->nombre;
    
            $sede->save();
    
            return redirect()->route('sede')->with('message', 'Sede actualizada correctamente!');
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Sede::destroy($id);

            return redirect()->route('sede')->with('message', 'Registro eliminado correctamente!');
        } catch (\Throwable $th) {
            return Debug::procesarExcepcion($th);
        }
    }

}
