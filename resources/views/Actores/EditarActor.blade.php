@extends('Layout.Plantilla')

@section('titulo')
    Editar Actor
@endsection

@section('contenido')

<form id="frmEditarActor" name="frmEditarActor" role="form" action="{{route("Actor.guardarActor")}}" class="form-horizontal form-groups-bordered" method="post">

@csrf 
<input type="hidden" name="codActor" id="codActor" value="{{$actor->codActor}}">

<div class="well">
    <H3 style="text-align: center;">
        Editar Actor
    </H3>
</div>

<div class="container">
    <div class="row">
        <div class="col-2" style="">
            
        
        </div>
        

        <div class="col" style="">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <label class="" style="">Apellidos y Nombres:</label>
                        <div class="">
                            <input type="text" class="form-control" id="apellidosYnombres" name="apellidosYnombres" 
                                value="{{$actor->apellidosYnombres}}" >
                        </div>
                    </div>
                    <div class="col">
                        <label class="" style="">Tipo Actor:</label>
                        <div class="">
                            <select class="form-control" name="codTipoActor" id="codTipoActor">
                                <option value="-1">- Tipo -</option>
                            @foreach ($tipos as $tipoActor)
                                <option value="{{$tipoActor->codTipoActor}}" {{$tipoActor->codTipoActor==$actor->codTipoActor ? 'selected':''}}>
                                    {{$tipoActor->nombre}}
                                </option>
                            @endforeach
                        </select>
                        </div>
                    </div>

                    <div class="w-100"></div>
                    <br>

                    <div class="col" style=" text-align:center">
                        
                        <button type="button" class="btn btn-primary float-right" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" 
                            onclick="clickGuardar()">
                            <i class='fas fa-save'></i> 
                            Registrar
                        </button> 
                        
                        <a href="{{route('Actor.listar')}}" class='btn btn-info float-left'>
                            <i class="fas fa-arrow-left"></i> 
                            Regresar al Menú
                        </a>
    
                    </div>

                </div>

            </div>
               
        </div>
        <div class="col-2" >
         
        
        </div>


    </div>


</div>

</form>

@include('Layout.ValidatorJS')
<script type="text/javascript"> 
       

    function clickGuardar(){
        msj = validarFormulario();
        if(msj!=''){
            alerta(msj);
            return;
        }
        
        confirmarConMensaje('Confirmacion','¿Desea editar el actor?','warning',ejecutarSubmit);
    }

    function ejecutarSubmit(){

        document.frmEditarActor.submit(); // enviamos el formulario	  

    }

 
    function validarFormulario(){
        limpiarEstilos(
            ['apellidosYnombres','codTipoActor']);
        msj = "";
        
        msj = validarTamañoMaximoYNulidad(msj,'apellidosYnombres',50,'Apellidos y Nombres');
        msj = validarSelect(msj,'codTipoActor',-1,'Tipo Actor');
        

        return msj;

    }
    
</script>
@endsection