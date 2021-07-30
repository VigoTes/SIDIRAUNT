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
                    <a href="{{route('facultad.edit', $item->codFacultad)}}"><i class="fas fa-edit" style="color:#3084D7; font-size: 20px;"></i></a>
                    <!--
                    <a href="{{route('facultad.eliminar', $item->codFacultad)}}" ><i class="fas fa-trash-alt fa-fw" style="color:#3084D7; font-size: 20px;"></i></a>
                    -->
                </td>
            </tr>
            @endforeach
            
        </tbody>
    </table>
</div>



@endsection
