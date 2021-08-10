
@extends ('Layout.Plantilla')
@section('titulo')
  Listar Postulantes
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
  <h2> Listar postulantes </h2>
  
  <form action="{{route('Postulante.Listar')}}">
    <div class="row">

      <div class="col">

      </div>
      <div class="col">

      </div>
      <div class="col"></div>
      <div class="col">
        <input type="text" class="form-control" id="nombresYapellidos" name="nombresYapellidos" placeholder="Nombres y apellidos" value="{{$nombresYapellidos}}">
        
      

      </div>
      <div class="col">
        
        <button type="submit" class="btn btn-success">
          <i class="fas fa-search"></i>
          Buscar
        </button>
      
      </div>
    </div>


  </form>
 
  <br>
     
    


    @include('Layout.MensajeEmergenteDatos')
      
    <table class="table table-sm" style="font-size: 10pt; margin-top:10px;">
      <thead class="thead-dark">
        <tr>
           <th>Nombres</th>
            <th>Último examen</th>
            <th>Puntaje Promedio</th>
            <th># Postulaciones</th>
          
         <th>Carrera más postulada</th>
          <th>Opciones</th>

        </tr>
      </thead>
      <tbody>
        
        @foreach($listaPostulantes as $postulante)
            <tr>
                
              <td>
                {{$postulante->apellidosYnombres}}
              </td>
              <td>
                {{$postulante->getUltimoExamen()->periodo}}
              </td>
              <td>
                {{$postulante->getPuntajePromedio()}}
              </td>
              <td>
                {{$postulante->getCantidadPostulaciones()}}
              </td>

              <td>
                {{$postulante->getCarreraMásPostulada()->nombre}}
              </td>
              <td>
                  <a class="btn btn-success btn-sm" href="{{route('Postulante.VerPerfil',$postulante->codActor)}}">
                    Ver Perfil
                  </a>
               
              </td>
      
            </tr>
        @endforeach
      </tbody>
    </table>
     
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