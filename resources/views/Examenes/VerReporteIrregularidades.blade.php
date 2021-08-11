@extends('Layout.Plantilla')
@section('titulo')
    Reporte de Irregularidades
@endsection

@section('contenido')
<br>
@include('Layout.MensajeEmergenteDatos')
<div class="card">
    <!--
    <div class="card-header border-0">
        <div class="d-flex justify-content-between">
        <h3 class="card-title">Sales</h3>
        <a href="javascript:void(0);">View Report</a>
        </div>
    </div>
    -->

    <div class="card-body">
        <div class="d-flex">
            <div class="row">
                <div class="col-1">
                    <label class="" style="margin-top: 6px" >Año:</label>
                </div>  
                <div class="col-2">    
                    <div class="">
                        <input type="text" class="form-control"  
                            value="{{$examen->año}}"  readonly>
                    </div>
                </div>
                <div class="col-1">
                    <label class="" style="margin-top: 6px" >Fecha:</label>
                </div>  
                <div class="col-2">    
                    <div class="">
                        <input type="text" class="form-control"  
                            value="{{$examen->fechaRendicion}}"  readonly>
                    </div>
                </div>
                <div class="col-1">
                    <label class="" style="margin-top: 6px" >Asistentes:</label>
                </div>  
                <div class="col-2">    
                    <div class="">
                        <input type="text" class="form-control"  
                            value="{{$examen->asistentes}}"  readonly>
                    </div>
                </div>
                <div class="col">    
                    <a href="{{route("Examen.ReporteIrregularidadesPDF",$examen->codExamen)}}" class='btn btn-success float-right' style="margin-left: 5px">
                        <i class="fas fa-file-download"></i> Reporte
                    </a>
                </div>

                <div class="w-100"> <br> </div>

                <div class="col-1">
                    <label class="" style="margin-top: 6px" >Modalidad:</label>
                </div>  
                <div class="col-2">    
                    <div class="">
                        <input type="text" class="form-control"  
                            value="{{$examen->getModalidad()->nombre}}"  readonly>
                    </div>
                </div>
                <div class="col-1">
                    <label class="" style="margin-top: 6px" >#Vacantes:</label>
                </div>  
                <div class="col-2">    
                    <div class="">
                        <input type="text" class="form-control"  
                            value="{{$examen->nroVacantes}}"  readonly>
                    </div>
                </div>
                <div class="col-1">
                    <label class="" style="margin-top: 6px" >Ausentes:</label>
                </div>  
                <div class="col-2">    
                    <div class="">
                        <input type="text" class="form-control"  
                            value="{{$examen->ausentes}}"  readonly>
                    </div>
                </div>
                

                <div class="w-100"> <br> </div>

                <div class="col-1">
                    <label class="" style="margin-top: 6px" >Área:</label>
                </div>  
                <div class="col-2">    
                    <div class="">
                        <input type="text" class="form-control"  
                            value="{{$examen->getArea()->area}}"  readonly>
                    </div>
                </div>
                <div class="col-1">
                    <label class="" style="margin-top: 6px" >#Postulantes:</label>
                </div>  
                <div class="col-2">    
                    <div class="">
                        <input type="text" class="form-control"  
                            value="{{$examen->nroPostulantes}}"  readonly>
                    </div>
                </div>
                <div class="col-1">
                    <label class="" style="line-height : 15px;">Tasa Ausentismo:</label>
                </div>  
                <div class="col-2">    
                    <div class="">
                        <input type="text" class="form-control"  
                            value="{{$examen->ausentes/$examen->nroPostulantes}} %"  readonly>
                    </div>
                </div>
                <div class="col">    
                    <a href="{{route('Examen.descargarPDF',$examen->codExamen)}}" class='btn btn-success float-right' style="margin-left: 5px">
                        <i class="fas fa-file-download"></i> Bajar Examen
                    </a>
                    <a target="blank-1"  href="{{route('Examen.VerPDF',$examen->codExamen)}}" class='btn btn-success float-right'>
                        <i class="fas fa-file-pdf"></i> Ver Examen
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <div class="contanier">
                    <h5 style="text-align: center; font-weight: bold">GRUPO DE EXÁMENES EXACTAMENTE IGUALES</h5>
                    <div class="card-body">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="pieGruposIguales" style="min-height: 190px; height: 190px; max-height: 250px; max-width: 100%; display: block; width: 604px;" width="604" height="190" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
                <div class="contanier">
                    <h5 style="text-align: center; font-weight: bold">ALUMNOS CON CRECIMIENTO ANORMAL DE PUNTAJES</h5>
                    <div class="card-body">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="piePostulantesElevados" style="min-height: 190px; height: 190px; max-height: 190px; max-width: 100%; display: block; width: 604px;" width="604" height="190" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="contanier">
                    <h5 style="text-align: center; font-weight: bold">PATRONES COINCIDENTES DE RESPUESTAS DE PREGUNTAS</h5>
                    <div class="card-body">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="pieGruposPatron" style="min-height: 190px; height: 190px; max-height: 190px; max-width: 100%; display: block; width: 604px;" width="604" height="190" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
                <div class="contanier">
                    <br><br><br>
                    <h5 style="text-align: center; font-weight: bold">TASA DE IRREGULARIDAD DE LOS RESULTADOS</h5>
                    <h1 style="text-align: center; color: red; font-weight: bold">{{$analisis->tasaIrregularidad*100}}%</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header border-1">
        <div class="d-flex justify-content-between">
            <h3 class="card-title">GRUPO DE EXAMENES EXACTAMENTE IGUALES:</h3>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>Grupo</th>
                    <th>Cantidad de estudiantes</th>
                    <th>Puntaje AP</th>
                    <th>Puntaje CON</th>
                    <th>Total</th>
                    <th>Ver</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gruposIguales as $itemGrupo)
                <tr>
                    <td>{{$itemGrupo->identificador()}}</td>
                    <td>{{$itemGrupo->cantidadPostulantes()}}</td>
                    <td>{{$itemGrupo->puntajeAP}}</td>
                    <td>{{$itemGrupo->puntajeCON}}</td>
                    <td>{{$itemGrupo->puntajeAP+$itemGrupo->puntajeCON}}</td>
                    <td>
                        <button type="button" id="" class="btn btn-info btn-sm" onclick="actualizarModalExamenesIguales({{$itemGrupo->codGrupo}})"
                            data-toggle="modal" data-target="#ModalExamenesIguales"><i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
                <!--
                <tr>
                    <td>0001</td>
                    <td>15</td>
                    <td>170.005</td>
                    <td>20.001</td>
                    <td>220.006</td>
                    <td>
                        <button type="button" id="" class="btn btn-info btn-sm" onclick="actualizarModalExamenesIguales(1)"
                            data-toggle="modal" data-target="#ModalExamenesIguales"><i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
            -->
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header border-1">
        <div class="d-flex justify-content-between">
            <h3 class="card-title">PATRONES COINCIDENTES DE RESPUESTAS DE PREGUNTAS:</h3>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead class="thead-dark">
                <tr>
                    <th width="7%">Patron ID</th>
                    <th width="10%"># Estudiantes</th>
                    <th width="10%"># Preguntas</th>
                    <th>Detalle</th>
                    <th width="5%">Ver</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gruposPatron as $itemGrupo)
                <tr>
                    <td>{{$itemGrupo->identificador()}}</td>
                    <td>{{$itemGrupo->cantidadPostulantes()}}</td>
                    <td>{{$itemGrupo->nroCorrectas+$itemGrupo->nroIncorrectas}}</td>
                    <td>{{$itemGrupo->respuestasResumen()}}</td>
                    <td>
                        <button type="button" id="" class="btn btn-info btn-sm" onclick="actualizarModalGrupoRespuestasIguales({{$itemGrupo->codGrupoPatron}})"
                            data-toggle="modal" data-target="#ModalGrupoRespuestasIguales"><i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
                <!--
                <tr>
                    <td>0001</td>
                    <td>15</td>
                    <td>70</td>
                    <td>1A;2B;3A;4B;5A;...</td>
                    <td>
                        <button type="button" id="" class="btn btn-info btn-sm" onclick="actualizarModalGrupoRespuestasIguales(1)"
                            data-toggle="modal" data-target="#ModalGrupoRespuestasIguales"><i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
                -->
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header border-1">
        <div class="d-flex justify-content-between">
            <h3 class="card-title">ALUMNOS CON CRECIMIENTO ANORMAL DE PUNTAJES:</h3>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Código Postulante</th>
                    <th>Carrera</th>
                    <th>Puntaje Anterior</th>
                    <th>Puntaje Actual</th>
                    <th>Historial</th>
                    <th>Preguntas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($postulantesElevados as $itemPostulante)
                <tr>
                    <td>{{$itemPostulante->postulante()->apellidosYnombres}}</td>
                    <td>{{$itemPostulante->postulante()->codUsuario}}</td>
                    <td>{{$itemPostulante->examenActual()->getCarrera()->nombre}}</td>
                    <td>{{$itemPostulante->examenAnterior()->puntajeTotal}}</td>
                    <td>{{$itemPostulante->examenActual()->puntajeTotal}}</td>
                    <td>
                        <a href="{{route("Examen.VerReporteIrregularidades.VerHistorialPostulante",$itemPostulante->codExamenPostulante)}}" class="btn btn-warning btn-sm" title="Ver Reposición"><i class="fas fa-eye"></i></a>
                    </td>
                    <td>
                        <button type="button" id="" class="btn btn-info btn-sm" onclick="actualizarModalPreguntasDePostulante({{$itemPostulante->codExamenPostulante}},{{$itemPostulante->postulante()->codUsuario}})"
                            data-toggle="modal" data-target="#ModalPreguntasDePostulante"><i class="fas fa-list-ol"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<a href="{{route("Examen.Director.Listar")}}" class='btn btn-info'>
    <i class="fas fa-arrow-left"></i> 
    Regresar al Menú
