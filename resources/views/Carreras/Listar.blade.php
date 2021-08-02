
@extends ('Layout.Plantilla')
@section('titulo')
  Listar carreras
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
    <h2> Listar carreras </h2>
    <br>
    
    <div class="row">
        <div class="col-md-2">
            <a href="{{route("Carrera.crear")}}" class = "btn btn-primary" style="margin-bottom: 5px;"> 
            <i class="fas fa-plus"> </i> 
                Registrar carrera
            </a>
        </div>
        <div class="col-md-10">
            <!--
                <form class="form-inline float-right">


                <button class="btn btn-success " type="submit">Buscar</button>
                </form>
            -->
        </div>
    </div>
    
    @include('Layout.MensajeEmergenteDatos')
      
    <table class="table table-sm" style="font-size: 10pt; margin-top:10px;">
        <thead class="thead-dark">
            <tr>
                <th>Abreviacion</th>
                <th>Nombre</th>
                <th>Area</th>
                <th>Facultad</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
        
        @foreach($carreras as $itemCarrera)
            <tr>
                <td>{{$itemCarrera->abreviacionMayus}}</td>
                <td>{{$itemCarrera->nombre}}</td>
                <td>{{$itemCarrera->getArea()->descripcion}}</td>
                <td>{{$itemCarrera->getFacultad()->nombre}}</td>
                <td>
                    <a href="{{route("Carrera.editar",$itemCarrera->codCarrera)}}"><i class="fas fa-edit" style="color:#3084D7; font-size: 20px;"></i></a>

                    <a href="{{route("Carrera.eliminar",$itemCarrera->codCarrera)}}" ><i class="fas fa-trash-alt fa-fw" style="color:#3084D7; font-size: 20px;"></i></a>

                </td>
            </tr>
        @endforeach
      </tbody>
    </table>
    {{$carreras->links()}}
</div>
@endsection

