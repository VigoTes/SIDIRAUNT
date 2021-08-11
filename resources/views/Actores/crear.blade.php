@extends('Layout.Plantilla')

@section('titulo')
    Crear Actor
@endsection

@section('contenido')

<form id="frmCrearActor" name="frmCrearActor" role="form" action="{{route("Actor.guardar")}}" class="form-horizontal form-groups-bordered" method="post">

@csrf 


<div class="well">
    <H3 style="text-align: center;">
        Nuevo Actor
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
                        <label class="" style="">Apellidos:</label>
                        <div class="">
                            <input type="text" class="form-control" id="apellidos" name="apellidos" 
                                value="" placeholder="Apellidos..." >
                        </div>
                    </div>
                    <div class="col">
                        <label class="" style="">Usuario:</label>
                        <div class="">
                            <input type="text" class="form-control" id="usuario" name="usuario" 
                                value="" placeholder="Usuario..." >
                        </div>
                    </div>

                    <div class="w-100"></div>

                    <div class="col">
                        <label class="" style="">Nombres:</label>
                        <div class="">
                            <input type="text" class="form-control" id="nombres" name="nombres" 
                                value="" placeholder="Nombres..." >
                        </div>
                    </div>
                    <div class="col">
                        <label class="" style="">Contraseña:</label>
                        <div class="">
                            <input type="password" class="form-control" id="contraseña" name="contraseña" 
                                value="" placeholder="Contraseña..." >
                        </div>
                    </div>
                    
                    <div class="w-100"></div>

                    <div class="col">
                        <label class="" style="">Tipo Actor:</label>
                        <div class="">
                            <select class="form-control" name="codTipoActor" id="codTipoActor">
                                <option value="-1">- Tipo -</option>
                            @foreach ($tipos as $tipoActor)
                                <option value="{{$tipoActor->codTipoActor}}">
                                    {{$tipoActor->nombre}}
                                </option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="col">
                        <label class="" style="">Repetir Contraseña:</label>
                        <div class="">
                            <input type="password" class="form-control" id="contraseña2" name="contraseña2" 
                                value="" placeholder="Contraseña..." >
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
                            Regresar al Menu
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
        
        confirmarConMensaje('Confirmacion','¿Desea crear el actor?','warning',ejecutarSubmit);
    }

    function ejecutarSubmit(){

        document.frmCrearActor.submit(); // enviamos el formulario	  

    }

 
    function validarFormulario(){
        limpiarEstilos(
            ['usuario','contraseña','contraseña2','nombres','apellidos','codTipoActor']);
        msj = "";
        
        msj = validarTamañoMaximoYNulidad(msj,'usuario',50,'usuario');
        msj = validarTamañoMaximoYNulidad(msj,'contraseña',50,'contraseña');
        msj = validarTamañoMaximoYNulidad(msj,'contraseña2',50,'Repetir contraseña');
        msj = validarNulidad(msj,'nombres','nombres');
        msj = validarNulidad(msj,'apellidos','apellidos');

        msj = validarContenidosIguales(msj,'contraseña','contraseña2','Las contraseñas deben coincidir');
        msj = validarSelect(msj,'codTipoActor',-1,'Tipo Actor');
        

        return msj;

    }
    
</script>
@endsection