</a>
@if($examen->codEstado!=4 && $examen->codEstado!=5 && App\Actor::esConsejoUniversitario())
<button type="button" id="" class="btn btn-danger float-right"
    data-toggle="modal" data-target="#ModalConfirmacion"><i class="fas fa-exclamation-triangle"></i> Registrar decision del CU
</button>    
@endif

<br><br>



{{-- MODALE DE EXAMENES IGUALES --}}
<div class="modal fade" id="ModalExamenesIguales" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleExamenesIguales"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="BodyExamenesIguales"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODALE DE GRUPOS CON RESPUESTAS IGUALES --}}
<div class="modal fade" id="ModalGrupoRespuestasIguales" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleGrupoRespuestasIguales"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="BodyGrupoRespuestasIguales"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODALE DE PREGUNTAS DE UN POSTULANTE --}}
<div class="modal fade" id="ModalPreguntasDePostulante" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitlePreguntasDePostulante"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="BodyPreguntasDePostulante"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>



{{-- MODALE DE CONFIRMACION --}}
<div class="modal fade" id="ModalConfirmacion" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            

                <div class="modal-header">
                    <h5 class="modal-title" id="">Cambiar estado del examen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <h3 class="profile-username text-center" style="font-weight: bold">Decisión final de Consejo Universitario</h3>
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="../../img/usuario.png" alt="User profile picture">
                        </div>
                        <br>
                        <form id="formAprobar" name="formAprobar" action="{{route("Examen.Consejo.aprobarExamen")}}" method="POST">
                            @csrf
                            <input type="hidden" name="codExamen" id="codExamen" value="{{$examen->codExamen}}">
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Contraseña" id="contraseña" name="contraseña">
                                <!--
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                -->
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Repetir contraseña"  id="contraseña2" name="contraseña2">
                                <!--
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                -->
                            </div>
                            <div class="input-group mb-3">
                                <p class="" style="margin-bottom: 0" >Nuevo Estado: </p>
                                <div class="w-100"></div>
                                <select class="form-control" name="codEstado" id="codEstado">
                                    @foreach($estados as $item)
                                    <option value="{{$item->codEstado}}">{{$item->descripcion}}</option>    
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>

                    <button type="button" class="m-1 btn btn-success" onclick="clickAprobarExamen()">
                        <i class="fas fa-save"></i> Guardar
                    </button>   
                </div>
            
        </div>
    </div>
