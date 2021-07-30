@extends('Layout.Plantilla')
@section('titulo')
    Area
@endsection

@section('contenido')

<div style="text-align: center">
    <h2>AREAS</h2>
    <br>
      
    <div class="row">
        <div class="col-md-2">
            <a href="{{route('area.create')}}" class = "btn btn-primary" style="margin-bottom: 5px;"> 
            <i class="fas fa-plus"> </i> 
                Registrar Area
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
                <th scope="col">Area</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($area as $item )
                <tr>
                    <th>{{$item->codArea}}</th>
                    <td>{{$item->area}}</td>
                    <td>{{$item->descripcion}}</td>
                    <td>
                        <a href="{{route('area.edit', $item->codArea)}}"><i class="fas fa-edit" style="color:#3084D7; font-size: 20px;"></i></a>
                        <!--
                        <a href="{{route('area.eliminar', $item->codArea)}}" ><i class="fas fa-trash-alt fa-fw" style="color:#3084D7; font-size: 20px;"></i></a>
                        -->
                    </td>
                </tr>
            @endforeach
            
        </tbody>
    </table>
</div>


@endsection
