<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sede;

class SedeController extends Controller
{
    public function index()
    {
        $sedes = Sede::all();

        return view('Sedes.listar', compact('sedes'));
    }

    public function create(Request $request)
    {
        return view('Sedes.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sede = new Sede();
        
        $sede->nombre = request()->nombre;
    
        $sede->save();

        $message = 'Fue registrada la sede'. $sede->name .' exitosamente';

        return redirect()->route('sede')->with('message', $message);
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
        $sede = Sede::find($id);

        return view('Sedes.editar', compact(['sede']));
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
        $sede = Sede::find(request()->codSede);

        $sede->nombre = request()->nombre;

        $sede->save();

        return redirect()->route('sede')->with('message', 'Sede actualizada correctamente!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Sede::destroy($id);

        return redirect()->route('sede')->with('message', 'Registro eliminado correctamente!');
    }

}
