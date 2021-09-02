
@extends ('Layout.Plantilla')
@section('titulo')
  Listar exámenes
@endsection

@section('tiempoEspera')
  <div class="loader text-center" id="pantallaCarga">
    <br>
    <br><br><br><br><br><br><br><br>
    <h1 id="tituloCargando">Cargando página</h1>
  </div>
@endsection

@php
  $esDirectorAdmision = App\Actor::esDirectorAdmision();
@endphp

@section('contenido')
<style>
  .col{
    margin-top: 15px;

    }

  .colLabel{
    width: 13%;
    margin-top: 18px;


  }


</style>



<div style="text-align: center">
  <h2> Listar exámenes </h2>
  


  <br>
    @if(App\Actor::hayActorLogeado())
      
      @if(App\Actor::getActorLogeado()->esDirectorAdmision())
        
      <div class="row">
        <div class="col-md-2">
          <a href="{{route('Examen.Director.Crear')}}" class = "btn btn-primary" style="margin-bottom: 5px;"> 
            <i class="fas fa-plus"> </i> 
              Registrar examen
          </a>
        </div>

        @endif

    @endif
 {{-- 

      <a href="/borrarTodo" class = "btn btn-danger" style="margin-bottom: 5px;"> 
        <i class="fas fa-trash"> </i> 
          Borrar datos de exámenes y análisis
      </a>   --}}

      

{{-- 
      <div class="col-md-10">
        <form class="form-inline float-right">

          <label style="" for="">
            Fecha:
            
          </label>

          <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker"  style="width: 140px">
            <input type="text"  class="form-control" name="fechaInicio" id="fechaInicio" style="text-align: center"
                   value="{{$fechaInicio==null ? Carbon\Carbon::now()->format('d/m/Y') : $fechaInicio}}" style="text-align:center;font-size: 10pt;">
            <div class="input-group-btn">                                        
                <button class="btn btn-primary date-set" type="button"><i class="fa fa-calendar"></i></button>
            </div>
          </div>
           - 
          <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker"  style="width: 140px">
            <input type="text"  class="form-control" name="fechaFin" id="fechaFin" style="text-align: center"
                   value="{{$fechaFin==null ? Carbon\Carbon::now()->format('d/m/Y') : $fechaFin}}" style="text-align:center;font-size: 10pt;">
            <div class="input-group-btn">                                        
                <button class="btn btn-primary date-set" type="button"><i class="fa fa-calendar"></i></button>
            </div>
          </div>


          <button class="btn btn-success " type="submit">Buscar</button>
        </form>
      </div>
       --}}
    </div>
    


    @include('Layout.MensajeEmergenteDatos')
      
    <table class="table table-sm" style="font-size: 10pt; margin-top:10px;">
      <thead class="thead-dark">
        <tr>
          <th>Periodo</th>
          <th>Fecha Rendición</th>
          <th>Modalidad</th>
          <th>Nro Postulantes</th>
          <th>Sede</th>

          @if($esDirectorAdmision)
              <th>Estado</th>
              
          @endif
          
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        
        @foreach($listaExamenes as $itemExamen)
            <tr>
                
              <td>
                {{$itemExamen->periodo}}
              </td>
              <td>
                {{$itemExamen->getFechaRendicion()}}
              </td>
              <td>
                {{$itemExamen->getModalidad()->nombre}}
              </td>
              <td>
                {{$itemExamen->nroPostulantes}}

              </td>
              <td>
                {{$itemExamen->getSede()->nombre}}
              </td>
             
 
              @if($esDirectorAdmision)
                <td>
                  {{$itemExamen->getEstado()->descripcion}}
                </td>
              @endif
                              
                <td>

                  
                    @if($itemExamen->tieneResultados())
                      <a class="btn btn-success btn-sm" href="{{route('Examen.VerPostulantes',$itemExamen->codExamen)}}">
                        Ver postulantes
                      </a>
                    @endif

                  @if($esDirectorAdmision)
                    
                    @if($itemExamen->verificarEstado('Creado'))
                        <a class="btn btn-success btn-sm" href="{{route('Examen.Director.VerCargar',$itemExamen->codExamen)}}">
                            Cargar resultados
                        </a>
                    @endif

                    @if($itemExamen->verificarEstado('Archivos Cargados'))
                      <a onclick="clickPrepararArchivos({{$itemExamen->codExamen}})"  href="#" class="btn btn-success" >
                        <i class="fas"></i>
                            Preparar Archivos
                      </a>
                    @endif


                    @if($itemExamen->verificarEstado('Archivos Preparados'))
                      <button type="button" onclick="clickLeerDatos({{$itemExamen->codExamen}})" class="btn btn-success btn-sm" href="">
                        Leer Datos
                      </button>
                    @endif
                    

                    @if($itemExamen->verificarEstado('Datos Insertados'))
                        <button type="button" onclick="clickIniciarAnalisis({{$itemExamen->codExamen}})" class="btn btn-success btn-sm" href="">
                          Iniciar análisis
                        </button>
                    @endif
                        
                      
                    @if($itemExamen->tieneAnalisis())
                      <a class="btn btn-info btn-sm" href="{{route('Examen.VerReporteIrregularidades',$itemExamen->codExamen)}}">
                        Reporte Irregularidades
                      </a>
                    @endif
                  @endif
                   

                </td>
              
            </tr>
        @endforeach
      </tbody>
    </table>
    {{$listaExamenes->appends(
      ['fechaInicio'=>$fechaInicio, 
      'fechaFin'=>$fechaFin]
                      )
      ->links()
    }}
