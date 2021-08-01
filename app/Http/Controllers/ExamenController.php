<?php

namespace App\Http\Controllers;

use App\Actor;
use App\AnalisisExamen;
use App\Area;
use App\Debug;
use App\Examen;
use App\ExamenPostulante;
use App\Fecha;
use App\GrupoIguales;
use App\GrupoPatron;
use App\Http\Controllers\Controller;
use App\Modalidad;
use App\PostulantesElevados;
use App\Pregunta;
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

    public function VerReporteIrregularidad($id){

        $examen=Examen::findOrFail($id);
        $analisis=AnalisisExamen::findOrFail($examen->codExamen);

        /*
        $pieGruposIguales=[
            "labels"=>['Chrome','IE','FireFox','Safari','Opera','Navigator'],
            "value"=>[700,500,400,600,300,100],
            "color"=>[sprintf('#%06X', mt_rand(0, 0xFFFFFF)), '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de']
        ];
        
        $pieGruposIguales['labels'][]='xdxd';
        $pieGruposIguales['value'][]=200;
        $pieGruposIguales['color'][]=sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        $pieGruposPatron=$pieGruposIguales;
        */



        //para las 3 tablas
        $gruposIguales=GrupoIguales::where('codAnalisis','=',$analisis->codAnalisis)->get();
        $gruposPatron=GrupoPatron::where('codAnalisis','=',$analisis->codAnalisis)->get();
        $postulantesElevados=PostulantesElevados::where('codAnalisis','=',$analisis->codAnalisis)->get();
        //para los 3 pie
        $pieGruposIguales=['labels'=>[],'value'=>[],'color'=>[]];
        foreach ($gruposIguales as $item) {
            $pieGruposIguales['labels'][]=$item->identificador();
            $pieGruposIguales['value'][]=$item->cantidadPostulantes();
            $pieGruposIguales['color'][]=sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }
        $pieGruposPatron=['labels'=>[],'value'=>[],'color'=>[]];
        foreach ($gruposPatron as $item) {
            $pieGruposPatron['labels'][]=$item->identificador();
            $pieGruposPatron['value'][]=$item->cantidadPostulantes();
            $pieGruposPatron['color'][]=sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }
        $piePostulantesElevados=[
            "labels"=>['CRECIMIENTO ANORMAL','CRECIMIENTO ESTANDAR'],
            "value"=>[count($postulantesElevados),$examen->asistentes-count($postulantesElevados)],
            "color"=>[sprintf('#%06X', mt_rand(0, 0xFFFFFF)), sprintf('#%06X', mt_rand(0, 0xFFFFFF))]
        ];



        return view('Examenes.VerReporteIrregularidades',compact('examen','analisis','gruposIguales','gruposPatron','postulantesElevados',
                                                                    'pieGruposIguales','pieGruposPatron','piePostulantesElevados'));
    }

    public function getModalExamenesIguales($codGrupo){
        return view('Examenes.Modales.ModalExamenesIguales');
    }
    public function getModalGrupoRespuestasIguales($codGrupo){
        return view('Examenes.Modales.ModalGrupoRespuestasIguales');
    }
    public function getModalPreguntasDePostulante($codPostulanteElevado){
        return view('Examenes.Modales.ModalPreguntasDePostulante');
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

    public function procesar($codExamen){


        $examen = Examen::findOrFail($codExamen);

        Pregunta::where('codExamen','=',$examen->codExamen)->delete();
        //$examen->procesarArchivoPreguntas();
        $examen->procesarArchivoRespuestas();
        
        return "1";


    }   


    public function generarRespuestasPostulantes($codExamen){
        
        $examen = Examen::findOrFail($codExamen);

        //Pregunta::where('codExamen','=',$examen->codExamen)->delete();
        return $examen->generarRespuestasPostulantes();

    }

    

}
