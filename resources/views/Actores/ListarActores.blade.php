
@extends ('Layout.Plantilla')
@section('titulo')
  Listar actores
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
    <h2> Listar actores </h2>
    <br>
    
    <div class="row">
        <div class="col-md-2">
            <a href="{{route("Actor.crear")}}" class = "btn btn-primary" style="margin-bottom: 5px;"> 
            <i class="fas fa-plus"> </i> 
                Registrar actor
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
      
    <table class="table table-sm table-hover" style="font-size: 10pt; margin-top:10px;">
        <thead class="thead-dark">
            <tr>
                <th>Apellidos y Nombres</th>
                <th>Usuario</th>
                <th>Representante</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
        
        @foreach($actores as $itemActor)
            <tr>
                <td>{{$itemActor->apellidosYnombres}}</td>
                <td>{{$itemActor->getUsuario()->usuario}}</td>
                <td>{{$itemActor->getTipoActor()->nombre}}</td>
                <td>
                    <a href="{{route("Actor.editarUsuario",$itemActor->codActor)}}" class="btn btn-warning btn-xs btn-icon icon-left">
                        Editar Usuario
                    </a>
                    <a href="{{route("Actor.editarActor",$itemActor->codActor)}}" class="btn btn-warning btn-xs btn-icon icon-left">
                        Editar Actor
                    </a>
                    <a href="#" class="btn btn-danger btn-xs btn-icon icon-left" onclick="swal({//sweetalert
                        title:'¿Está seguro de eliminar el actor?',
                        text: '',     //mas texto
                        //type: 'warning',  
                        type: '',
                        showCancelButton: true,//para que se muestre el boton de cancelar
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText:  'SÍ',
                        cancelButtonText:  'NO',
                        closeOnConfirm:     true,//para mostrar el boton de confirmar
                        html : true
                    },
                    function(){//se ejecuta cuando damos a aceptar
                        window.location.href='{{route('Actor.eliminar',$itemActor->codActor)}}';

                    });"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
        @endforeach
      </tbody>
    </table>
    {{$actores->links()}}
</div>
@endsection

