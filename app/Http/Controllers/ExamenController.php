<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Area;
use App\Debug;
use App\Examen;
use App\Fecha;
use App\Http\Controllers\Controller;
use App\Modalidad;
use App\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExamenController extends Controller
{
    public const PAGINACION = 20;

    public function listar(){
        $listaExamenes = Examen::where('codExamen','>','0')->paginate($this::PAGINACION);
        $fechaInicio = null;
        $fechaFin= null;
        

        return view('Examenes.ListarExamenes',compact('listaExamenes','fechaInicio','fechaFin'));
    }


    public function Crear(){
        $listaModalidades = Modalidad::All();
        $listaAreas = Area::All(); 
        $listaSedes = Sede::All();
        return view('Examenes.CrearExamen',compact('listaModalidades','listaAreas','listaSedes'));

    }


    public function guardar(Request $request){
        try{
            DB::beginTransaction();

            $empleadoLogeado = Actor::getActorLogeado();  

            $examen = new Examen();
            $examen->año = $request -> año;
            $examen->fechaRendicion = Fecha::formatoParaSQL($request -> fechaRendicion);
            $examen->nroVacantes= $request -> nroVacantes;
            $examen->nroPostulantes= $request -> nroPostulantes;
            $examen->asistentes= $request -> asistentes;
            $examen->ausentes= $request -> ausentes;
            $examen->codModalidad= $request -> codModalidad;
            $examen->codSede= $request -> codSede;
            $examen->codEstado= 1;

            $examen->valoracionPositivaCON = $request->valoracionPositivaCON; 
            $examen->valoracionPositivaAPT = $request->valoracionPositivaAPT; 
            $examen->valoracionNegativaCON = $request->valoracionNegativaCON; 
            $examen->valoracionNegativaAPT = $request->valoracionNegativaAPT; 

            
            
            $examen->save();


            //$solicitud->fechaHoraRevisado = Carbon::now();

 
            DB::commit();
            return redirect()->route('Examen.Director.Listar')
            ->with('datos','Examen creado.');

        } catch (\Throwable $th) {
            Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : OBSERVAR',$th);
           
            DB::rollBack();
            
            return redirect()->route('Examen.Director.Listar')
            ->with('datos','Ha ocurrido un error interno.');
        }

    }

    public function verCargarResultados($codExamen){

        $examen = Examen::findOrFail($codExamen);

        return view('Examenes.CargarResultados',compact('examen'));

    }




    public function cargarResultados(Request $request){
        try {
            
 
            DB::beginTransaction();   
                        
            $examen = Examen::findOrFail($request->codExamen);
            $examen->codEstado = 2;
            $examen->save();
            
            $archivoRespuestas = $request->file('archivoRespuestas'); 
            $archivoPreguntas = $request->file('archivoPreguntas'); 
            $archivoExamenEscaneado = $request->file('archivoExamenEscaneado'); 


            $filegetRespuestas = \File::get( $archivoRespuestas );
            Storage::disk('examenes')->put($examen->getNombreArchivoRespuestas(),$filegetRespuestas );

            $filegetPreguntas = \File::get( $archivoPreguntas );
            Storage::disk('examenes')->put($examen->getNombreArchivoPreguntas(),$filegetPreguntas );

            $filegetEscaneado = \File::get( $archivoExamenEscaneado );
            Storage::disk('examenes')->put($examen->getNombreArchivoExamenEscaneado(),$filegetEscaneado );

            
            DB::commit();  
            return redirect()
                ->route('Examen.Director.Listar')
                ->with('datos','Se han cargados los datos del examen');
        }catch(\Throwable $th){
            
            Debug::mensajeError('EXAMEN CONTROLLER : CARGAR RESULTADOS ',$th);
            
            DB::rollback();
            
            
        }

    }

    public function procesar(){

        //$examen = Examen::findOrFail(1);
        //$examen->procesarArchivoPreguntas();
        for ($i=0; $i < 10000; $i++) { 
            Debug::mensajeSimple($i);
        }

        return "1";
    }   

    

}