</div>
@endsection



@section('script')
<script>
    
    $(window).load(function(){
        
        //$(".loader").fadeOut("slow");
        //$(".loader").show();  //para mostrar la pantalla de carga

        $(".loader").hide();  //para mostrar la pantalla de carga

    });

    codExamenAProcesar = "";
    function clickIniciarAnalisis(codExamen){
        codExamenAProcesar = codExamen;
        confirmarConMensaje("Confirmar","¿Desea iniciar el análisis de datos del examen? Esto podría tardar","warning",iniciarAnalisis);
    }
    function iniciarAnalisis(){
      procesarAlgo('/Examen/'+codExamenAProcesar+'/Director/analizarExamen',
          "Analizando examen...",
          "Examen procesado exitosamente",
          "Ha ocurrido un error inesperado en el análisis.")

    }



    function clickLeerDatos(codExamen){
        codExamenAProcesar = codExamen;
        confirmarConMensaje("Confirmar","¿Desea iniciar la lectura de datos del examen? Esto podría tardar","warning",iniciarLectura);

    }
    function iniciarLectura(){
        procesarAlgo('/Examen/'+codExamenAProcesar+'/Director/IniciarLecturaDatos',
              "Leyendo datos de los postulantes...",
              "Lectura de datos finalizada exitosamente",
              "Ha ocurrido un error en la lectura de datos");
    }


    
    function clickPrepararArchivos(codExamen){
        codExamenAProcesar = codExamen;
        confirmarConMensaje("Confirmar","¿Desea preparar los archivos para la lectura de datos? Esto podría tardar","warning",prepararArchivos);

    }

    function prepararArchivos(){
      procesarAlgo('/Examen/'+codExamenAProcesar+'/Director/PrepararArchivosExamen',
              "Preparando archivos para la lectura...",
              "Preparación de archivos finalizada exitosamente, ya puede iniciar con la lectura.",
              "Ha ocurrido un error en la preparación de archivos.");
    }

    function procesarAlgo(url,mensajeProcesando,mensajeExito,mensajeError){
      document.getElementById('tituloCargando').innerHTML=mensajeProcesando;
      $(".loader").show();//para mostrar la pantalla de carga
      $.get(url,
        function(data){     
            console.log("IMPRIMIENDO DATA como llegó:");
            console.log(data);
            
            if(data==1){
                alertaExitosa('¡Enhorabuena!',mensajeExito)
                setTimeout(function(){
                    location.reload();
                },100);
            }else{
                alerta(mensajeError);
            }
            $(".loader").fadeOut("slow");
        }
      );


    }


</script>


@endsection