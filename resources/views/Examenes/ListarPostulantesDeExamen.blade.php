
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

@php

    $puedeVerPerfilesAjenos = false; //por defecto no puede
    $actorLogeado = App\Actor::getActorLogeado();
    if($actorLogeado != false){
      if($actorLogeado->puedeVerPerfilesAjenos()){
        $puedeVerPerfilesAjenos = true;
      }
    }



@endphp

@section('contenido')
<style>


</style>



<div style="text-align: center">


  <h2> Listar Postulantes de Examen </h2>


  @include('Examenes.HeaderExamen')



  <br>
    
    <div class="row">
      
      <div class="col-md-10">
        <form class="form-inline float-left">
         
          <input type="text"  class="form-control float-left" name="apellidosYnombres" id="apellidosYnombres" style="width: 300px"
                value="{{$apellidosYnombres}}" placeholder="Buscar por nombre...">

          
        

          <button class="btn btn-success float-left" type="submit">
            Buscar 
            <i class="fas fa-search"></i>
          </button>
        </form>
      </div>
    </div>
    


    @include('Layout.MensajeEmergenteDatos')
      
    <table class="table table-sm table-hover" style="font-size: 10pt; margin-top:10px;">
      <thead class="thead-dark">
        <tr>
           <th>Orden</th>
            <th>Carnet</th>
           <th>Nombres</th>
          
         <th>Puntaje APT</th>
          <th>Puntaje CON</th>
          <th>Puntaje Total</th>
        
          <th>Escuela</th>
          <th>Condición</th>
          @if($puedeVerPerfilesAjenos)
            <th>Ver</th>
          @endif
        
        </tr>
      </thead>
      <tbody>
        
        @foreach($listaExamenes as $examenPostulante)
            <tr>
                <td>{{$examenPostulante->orden}}</td>
                <td>{{$examenPostulante->nroCarnet}}</td>
                
                <td>{{$examenPostulante->getActor()->apellidosYnombres}}</td>
                <td>{{$examenPostulante->puntajeAPT}}</td>
                <td>{{$examenPostulante->puntajeCON}}</td>
                <td>{{$examenPostulante->puntajeTotal}}</td>
             
                <td>{{$examenPostulante->getCarrera()->nombre}}</td>
                <td>{{$examenPostulante->getCondicion()->nombre}}</td>

                @if($puedeVerPerfilesAjenos)
                  <td>
                      <a class="btn btn-info btn-sm" href="{{route('Postulante.VerPerfil',$examenPostulante->codActor)}}">
                        Perfil
                      </a>

                      {{-- ABRE EL MODAL PARA VER LAS RESPUESTAS --}}
                      <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalPreguntasDePostulante" 
                        onclick="actualizarModalPreguntasDePostulante({{$examenPostulante->codExamenPostulante}},'{{$examenPostulante->getActor()->apellidosYnombres}}')">
                        Ver respuestas
                      </button>

                  </td>
                @endif
               
            </tr>
        @endforeach
      </tbody>
    </table>
    {{$listaExamenes->appends(
      ['apellidosYnombres'=>$apellidosYnombres]
  )
      ->links()
    }}
 
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







@endsection



@section('script')
<script>
    
    $(window).load(function(){
        
        //$(".loader").fadeOut("slow");
        //$(".loader").show();  //para mostrar la pantalla de carga

        $(".loader").hide();  //para mostrar la pantalla de carga

    });
 

     
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


@endsection