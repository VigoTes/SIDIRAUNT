@extends('Layout.Plantilla')
@section('titulo')
    Flujograma
@endsection

@section('contenido')


<h1 class="text-center">
Sede
</h1>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{route('sede.crear')}}" class="btn btn-3 btn-success">Agregar sede</a>
                </div>
                <div class="card-body">
                @if (!empty(Session::get('message')))
                    <div class="alert alert-{{Session::get('status')}}" role="alert">
                        {{ Session::get('message') }}
                    </div>
                @endif
            
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead> 
                            <tbody>
                            @if (count($sedes) > 0)
                                    @foreach ($sedes as $sede)
                                        <tr data-entry-id="{{ $sede->codSede }}">
                                            <td>{{ $sede->codSede }}</td>
                                            <td>{{ $sede->nombre }}</td>
                                            <td>
                                                <a href="{{ route('sede.editar',[$sede->codSede ]) }}" class="btn btn-xs btn-info">Editar</a>
                                                <a href="{{ route('sede.eliminar',[$sede->codSede]) }}" class="btn btn-xs btn-danger eliminar">Eliminar</a>
                                            </td>

                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9">No hay registros</td>
                                    </tr>
                                @endif
                            
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>
    $('.eliminar').click(function(e){
        e.preventDefault();
        
        swal({
            title: "¿Esta seguro de eliminar la modalidad?",
            text: "La misma no podrá ser revertida posteriormente!",
            icon: "warning", 
            buttons: ["Cancelar", "Sí, eliminar"],
            dangerMode: true,

        }).then((willRejected) => {
            if(willRejected){
                window.location.href = $(this).attr('href');
            } 
        });

        
    })

</script>

@endsection