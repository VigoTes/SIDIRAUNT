@extends('Layout.Plantilla')
@section('titulo')
    Flujograma
@endsection

@section('contenido')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Editar Modalidad</div>

                <div class="card-body">
                
                @if (!empty($message))
                    <div class="alert alert-success" role="alert">
                        {{ $message }}
                    </div>
                @endif
                <form method="post" id="modalidadForm" action="{{route('modalidad.actualizar')}}" role="form">
                {{ csrf_field() }}
                    <div class="row">                                
                        <input type="hidden" class="form-control input-sm" id="codModalidad" name="codModalidad" value="{{ $modalidad['codModalidad'] }}">
                        <div class="col-md-8 form-group">
                            <label>Nombre de la modalidad</label>
                            <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-address-card"></i>
                                    </div>
                                   
                                    <input type="text" class="form-control input-sm" id="nombre" name="nombre" value="{{ $modalidad['nombre'] }}"
                                    placeholder="Nombre de la modalidad"
                                    required>
                                    {{-- {!! $errors->first('name','<small>:message</small><br>') !!} --}}
                                
                            </div>
                                <!-- /.input group -->
                        </div>
                    </div>
                    
                        <button id="btn-regupd" type="submit" class="btn btn-success">Guardar</button>
                        <a href="{{route('modalidad')}}"><button id="btn-regupd" class="btn btn-success" style="margin-left:15px;">Volver</button></a>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection