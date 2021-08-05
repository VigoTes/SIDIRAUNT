
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
  <h2> Listar Postulantes </h2>
  


  <br>
    
    <div class="row">
      
      <div class="col-md-10">
        <form class="form-inline float-right">

          <label style="" for="">
            
            
          </label>
 
              <input type="text"  class="form-control" name="fechaFin" id="fechaFin" style="text-align: center"
                   value="" style="text-align:center;font-size: 10pt;" placeholder="Buscar por nombre...">
             

          <button class="btn btn-success " type="submit">
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
 



</script>


@endsection