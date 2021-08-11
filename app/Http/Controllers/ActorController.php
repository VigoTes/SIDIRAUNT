<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Debug;
use App\Http\Controllers\Controller;
use App\TipoActor;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    const PAGINATION = 15;

    public function listar(){
        $actores = Actor::where('codTipoActor','!=',1)->paginate($this::PAGINATION);

        return view('Actores.ListarActores',compact('actores'));
    }

    public function crear(){
        $tipos=TipoActor::where('codTipoActor','!=',1)->get();
        return view('Actores.crear',compact('tipos'));
    }

    public function guardar(Request $request){
        try{
            DB::beginTransaction();
            
            $usuario=new User();
            $usuario->usuario=$request->usuario;
            $usuario->password=hash::make($request->contraseña);
            $usuario->save();

            $actor=new Actor();
            $actor->apellidosYnombres=$request->apellidos.' '.$request->nombres;
            $actor->codUsuario=$usuario->codUsuario;
            $actor->codTipoActor=$request->codTipoActor;
            $actor->save();
            

            db::commit();
            return redirect()->route('Actor.listar')
                ->with('datos','Actor '.$actor->apellidosYnombres.' registrado exitosamente');
            
        }catch (\Throwable $th) {
            //Debug::mensajeError(' ACTOR CONTROLLER guardarcrearactor' ,$th);    
            DB::rollback();

            return redirect()->route('Actor.listar')
                ->with('datos','Error al registrar un actor');
                
        }
         
    }

    public function editarActor($codActor){
        $actor=Actor::findOrFail($codActor);
        $tipos=TipoActor::where('codTipoActor','!=',1)->get();

        return view('Actores.EditarActor',compact('actor','tipos'));
    }
    
    public function guardarActor(Request $request){
        try{
            DB::beginTransaction();
            
            $actor=Actor::findOrFail($request->codActor);
            $actor->apellidosYnombres=$request->apellidosYnombres;
            $actor->codTipoActor=$request->codTipoActor;
            $actor->save();
            

            db::commit();
            return redirect()->route('Actor.listar')
                ->with('datos','Actor '.$actor->apellidosYnombres.' editado exitosamente');
            
        }catch (\Throwable $th) {
            //Debug::mensajeError(' EMPLEADO CONTROLLER guardarcrearempleado' ,$th);    
            DB::rollback();

            return redirect()->route('Actor.listar')
                ->with('datos','Error al editar un actor');
                
        }
         
    }

    public function editarUsuario($codActor){
        $actor=Actor::findOrFail($codActor);
        $usuario=User::findOrFail($actor->codUsuario);
        return view('Actores.EditarUsuario',compact('usuario'));
    }

    public function guardarUsuario(Request $request){
        try{
            DB::beginTransaction();
            
            $usuario=User::findOrFail($request->codUsuario);
            $usuario->usuario=$request->usuario;
            $usuario->password=hash::make($request->contraseña);
            $usuario->save();
            
            $actor=Actor::where('codUsuario','=',$request->codUsuario)->get()[0];

            db::commit();
            return redirect()->route('Actor.listar')
                ->with('datos','Actor '.$actor->apellidosYnombres.' editado exitosamente');
            
        }catch (\Throwable $th) {
            //Debug::mensajeError(' EMPLEADO CONTROLLER guardarcrearempleado' ,$th);    
            DB::rollback();

            return redirect()->route('Actor.listar')
                ->with('datos','Error al editar un actor');
                
        }
         
    }

    public function eliminar($codActor){
        $actor=Actor::findOrFail($codActor);
        $actor->delete();

        return redirect()->route('Actor.listar')
                ->with('datos','Actor '.$actor->apellidosYnombres.' eliminado exitosamente');
    }
}