</div>

@endsection
@include('Layout.ValidatorJS')
@section('script')
<script>
    function clickAprobarExamen(){
        msje = validar();
        if(msje!="")
            {
                alerta(msje);
                return false;
            }
        
        confirmar('¿Seguro de actualizar el estado del examen?','info','formAprobar');
        
    }
    function validar(){ //Retorna TRUE si es que todo esta OK y se puede hacer el submit
        contraseñaDelConsejo="Consejo";
        msj='';
        
        limpiarEstilos(['contraseña','contraseña2']);
        msj = validarTamañoMaximoYNulidad(msj,'contraseña',200,'Nueva Contraseña');
        msj = validarTamañoMaximoYNulidad(msj,'contraseña2',200,'Repetir Nueva Contraseña');
        msj = validarContenidosIguales(msj,'contraseña','contraseña2','Las contraseñas nuevas deben coincidir');
        /*
        contra = document.getElementById('contraseña').value;
        if(contra!=contraseñaDelConsejo && msj==''){
            console.log(contra);
            msj='CONTRASEÑA ERRONEA';
        }
        */
        return msj;
    }



    function completarZeros(num,cantidadZeros) {
        return "0".repeat(cantidadZeros-num.toString().length)+''+num;
    }

    function limpiarModal(TitleName,BodyName){
        document.getElementById(TitleName).innerHTML="";
        document.getElementById(BodyName).innerHTML="";
    }


    function obtenerModal(Ruta,BodyName){
        $.get(Ruta, function(data){
                console.log("Mostrar Modal de ruta: "+Ruta);                  
                document.getElementById(BodyName).innerHTML = data;
            }
        );
    }

    function actualizarModalExamenesIguales(codGrupo){
        limpiarModal('TitleExamenesIguales','BodyExamenesIguales');

        document.getElementById('TitleExamenesIguales').innerHTML="Grupo "+completarZeros(codGrupo,4)+" - Exactamente Iguales";
        obtenerModal('/Examen/VerReporteIrregularidades/'+codGrupo+'/ModalExamenesIguales','BodyExamenesIguales');
    }
    function actualizarModalGrupoRespuestasIguales(codGrupo){
        limpiarModal('TitleGrupoRespuestasIguales','BodyGrupoRespuestasIguales');

        document.getElementById('TitleGrupoRespuestasIguales').innerHTML="Patron "+completarZeros(codGrupo,4)+" - Grupo de respuestas iguales";
        obtenerModal('/Examen/VerReporteIrregularidades/'+codGrupo+'/ModalGrupoRespuestasIguales','BodyGrupoRespuestasIguales');
    }


    function actualizarModalPreguntasDePostulante(codExamenPostulante,codUsuario){
        limpiarModal('TitlePreguntasDePostulante','BodyPreguntasDePostulante');

        document.getElementById('TitlePreguntasDePostulante').innerHTML="Preguntas respondidas - Postulante "+completarZeros(codUsuario,7)+" - Examen {{$examen->getModalidad()->nombre}} {{$examen->periodo}}";
        obtenerModal('/Examen/VerReporteIrregularidades/'+codExamenPostulante+'/ModalPreguntasDePostulante','BodyPreguntasDePostulante');
        
    }
