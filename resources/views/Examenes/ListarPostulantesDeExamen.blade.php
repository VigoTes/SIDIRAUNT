
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


  <h2> Listar Postulantes de Examen </h2>
  <div class="card fontSize9">
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
                <div class="col-3">    
                  <a href="{{route("Examen.ExportarPostulantes",$examen->codExamen)}}" class='btn btn-success float-right'>
                    <i class="fas fa-file-excel"></i> Reporte Postulantes
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
                    <label class="" style="margin-top: 6px" >Tasa Ausentismo:</label>
                </div>  
                <div class="col-2">    
                    <div class="">
                        <input type="text" class="form-control"  
                            value="{{$examen->ausentes/$examen->nroPostulantes}} %"  readonly>
                    </div>
                </div>
                <div class="col-3">    
                  <a href="{{route('Examen.descargarPDF',$examen->codExamen)}}" class='btn btn-success float-right' style="margin-left: 5px">
                    <i class="fas fa-file-download"></i> Bajar Examen
                  </a>
                  <a target="blank-1"  href="{{route('Examen.VerPDF',$examen->codExamen)}}" class='btn btn-success float-right' style="margin-left: 5px">
                    <i class="fas fa-file-pdf"></i> Ver Examen
                  </a>

                </div>

            </div>

        </div>
      </div>

  </div>



  <br>
    
    <div class="row">
      
      <div class="col-md-10">
        <form class="form-inline float-left">

          <label style="" for="">
            
            
          </label>
 
              <input type="text"  class="form-control float-left" name="fechaFin" id="fechaFin" style="margin-right: 10px"
                   value="" placeholder="Buscar por nombre...">
             

          <button class="btn btn-success float-left" type="submit">
            Buscar
            <i class="fas fa-search"></i>
          </button>
        </form>
      </div>
    </div>
    


    @include('Layout.MensajeEmergenteDatos')
      
    <table class="table table-sm" style="font-size: 10pt; margin-top:10px;">
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
          <th>Ver</th>
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
               
            </tr>
        @endforeach
      </tbody>
    </table>
    {{$listaExamenes->links()}}
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