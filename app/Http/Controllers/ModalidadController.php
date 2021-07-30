<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modalidad;

class ModalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $modalidades = Modalidad::all();

        return view('Modalidad.listar', compact('modalidades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('Modalidad.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $modalidad = new Modalidad();
        
        $modalidad->nombre = request()->nombre;
    
        $modalidad->save();

        $message = 'Fue registrada la modalidad'. $modalidad->name .' exitosamente';

        return redirect()->route('modalidad')->with('message', $message);
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
        $modalidad = Modalidad::find($id);

        return view('Modalidad.editar', compact(['modalidad']));
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
        $modalidad = Modalidad::find(request()->codModalidad);

        $modalidad->nombre = request()->nombre;

        $modalidad->save();

        return redirect()->route('modalidad')->with('message', 'Modalidad actualizada correctamente!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Modalidad::destroy($id);

        return redirect()->route('modalidad')->with('message', 'Registro eliminado correctamente!');
    }
}
