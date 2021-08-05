
@extends ('Layout.Plantilla')
@section('titulo')
  Listar examenes
@endsection

@section('tiempoEspera')
  <div class="loader text-center" id="pantallaCarga">
    <br>
    <br><br><br><br><br><br><br><br>
    <h1 id="tituloCargando">Cargando página</h1>
  </div>
@endsection


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
  <h2> Listar examenes </h2>
  


  <br>
    
    <div class="row">
      <div class="col-md-2">
        <a href="{{route('Examen.Director.Crear')}}" class = "btn btn-primary" style="margin-bottom: 5px;"> 
          <i class="fas fa-plus"> </i> 
            Registrar examen
        </a>
      </div>
{{-- 
      <a href="/borrarTodo" class = "btn btn-danger" style="margin-bottom: 5px;"> 
        <i class="fas fa-trash"> </i> 
          Borrar datos de examenes y analisis
      </a> --}}
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
           <th>Año</th>
            <th>Fecha</th>
           <th>Modalidad</th>
          
         <th>Estado</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        
        @foreach($listaExamenes as $itemExamen)
            <tr>
                
              <td>
                {{$itemExamen->año}}
              </td>
              <td>
                {{$itemExamen->fechaRendicion}}
              </td>
              <td>
                {{$itemExamen->getModalidad()->nombre}}
              </td>
 

              <td>
                {{$itemExamen->getEstado()->descripcion}}
              </td>
              <td>

                @if($itemExamen->tieneResultados())
                  <a class="btn btn-success btn-sm" href="{{route('Examen.VerPostulantes',$itemExamen->codExamen)}}">
                    Ver postulantes
                  </a>
                    
                @endif


                @if($itemExamen->verificarEstado('Creado'))
                    <a class="btn btn-success btn-sm" href="{{route('Examen.Director.VerCargar',$itemExamen->codExamen)}}">
                        Cargar resultados
                    </a>
                @endif


                @if($itemExamen->verificarEstado('Archivos Cargados'))
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

      document.getElementById('tituloCargando').innerHTML="Analizando examen...";

      $(".loader").show();//para mostrar la pantalla de carga

      $.get('/Examen/'+codExamenAProcesar+'/Director/analizarExamen',
      function(data)
      {     
          console.log("IMPRIMIENDO DATA como llegó:");
          console.log(data);
          
          if(data==1){
              alertaExitosa('¡Enhorabuena!','Examen procesado exitosamente')
              setTimeout(function(){
                  location.reload();
              },100);
          }else{
              alerta('Examen error');
          }
          $(".loader").fadeOut("slow");
      }
      );
    }



    function clickLeerDatos(codExamen){
        codExamenAProcesar = codExamen;
        confirmarConMensaje("Confirmar","¿Desea iniciar la lectura de datos del examen? Esto podría tardar","warning",iniciarLectura);

    }

    
    function iniciarLectura(){

      document.getElementById('tituloCargando').innerHTML="Leyendo datos del examen...";

      $(".loader").show();//para mostrar la pantalla de carga

      $.get('/Examen/'+codExamenAProcesar+'/Director/IniciarLecturaDatos',
        function(data)
        {     
            console.log("IMPRIMIENDO DATA como llegó:");
            console.log(data);
            
            if(data==1){
                alertaExitosa('¡Enhorabuena!','Examen procesado exitosamente')
                setTimeout(function(){
                    location.reload();
                },100);
            }else{
                alerta('Examen error');
            }
            $(".loader").fadeOut("slow");
        }
      );
    }



</script>


@endsection