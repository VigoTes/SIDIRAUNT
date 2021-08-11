@extends('Layout.Plantilla')
@section('titulo')
    Editar Sede
@endsection

@section('contenido')

<div class="well">
    <H3 style="text-align: center;">
        EDITAR SEDE
    </H3>
</div>

<form method="POST" action="{{route('sede.actualizar')}}" id="frmCrearFacultad" name="frmCrearFacultad">
    @csrf 
    <input type="hidden" class="form-control input-sm" id="codSede" name="codSede" value="{{ $sede['codSede'] }}">
    <div class="container">
        <div class="row">
            <div class="col-2">

            </div>
            <div class="col">
                <div class="card-body" style="padding-top: 2%; padding-bottom: 5%; padding-left: 5%">
                    <div class="col">
                        <label for="">Nombre:</label>
                        <div class="col">
                            <input type="text" class="form-control input-sm" id="nombre" name="nombre" value="{{ $sede['nombre'] }}"
                                    placeholder="Nombre de la sede"
                                    required>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="col-2">

            </div>

            <div class="w-100"></div>
            <br>
            <div class="col" style=" text-align:center">
                <button type="button" class="btn btn-primary float-right" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" 
                    onclick="clickGuardar()">
                    <i class='fas fa-save'></i> 
                    Registrar
                </button> 
                <a href="{{route('sede')}}" class='btn btn-info float-left'>
                    <i class="fas fa-arrow-left"></i> 
                    Regresar al Menú
                </a>
            </div>

        </div>
    </div>

</form>

@include('Layout.ValidatorJS')
<script type="text/javascript"> 
          
    function clickGuardar() 
    {
        msjError = validarFormulario();
        if(msjError!=""){
            alerta(msjError);
            return;
        }
        
        document.frmCrearFacultad.submit(); // enviamos el formulario	
    }

    function validarFormulario(){

        limpiarEstilos(['nombre']);
        msjError = "";

        msjError = validarTamañoMaximoYNulidad(msjError,'nombre',100,'Nombre de Facultad');

         
        return msjError;
    }

    
</script>


@endsection