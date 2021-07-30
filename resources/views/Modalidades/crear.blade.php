@extends('Layout.Plantilla')
@section('titulo')
    Flujograma
@endsection

@section('contenido')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Crear Modalidad</div>

                <div class="card-body">
                <form method="post" id="modalidadForm" action="{{ route('modalidad.guardar') }}" role="form">
                {{ csrf_field() }}
                    <div class="row">                                
                    
                        </div>
                        <div class="row">
                            <div class="col-md-8 form-group">                    
                            <input type="text" class="form-control input-sm" id="nombre" name="nombre" value="{{ old('nombre') }}"
                                    placeholder="Ingrese modalidad">
                            </div>
                        </div>
                      
                        <button id="btn-regupd" type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
