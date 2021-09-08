@extends('Layout.Plantilla')
@section('titulo')
    Flujograma
@endsection

@section('contenido')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card m-4">
                <div class="card-header">Crear Modalidad</div>

                <div class="card-body">
                    <form method="post" id="modalidadForm" action="{{route('Modalidades.Guardar') }}" role="form">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8 form-group">                    
                                <input type="text" class="form-control input-sm" id="nombre" name="nombre" value="{{ old('nombre') }}"
                                        placeholder="Ingrese modalidad">
                            </div>


                        </div>
                        <div class="row">
                           
                            <div class="col">
                                <button id="btn-regupd" type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i>
                                    Guardar
                                </button>
                                    
                            </div>
                            

                        </div>
                    </form>
                </div>
                   
            </div>
            <div class="col">
                <a class="btn btn-info" href="{{route('Modalidades.Listar')}}">
                    <i class="fas fa-backward"></i>
                    Volver al menu
                </a>
            </div>
        </div>
    </div>
</div>


@endsection
