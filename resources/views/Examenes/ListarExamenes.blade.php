
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
  $esConsejo = App\Actor::esConsejoUniversitario();
  $esDirectorOConsejo = $esDirectorAdmision || $esConsejo ;
@endphp

@section('contenido')
<style>
  .col{
     
    }

  .colLabel{
    width: 13%;
    margin-top: 18px;


  }

  th,td{
    text-align: center;
  }


</style>



<div style="text-align: center">
  <h2> Exámenes de admisión de la UNT </h2>
  
   
  <div class="row ml-2">
    <div class="col text-left">
    @if(App\Actor::hayActorLogeado())
      
      @if(App\Actor::getActorLogeado()->esDirectorAdmision())
        
     
        
          <a href="{{route('Examen.Director.Crear')}}" class = "btn btn-primary" style=""> 
            <i class="fas fa-plus"> </i> 
              Registrar examen
          </a>
       

        @endif
   
    @endif
    </div>
    {{-- PARTE DERECHA --}}
    <div class="col">
      <form class="" action="{{route('Examen.Anonimo.Listar')}}">
        <div class="row">
          
          <div class="col">
        
            <select class="form-control" name="codModalidad" id="codModalidad">
              <option value="-1" {{'-1'==$codModalidadSelected || null==$codModalidadSelected ? 'selected':''}}>- Modalidad -</option>
              @foreach($modalidades as $itemModalidad)
              <option value="{{$itemModalidad->codModalidad}}" {{$itemModalidad->codModalidad==$codModalidadSelected ? 'selected':''}}>{{$itemModalidad->nombre}}</option>
              @endforeach
            </select>
      
          </div>
      
          <div class="col">
      
            <select class="form-control" name="año" id="año">
              <option value="-1" {{'-1'==$añoSelected || null==$añoSelected ? 'selected':''}}>- Año -</option>
              @foreach($años as $itemAño)
              <option value="{{$itemAño->año}}" {{$itemAño->año==$añoSelected ? 'selected':''}}>{{$itemAño->año}}</option>
              @endforeach
            </select>
            
      
          </div>
          <div class="col">
            <button class="btn btn-success">
              <i class="fas fa-search"></i>
              Buscar
            </button>
          </div>
          

        </div>
      </form>
    </div>
 
  </div>


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
      
    <table class="table table-sm table-hover" style="font-size: 10pt; margin-top:10px;">
      <thead class="thead-dark">
        <tr>
          <th>Periodo</th>
          <th>Fecha Rendición</th>
          <th>Modalidad</th>
          <th>Área</th>
          <th>#Postulantes</th>
          <th>#Asistentes</th>
          <th>#Ingresantes</th>
          <th>Sede</th>

          @if($esDirectorAdmision || $esConsejo)
              <th>Estado</th>
              
          @endif

          @if($esDirectorOConsejo)   
            <th>Opciones</th>
          @endif
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
                {{$itemExamen->getArea()->area}}
              </td>
              <td>
                @if($itemExamen->tieneResultados())
                      <a class="btn btn-success btn-xs" href="{{route('Examen.VerPostulantes',$itemExamen->codExamen)}}">
                        {{$itemExamen->nroPostulantes}}
                        <i class="fas fa-eye"></i>
                      </a>
                @endif

                
              </td>
              <td>
                {{$itemExamen->asistentes}}
              </td>
              <td>
                {{$itemExamen->getCantidadIngresantes()}}
              </td>

              <td>
                {{$itemExamen->getSede()->nombre}}
              </td>
             
 
              @if($esDirectorAdmision || $esConsejo)
                <td>
                  {{$itemExamen->getEstado()->descripcion}}
                </td>
              @endif
                      
              {{-- OPCIONES --}}
              @if($esDirectorOConsejo)
                
                <td>
                      
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
                        
                      
                    
                  @endif
                  
                  @if($esDirectorAdmision || $esConsejo)
                      @if($itemExamen->tieneAnalisis() )
                        <a class="btn btn-info btn-sm" href="{{route('Examen.VerReporteIrregularidades',$itemExamen->codExamen)}}">
                          Reporte Irregularidades
                        </a>
                      @endif
                  @endif

                  @if($esDirectorAdmision)      
                    <button type="button" class="btn btn-danger btn-xs" onclick="clickResetear({{$itemExamen->codExamen}})">
                      <i class="fas fa-trash"></i>
                      Resetear
                    </button>
                  @endif

                </td>
              
              @endif
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

    codExamenAResetear = 0;
    function clickResetear(codExamen){
      codExamenAResetear = codExamen;
        confirmarConMensaje("Confirmar","¿Desea resetear este examen? Serán borrados los datos y aparecerá como recién creado.","warning",ejecutarResetearExamen);


    }

    function ejecutarResetearExamen(){
      location.href = "/Examen/"+codExamenAResetear+"/Resetear";

    }
</script>


@endsection