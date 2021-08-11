@extends('Layout.Plantilla')
@section('titulo')
    Area
@endsection

@section('contenido')

<div class="well">
    <H3 style="text-align: center;">
        EDITAR AREA "{{$area->area}}"
    </H3>
</div>


<form method="POST" action="{{route('area.update',$area->codArea)}}"  id="frmEditarArea" name="frmEditarArea">
    @csrf @method('PUT')

    <div class="container">
        <div class="row">
            <div class="col-2">

            </div>
            <div class="col">
                <div class="card-body" style="padding-top: 2%; padding-bottom: 5%; padding-left: 5%">
                    <div class="col">
                        <label for="">Area:</label>
                        <div class="col">
                            <input type="text" name="area" id="area" class="form-control" value="{{$area->area}}">
                        </div>
                    </div> 
                    <div class="col">
                        <label for="">Descripcion:</label>
                        <div class="col">
                            <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{$area->descripcion}}">
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
                <a href="{{ route('area.index') }}" class='btn btn-info float-left'>
                    <i class="fas fa-arrow-left"></i> 
                    Regresar al Menu
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
        
        document.frmEditarArea.submit(); // enviamos el formulario	
    }

    function validarFormulario(){

        limpiarEstilos(['area','descripcion']);
        msjError = "";

        msjError = validarTamañoMaximoYNulidad(msjError,'area',2,'Area');
        msjError = validarTamañoMaximoYNulidad(msjError,'descripcion',200,'Descripcion del Area');

         
        return msjError;
    }

    
</script>

@endsection