{{-- ESTA VISTA SIRVE TANTO COMO PARA VER EL PERFIL DESDE AFUERA COMO PARA VER MI PERFIL PROPIO --}}


@extends('Layout.Plantilla')
@section('titulo')
    Perfil de {{$postulante->apellidosYnombres}}
@endsection

@section('estilos')
<style>
    th,td{
        text-align: center;
    }

</style>
@endsection
@section('contenido')
<br>

<div class="card">
    
    <div class="card-body">
        <div class="row">
            <div class="col-1">
                <label class="" style="margin-top: 6px" >Nombres:</label>
            </div>  
            <div class="col">    
                <div class="">
                    <input type="text" class="form-control"  
                        value="{{$postulante->apellidosYnombres}}"  readonly>
                </div>
            </div>
            <div class="col-1">
                <label class="" style="margin-top: 6px;line-height : 15px">Última condición:</label>
            </div>  
            <div class="col-2">    
                <div class="">
                    <input type="text" class="form-control"  
                        value="{{$postulante->getCondicionActual()}}"  readonly>
                </div>
            </div>
            <div class="col-1">
                <label class="" style="margin-top: 6px;line-height : 15px" >Carrera más postulada:</label>
            </div>  
            <div class="col-2">    
                <div class="">
                    <input type="text" class="form-control"  
                        value="{{$postulante->getCarreraMásPostulada()->nombre}}"  readonly>
                </div>
            </div>
            <div class="col-1">
                <label class="" style="margin-top: 6px;line-height : 15px" >Puntaje Promedio:</label>
            </div>  
            <div class="col-1">    
                <div class="">
                    <input type="text" class="form-control"  
                        value="{{$postulante->getPuntajePromedio()}}"  readonly>
                </div>
            </div>
        </div>


    </div>
</div>


<div class="card">
    <div class="card-header border-1">
        <div class="d-flex justify-content-between">
            <h3 class="card-title">Mis Exámenes</h3>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Periodo</th>
                    <th>Modalidad</th>
                    <th>Fecha Rend</th>
                    <th>#Marcadas</th>

                    <th>#Correctas</th>
                    <th>#Incorrectas</th>
                    
                    <th>Ptje APT</th>
                    <th>Ptje CON</th>
                    <th>Ptje Total</th>
                    <th>Ptje Min ingresante</th>
                    <th>Escuela</th>
                    <th>Condición</th>
                    <th>Ver</th>
                </tr>
            </thead>
            <tbody>
                @foreach($postulante->getPostulaciones() as $postulacion)
                    <tr>
                        <td>
                            <a class="btn btn-sm btn-success" href="{{route('Examen.VerPostulantes',$postulacion->codExamen)}}">

                                {{$postulacion->getExamen()->periodo}}
                            </a>
                        </td>
                        <td>
                            {{$postulacion->getExamen()->getModalidad()->nombre}}
                        </td>
                        <td>
                            {{$postulacion->getExamen()->getFechaRendicion()}}
                        </td>
                        <td>
                            {{$postulacion->getCantidadRespuestasMarcadas()}}
                        </td>
                        <td>
                            {{$postulacion->nroCorrectas}}
                        </td>
                        
                        <td>
                            {{$postulacion->nroIncorrectas}}
                        </td>
                        

                        <td>
                            {{number_format($postulacion->puntajeAPT,3)}}
                        </td>
                        <td>
                            {{number_format($postulacion->puntajeCON,3)}}
                        </td>
                        <td>
                            {{number_format($postulacion->puntajeTotal,3)}}
                        </td>

                        <td>
                            {{number_format($postulacion->getCarreraExamen()->puntajeMinimoPostulante,3)}}
                        </td>

                        <td>
                            {{$postulacion->getCarrera()->nombre}}

                        </td>
                        <td>
                            {{$postulacion->getCondicion()->nombre}}
                        </td>

                        <td>
                            {{-- ABRE EL MODAL PARA VER LAS RESPUESTAS --}}
                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#ModalPreguntasDePostulante" 
                                onclick="actualizarModalPreguntasDePostulante({{$postulacion->codExamenPostulante}},'{{$postulacion->getActor()->apellidosYnombres}}')">
                                Ver respuestas
                            </button>
                        </td>

                    </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header border-1">
        <div class="d-flex justify-content-between">
            <h3 class="card-title"> Mis puntajes:</h3>
        </div>
    </div>
    <div class="card-body">
        <div class="container">
            <div class="card-body">
                <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                  <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 604px;" width="604" height="250" class="chartjs-render-monitor"></canvas>
                </div>
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









<!--
<a href="#" class='btn btn-info'>
    <i class="fas fa-arrow-left"></i> 
    Regresar al Menu
</a>
<br><br>-->
@endsection

@section('script')
<script src="../../plugins/chart.js/Chart.min.js"></script>
<script>

     
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
    


    function actualizarModalPreguntasDePostulante(codExamenPostulante,nombre){
        limpiarModal('TitlePreguntasDePostulante','BodyPreguntasDePostulante');


        obtenerModal('/Examen/VerReporteIrregularidades/'+codExamenPostulante+'/ModalPreguntasDePostulante','BodyPreguntasDePostulante');
        document.getElementById('TitlePreguntasDePostulante').innerHTML = "Respuestas del postulante " +nombre;
    }



</script>
<script>

    $(function () {
      /* ChartJS
       * -------
       * Here we will create a few charts using ChartJS
       */
  
      //--------------
      //- AREA CHART -
      //--------------
  
      // Get context with jQuery - using jQuery's .get() method.
      //var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
  
      var areaChartData = {
        labels  : @php
        echo json_encode($periodos);
        @endphp,
        datasets: [
          {
            label               : 'Puntaje APT',
            backgroundColor     : 'rgba(100,190,200,0.9)',
            borderColor         : 'rgba(100,190,200,0.8)',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(100,190,200,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(100,190,200,1)',
            data                : <?php echo json_encode($puntajesAPT); ?>
          },
          {
            label               : 'Puntaje CON',
            backgroundColor     : 'rgba(60,141,188,0.9)',
            borderColor         : 'rgba(60,141,188,0.8)',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : <?php echo json_encode($puntajesCON); ?>
          },
          {
            label               : 'Puntaje Total',
            backgroundColor     : 'rgba(210, 214, 222, 1)',
            borderColor         : 'rgba(210, 214, 222, 1)',
            pointRadius         : false,
            pointColor          : 'rgba(210, 214, 222, 1)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data                : <?php echo json_encode($puntajesTotal); ?>
          },
        ]
      }
  
      var areaChartOptions = {
        maintainAspectRatio : false,
        responsive : true,
        legend: {
          display: true
        },
        scales: {
          xAxes: [{
            gridLines : {
              display : false,
            }
          }],
          yAxes: [{
            gridLines : {
              display : false,
            }
          }]
        }
      }
  
      // This will get the first returned node in the jQuery collection.
      /*
      new Chart(areaChartCanvas, {
        type: 'line',
        data: areaChartData,
        options: areaChartOptions
      })s
      */
      //-------------
      //- LINE CHART -
      //--------------
      var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
      var lineChartOptions = $.extend(true, {}, areaChartOptions)
      var lineChartData = $.extend(true, {}, areaChartData)
      lineChartData.datasets[0].fill = false;
      lineChartData.datasets[1].fill = false;
      lineChartData.datasets[2].fill = false;
      lineChartOptions.datasetFill = false
  
      var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: lineChartData,
        options: lineChartOptions
      })
  
   
    })
  </script>

@endsection