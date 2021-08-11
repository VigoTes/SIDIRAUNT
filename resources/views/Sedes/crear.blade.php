@extends('Layout.Plantilla')
@section('titulo')
    Registrar Sede
@endsection

@section('contenido')

<div class="well">
    <H3 style="text-align: center;">
        REGISTRAR SEDE
    </H3>
</div>

<form method="POST" action="{{ route('sede.guardar') }}" id="frmCrearFacultad" name="frmCrearFacultad">
    @csrf 
    <div class="container">
        <div class="row">
            <div class="col-2">

            </div>
            <div class="col">
                <div class="card-body" style="padding-top: 2%; padding-bottom: 5%; padding-left: 5%">
                    <div class="col">
                        <label for="">Nombre:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}"
                                    placeholder="Ingrese sede">
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
