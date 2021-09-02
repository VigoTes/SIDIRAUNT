<?php

namespace App\Http\Controllers;

use App\Actor;
use App\AnalisisExamen;
use App\Area;
use App\Debug;
use App\EstadoExamen;
use App\Examen;
use App\ExamenPostulante;
use App\Fecha;
use App\GrupoIguales;
use App\GrupoPatron;
use App\Http\Controllers\Controller;
use App\MaracsoftBot;
use App\Modalidad;
use App\Observacion;
use App\PostulantesElevados;
use App\Pregunta;
use App\Sede;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;

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
        $estados=EstadoExamen::whereIn('codEstado',[4,5])->get();
        $examen=Examen::findOrFail($id);
        $analisis = AnalisisExamen::where('codExamen','=',$id)->get()[0];
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
            $pieGruposIguales['labels'][]='Grupo '.$item->identificador();
            $pieGruposIguales['value'][]=$item->cantidadPostulantes();
            $pieGruposIguales['color'][]=sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }
        $pieGruposPatron=['labels'=>[],'value'=>[],'color'=>[]];
        foreach ($gruposPatron as $item) {
            $pieGruposPatron['labels'][]='Grupo '.$item->identificador();
            $pieGruposPatron['value'][]=$item->cantidadPostulantes();
            $pieGruposPatron['color'][]=sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }
        $piePostulantesElevados=[
            "labels"=>['CRECIMIENTO ANORMAL','CRECIMIENTO ESTANDAR'],
            "value"=>[count($postulantesElevados),$examen->asistentes-count($postulantesElevados)],
            "color"=>[sprintf('#%06X', mt_rand(0, 0xFFFFFF)), sprintf('#%06X', mt_rand(0, 0xFFFFFF))]
        ];



        return view('Examenes.VerReporteIrregularidades',compact('estados','examen','analisis','gruposIguales','gruposPatron','postulantesElevados',
                                                                    'pieGruposIguales','pieGruposPatron','piePostulantesElevados'));
    }


    // aunque se llama aprobar, en realidad aprueba y cancela
    public function aprobarExamen(Request $request){
        $examen=Examen::findOrFail($request->codExamen);

        //VALIDACION DE SI ES CONSEJO UNIVERSITARIO
        if(!Actor::getActorLogeado()->esConsejoUniversitario()){
            return redirect()->route('Examen.VerReporteIrregularidades',$examen->codExamen)
                ->with('datos','USTED NO ES CONSEJO UNIVERSITARIO');
        }

        //VALIDACION DE SI LA CONTRA ESTA CORRECTA
        $hashp=Actor::getActorLogeado()->getUsuario()->password;
        $password=$request->get('contraseña');
        if(!password_verify($password,$hashp)){
            return redirect()->route('Examen.VerReporteIrregularidades',$examen->codExamen)
                ->with('datos','CONTRASEÑA ERRONEA');
        }

        
        $examen->codEstado=$request->codEstado;
        $examen->save();

        return redirect()->route('Examen.Director.Listar')
            ->with('datos','Examen '.EstadoExamen::findOrFail($examen->codEstado)->descripcion.'');
    }

    public function getModalExamenesIguales($codGrupo){
        $grupoIguales=GrupoIguales::findOrFail($codGrupo);
        $analisis=AnalisisExamen::findOrFail($grupoIguales->codAnalisis);

        //$respuestasProbando="_ABXBBDBXBXBXBBBBBXXXBDXBXXBXBBDXXXXXBBBBXXXBXBBDXXBBXXBXXBBBXBBXBXBXXBAXXXBXXDXBBBXBXXXBBBXXXBXXXXAX";
        $solucionario=Examen::findOrFail($analisis->codExamen)->getStringRespuestas();
        $respuestasProbando=$grupoIguales->respuestasJSON;
        $arr=['clave'=>[],'color'=>[]];
        for ($i=0; $i < strlen($respuestasProbando); $i++) { 
            if(substr($respuestasProbando,$i, 1)=='X'){
                $arr['clave'][]=" ";
            }else{
                $arr['clave'][]=substr($respuestasProbando,$i, 1);
            }
            
            if(substr($respuestasProbando,$i, 1)==substr($solucionario,$i, 1)){
                $arr['color'][]="green";
            }else{
                $arr['color'][]="red";
            }
            
        }

        //para los postulantes
        $examenPostulanteArr = explode(',', $grupoIguales->vectorExamenPostulante);
        $examenPostulante=ExamenPostulante::whereIn('codExamenPostulante',$examenPostulanteArr)->get();
        $postulantesArr=[];
        foreach ($examenPostulante as $item) {
            $postulantesArr[]=$item->codActor;
        }
        $postulantes=Actor::whereIn('codActor',$postulantesArr)->get();

        return view('Examenes.Modales.ModalExamenesIguales',compact('arr','respuestasProbando','solucionario','grupoIguales','postulantes','analisis'));
    }


    
    public function getModalGrupoRespuestasIguales($codGrupo){
        $grupoPatrones=GrupoPatron::findOrFail($codGrupo);
        $analisis=AnalisisExamen::findOrFail($grupoPatrones->codAnalisis);

        $solucionario=Examen::findOrFail($analisis->codExamen)->getStringRespuestas();
        $respuestasProbando=json_decode($grupoPatrones->respuestasCoincidentesJSON,true);
        $arr=['clave'=>["_"],'color'=>["black"]];
        for ($i=1; $i <= 100; $i++) { 
            if(isset($respuestasProbando[$i])){
                $arr['clave'][]=$respuestasProbando[$i];
                if($respuestasProbando[$i]==substr($solucionario,$i, 1)){
                    $arr['color'][]="green";
                }else{
                    $arr['color'][]="red";
                }
            }else{
                $arr['clave'][]=" ";
                $arr['color'][]="black";
            }
            
        }
        //para los postulantes
        $examenPostulanteArr = explode(',', $grupoPatrones->vectorExamenPostulante);
        $examenPostulante=ExamenPostulante::whereIn('codExamenPostulante',$examenPostulanteArr)->get();
        $postulantesArr=[];
        foreach ($examenPostulante as $item) {
            $postulantesArr[]=$item->codActor;
        }
        $postulantes=Actor::whereIn('codActor',$postulantesArr)->get();


        return view('Examenes.Modales.ModalGrupoRespuestasIguales',compact('arr','respuestasProbando','solucionario','grupoPatrones','postulantes','analisis'));
    }



    public function getModalPreguntasDePostulante($codExamenPostulante){
         
        
        $examenPostulante=ExamenPostulante::findOrFail($codExamenPostulante);
        
        $solucionario=Examen::findOrFail($examenPostulante->codExamen)->getStringRespuestas();
        $respuestasProbando=$examenPostulante->respuestasJSON;
        $arr=['clave'=>[],'color'=>[]];
        for ($i=0; $i < strlen($respuestasProbando); $i++) { 
            if(substr($respuestasProbando,$i, 1)=='X'){
                $arr['clave'][]=" ";
            }else{
                $arr['clave'][]=substr($respuestasProbando,$i, 1);
            }
            
            if(substr($respuestasProbando,$i, 1)==substr($solucionario,$i, 1)){
                $arr['color'][]="green";
            }else{
                $arr['color'][]="red";
            }
            
        }
        
        //return $respuestasProbando;

        return view('Examenes.Modales.ModalPreguntasDePostulante',compact('arr','respuestasProbando','solucionario','examenPostulante'));
    }

    public function getModalPostulanteElevado($codPostulanteElevado){

        $postulanteElevado = PostulantesElevados::findOrFail($codPostulanteElevado);
        $anteriorPostulacion = ExamenPostulante::findOrFail($postulanteElevado->codExamenPostulanteAnterior);
        $actualPostulacion = ExamenPostulante::findOrFail($postulanteElevado->codExamenPostulante);

        return view('Examenes.Modales.ModalPostulanteElevado',compact('postulanteElevado','anteriorPostulacion','actualPostulacion'));

    }



    public function VerHistorialPostulante($codExamenPostulante){
        $examenPostulante=ExamenPostulante::findOrFail($codExamenPostulante);
        $postulante = Actor::findOrFail($examenPostulante->codActor);

        $puntajesAPT=[];
        $puntajesCON=[];
        $puntajesTotal=[];
        $periodos=[];
        foreach ($postulante->getPostulacionesAsc() as $item) {
            $puntajesAPT[]=$item->puntajeAPT;
            $puntajesCON[]=$item->puntajeCON;
            $puntajesTotal[]=$item->puntajeTotal;
            $periodos[]=$item->getExamen()->periodo;
        }

        
        return view ('Postulantes.VerPostulante',compact('postulante','puntajesAPT','puntajesCON','puntajesTotal','periodos'));
    }

    public function guardar(Request $request){
        try{
            DB::beginTransaction();

            $empleadoLogeado = Actor::getActorLogeado();  

            $examen = new Examen();
            $examen->año = $request -> año;
            $examen->fechaRendicion = Fecha::formatoParaSQL($request -> fechaRendicion);
            
            $examen->codModalidad= $request -> codModalidad;
            $examen->codSede= $request -> codSede;
            $examen->codEstado= 1;
            $examen->codArea = $request->codArea;
            $examen->periodo = $request->periodo;
            $examen->valoracionPositivaCON = $request->valoracionPositivaCON; 
            $examen->valoracionPositivaAPT = $request->valoracionPositivaAPT; 
            $examen->valoracionNegativaCON = -$request->valoracionNegativaCON; 
            $examen->valoracionNegativaAPT =- $request->valoracionNegativaAPT; 

            
            
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
            $examen->codEstado = 8;
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

    public function analizarExamen($codExamen){
        $examen = Examen::findOrFail($codExamen);
        $examen->generarReporteIrregularidad();
        $examen->codEstado = 6;
        $examen->save();
        return "1";
    }   

    public function IniciarLecturaDatos($codExamen){

        $examen = Examen::findOrFail($codExamen);
        //AnalisisExamen::where('codExamen','=',$codExamen)->delete();
        //GrupoIguales::where('codGrupo','>','0')->delete();
        //ExamenPostulante::where('codExamenPostulante','>','0')->delete();
        //Pregunta::where('codPregunta','>','0')->delete();
        //User::where('codUsuario','>','0')->delete();
        
        
        $examen->procesarArchivoRespuestas();
        $examen->generarCarrerasExamen();

        
        $examen->codEstado = 7;
        $examen->save();
        return "1";

    }
 

    public function PrepararArchivosExamen($codExamen){
        $examen = Examen::findOrFail($codExamen);
        
        $examen->procesarArchivoPreguntas();
        //Pregunta::where('codExamen','=',$examen->codExamen)->delete();


        
        $reporteRespuestas = $examen->generarRespuestasPostulantes();

        $examen->codEstado = 9;
        $examen->save();
        return 1;
    }



    /* 
    En cadena llegan datos
    tipoObservacion + "*" + codigoAObservar + "*" + notaObservacion;
    */
    public function ObservarAlgo($cadena){
        $vector = explode("*",$cadena);
        $tipoObservacion = $vector[0];
        $codigoAObservar = $vector[1];
        $notaObservacion = $vector[2];

        switch($tipoObservacion){
            case "GrupoPatron":
                $codTipoObservacion = 1;
                $elementoAObservar = GrupoPatron::findOrFail($codigoAObservar);
                $stringLlegada = "Patron N°$codigoAObservar de respuestas iguales";
                break;
            case "ExamenesIguales":
                $codTipoObservacion = 2;
                $elementoAObservar = GrupoIguales::findOrFail($codigoAObservar);
                $stringLlegada = "Grupo N°$codigoAObservar de exámenes iguales";
                break;
            case "PostulantesElevados":
                $codTipoObservacion = 3;
                $elementoAObservar = PostulantesElevados::findOrFail($codigoAObservar);
                $nroCarnet = $elementoAObservar->examenActual()->nroCarnet;
                $stringLlegada = "Postulante elevado N°$codigoAObservar (Carnet $nroCarnet)";
                break;
        }

        $observacion = new Observacion();
        $observacion->notaObservacion = $notaObservacion;
        $observacion->codTipoObservacion = $codTipoObservacion;
        $observacion->codAnalisis = $elementoAObservar->codAnalisis;
        $observacion->codEstado = 1;
        $observacion->save();

        $codObservacion = Observacion::All()->last()->codObservacion;
        $elementoAObservar->codObservacion = $codObservacion;
        $elementoAObservar->save();

        $analisis = AnalisisExamen::findOrFail($elementoAObservar->codAnalisis);

        return redirect()->route('Examen.VerReporteIrregularidades',$analisis->codExamen)
            ->with('datos',"$stringLlegada observado exitósamente.");

    }



    //elimina que existió observacion alguna vez
    public function eliminarObservacion($codObservacion){
        $observacion = Observacion::findOrFail($codObservacion);
        //eliminamos el registro de la observacion del elemento que la tenga
        switch($observacion->codTipoObservacion){
            case 1:
                $elementoObservado = GrupoPatron::where('codObservacion','=',$codObservacion)->get()[0];
                break;
            case 2:
                $elementoObservado = GrupoIguales::where('codObservacion','=',$codObservacion)->get()[0];
                break;
            case 3:
                $elementoObservado = PostulantesElevados::where('codObservacion','=',$codObservacion)->get()[0];
                break;
        }
        $elementoObservado->codObservacion = null;
        $elementoObservado->save();

        $analisis = AnalisisExamen::findOrFail($elementoObservado->codAnalisis);
        $stringLlegada = $observacion->codObservacion;
        $observacion->delete();

        return redirect()->route('Examen.VerReporteIrregularidades',$analisis->codExamen)
            ->with('datos',"Se ha cancelado exitosamente la observacion #$stringLlegada.");
    }


    //cambia el estado de una observacion a pasada (ya fue revisada y no tiene nada de malo)
    public function pasarObservacion($codObservacion){

        $observacion = Observacion::findOrFail($codObservacion);
        $observacion->codEstado = 2; 
        $observacion->save();

        
        return redirect()->route('Examen.VerReporteIrregularidades',$observacion->getAnalisis()->codExamen)
            ->with('datos',"Se ha pasado exitosamente la observacion #".$codObservacion);
    }

    //camb

    public function anularExamenesObservacion($codObservacion){
        $observacion = Observacion::findOrFail($codObservacion);
        $analisis = $observacion->getAnalisis();
        $examen = $analisis->getExamen();
        $periodo = $examen->periodo;

        $observacion->codEstado = 3; 
        $observacion->save();

        MaracsoftBot::enviarMensaje("Se ha anulado los exámenes correspondientes a la observación N° $codObservacion del examen $periodo");

        // ESTE CODIGO YA NO SE EJECUTA EN PHP, SINO EN EL TRIGGER AnularExamenesObservacion
        
        //ahora anulamos las postulaciones vinculadas
        /* switch($observacion->codTipoObservacion){
            case 1: 
                $elementoObservado = GrupoPatron::where('codObservacion','=',$codObservacion)->get()[0];
                $vector = explode(',',$elementoObservado->vectorExamenPostulante);
                $postulaciones = ExamenPostulante::whereIn('codExamenPostulante',$vector)->get();
                break;
            case 2:
                $elementoObservado = GrupoIguales::where('codObservacion','=',$codObservacion)->get()[0];
                $vector = explode(',',$elementoObservado->vectorExamenPostulante);
                $postulaciones = ExamenPostulante::whereIn('codExamenPostulante',$vector)->get();
                break;
            case 3:
                $elementoObservado = PostulantesElevados::where('codObservacion','=',$codObservacion)->get()[0];
                $postulaciones = ExamenPostulante::where('codExamenPostulante','=',$elementoObservado->codExamenPostulante)->get();
                break;
        }

        //anulamos todos los que tengamos que anular 
        foreach($postulaciones as $postulacion){
            $postulacion->codCondicion = 6; //ANULADO EN POST ANALISIS
            $postulacion->save();
        }
 */
        return redirect()->route('Examen.VerReporteIrregularidades',$observacion->getAnalisis()->codExamen)
            ->with('datos',"Se ha anulado exitosamente los exámenes correspondientes a la observacion #".$codObservacion);
    }

    public function VerPDF($codExamen){
        $examen = Examen::findOrFail($codExamen);
        $nombreDescarga = "Examen Admisión UNT ".$examen->getModalidad()->nombre." ".$examen->getArea()->area." ".$examen->periodo.".pdf";
         
        return redirect("/examenes/".$examen->getNombreArchivoExamenEscaneado());
        
    }
    
    
    //se le pasa el codigo del archivo 
    function descargarPDF($codExamen){
        $examen = Examen::findOrFail($codExamen);
        $nombreDescarga = "Examen Admisión UNT ".$examen->getModalidad()->nombre." ".$examen->getArea()->area." ".$examen->periodo.".pdf";
         

        //                  no hay error xd
        return Storage::disk('examenes')->download($examen->getNombreArchivoExamenEscaneado(),$nombreDescarga);
        

    }

    //REPORTE PDF DE IRREGULARIDADES
    public function ExportarPDF($id){
        $estados=EstadoExamen::whereIn('codEstado',[4,5])->get();
        $examen=Examen::findOrFail($id);
        $analisis = AnalisisExamen::where('codExamen','=',$id)->get()[0];

        //para las 3 tablas
        $gruposIguales=GrupoIguales::where('codAnalisis','=',$analisis->codAnalisis)->get();
        $gruposPatron=GrupoPatron::where('codAnalisis','=',$analisis->codAnalisis)->get();
        $postulantesElevados=PostulantesElevados::where('codAnalisis','=',$analisis->codAnalisis)->get();

   


        $data = [
            'estados'=>$estados,
            'examen'=>$examen,
            'analisis'=>$analisis,
            'gruposIguales'=>$gruposIguales,
            'gruposPatron'=>$gruposPatron,
            'postulantesElevados'=>$postulantesElevados
        ];
    
        $pdf = PDF::loadView('Examenes.ReporteIrregularidadesPDF', $data)->setPaper('a4', 'portrait');

        return $pdf->download('Reporte de Irregularidades.pdf');
    }
    


}