</script>
<script src="../../plugins/chart.js/Chart.min.js"></script>
<script type="text/javascript">
    //console.log(<?php echo json_encode($piePostulantesElevados); ?>);
    $(function () {
        //-------------
        //- PIE CHART -
        //-------------
        var pieDataGruposIguales        = {
            labels: <?php echo json_encode($pieGruposIguales['labels']); ?>,
            datasets: [
                {
                    data: <?php echo json_encode($pieGruposIguales['value']); ?>,
                    backgroundColor : <?php echo json_encode($pieGruposIguales['color']); ?>,
                }
            ]
        }
        var pieDataGruposPatron        = {
            labels: <?php echo json_encode($pieGruposPatron['labels']); ?>,
            datasets: [
                {
                    data: <?php echo json_encode($pieGruposPatron['value']); ?>,
                    backgroundColor : <?php echo json_encode($pieGruposPatron['color']); ?>,
                }
            ]
        }
        var pieDataPostulantesElevados        = {
            labels: <?php echo json_encode($piePostulantesElevados['labels']); ?>,
            datasets: [
                {
                    data: <?php echo json_encode($piePostulantesElevados['value']); ?>,
                    backgroundColor : <?php echo json_encode($piePostulantesElevados['color']); ?>,
                }
            ]
        }

        var pieOptions     = {
            maintainAspectRatio : false,
            responsive : true,
            legend: {
                display: false
            },
        }

        var pieGruposIguales = $('#pieGruposIguales').get(0).getContext('2d')
        var pieGruposPatron = $('#pieGruposPatron').get(0).getContext('2d')
        var piePostulantesElevados = $('#piePostulantesElevados').get(0).getContext('2d')

        new Chart(pieGruposIguales, {
            type: 'pie',
            data: pieDataGruposIguales,
            options: pieOptions
        })
        new Chart(pieGruposPatron, {
            type: 'pie',
            data: pieDataGruposPatron,
            options: pieOptions
        })
        new Chart(piePostulantesElevados, {
            type: 'pie',
            data: pieDataPostulantesElevados,
            options: pieOptions
        })
    })
  </script>

@endsection