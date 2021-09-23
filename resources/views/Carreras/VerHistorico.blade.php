@extends('Layout.Plantilla')
@section('titulo')
    Histórico de Carrera
@endsection

@section('contenido')
<br>

<div class="card">
    <div class="card-header border-1">
        <div class="d-flex justify-content-between">
            <h3 class="card-title">PUNTAJES DE CADA CARRERA:</h3>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Escuela</th>
                    <th>Área</th>
                    <th>Facultad</th>
                    <th>Histórico</th>
                </tr>
            </thead>
            <tbody>
              @foreach($carreras as $itemCarrera)
              <tr>
                <td>{{$itemCarrera->nombre}}</td>
                <td>{{$itemCarrera->getArea()->descripcion}}</td>
                <td>{{$itemCarrera->getFacultad()->nombre}}</td>
                <td>
                    <a href="{{route('CarreraExamen.actualizarHistorico',$itemCarrera->codCarrera)}}" class="btn btn-info btn-sm" title="Ver Reposición">Ver histórico</a>
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
            <h3 class="card-title">HISTÓRICO DE {{strtoupper($carreraSelected->nombre)}}:</h3>
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
        <div class="container">
            <table class="table table-sm table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Puntaje Aprobatorio</th>
                        <th>Puntaje Mínimo Ingresante</th>
                        <th>Puntaje Mayor</th>
                        <th>Fecha Examen</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($examenesCarrera as $itemExamen)
                    <tr>
                      <td>{{$itemExamen->puntajeMinimoPermitido}}</td>
                      <td>{{$itemExamen->puntajeMinimoPostulante}}</td>
                      <td>{{$itemExamen->puntajeMaximoPostulante}}</td>
                      <td>{{$itemExamen->periodo}}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
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
    //console.log(<?php echo json_encode($puntajesMinimoPermitido); ?>);

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
        labels  : <?php echo json_encode($periodos); ?>,
        datasets: [
          {
            label               : 'Puntaje Aprobatorio',
            backgroundColor     : 'rgba(100,190,200,0.9)',
            borderColor         : 'rgba(100,190,200,0.8)',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(100,190,200,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(100,190,200,1)',
            data                : <?php echo json_encode($puntajesMinimoPermitido); ?>
          },
          {
            label               : 'Puntaje Minimo',
            backgroundColor     : 'rgba(60,141,188,0.9)',
            borderColor         : 'rgba(60,141,188,0.8)',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : <?php echo json_encode($puntajesMinimoPostulante); ?>
          },
          {
            label               : 'Puntaje Maximo',
            backgroundColor     : 'rgba(210, 214, 222, 1)',
            borderColor         : 'rgba(210, 214, 222, 1)',
            pointRadius         : false,
            pointColor          : 'rgba(210, 214, 222, 1)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data                : <?php echo json_encode($puntajesMaximoPostulante); ?>
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
      })
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