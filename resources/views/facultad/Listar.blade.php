@extends('Layout.Plantilla')
@section('titulo')
    Facultad
@endsection

@section('contenido')

<div style="text-align: center">
    <h2>FACULTADES</h2>
    <br>
      
    <div class="row">
        <div class="col-md-2">
            <a href="{{ route('facultad.create') }}" class = "btn btn-primary" style="margin-bottom: 5px;"> 
            <i class="fas fa-plus"> </i> 
                Registrar Facultad
            </a>
        </div>
        <div class="col-md-10">
            <form class="form-inline float-right">
            </form>
        </div>
    </div>

    @include('Layout.MensajeEmergenteDatos')
        
    <table class="table table-sm" style="font-size: 10pt; margin-top:10px;">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Codigo</th>
                <th scope="col">Nombre</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($facultad as $item )
            <tr>
                <th>{{$item->codFacultad}}</th>
                <td>{{$item->nombre}}</td>
                <td>
                    <a href="{{route('facultad.edit', $item->codFacultad)}}" class="btn btn-warning btn-xs btn-icon icon-left">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" class="btn btn-danger btn-xs btn-icon icon-left" onclick="swal({//sweetalert
                        title:'¿Está seguro de eliminar la facultad?',
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
                        window.location.href='{{route('facultad.eliminar', $item->codFacultad)}}';

                    });"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
            @endforeach
            
        </tbody>
    </table>
</div>



@endsection
