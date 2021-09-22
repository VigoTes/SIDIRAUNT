@extends('Layout.Plantilla')

@section('titulo')
    Cambiar Contraseña
@endsection

@section('contenido')

<form id="frmEditarUsuario" name="frmEditarUsuario" role="form" action="{{route("user.guardarPassword")}}" class="form-horizontal form-groups-bordered" method="post">

@csrf 

<div class="well">
    <H3 style="text-align: center;">
        Cambiar Contraseña
    </H3>
</div>
@include('Layout.MensajeEmergenteDatos')
<div class="container">
    <div class="row">
        <div class="col-2" style="">
            
        
        </div>
        

        <div class="col" style="">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <label class="" style="">Usuario:</label>
                        <div class="">
                            <input type="text" class="form-control" id="usuario" name="usuario" 
                                value="{{(App\Actor::getActorLogeado()->getUsuario()->usuario )}}" placeholder="Usuario..." readonly>
                        </div>
                    </div>
                    <div class="col">

                    </div>

                    <div class="w-100"></div>
                    
                    <div class="col">
                        <label class="" style="">Contraseña Actual:</label>
                        <div class="">
                            <input type="password" class="form-control" id="contraseñaActual" name="contraseñaActual" 
                                value="" placeholder="Contraseña..." >
                        </div>
                    </div>
                    <div class="col">
                        <label class="" style="">Repetir Contraseña Actual:</label>
                        <div class="">
                            <input type="password" class="form-control" id="contraseñaActual2" name="contraseñaActual2" 
                                value="" placeholder="Contraseña..." >
                        </div>
                    </div>

                    <div class="w-100"></div>
                    
                    <div class="col">
                        <label class="" style="">Nueva Contraseña:</label>
                        <div class="">
                            <input type="password" class="form-control" id="contraseña" name="contraseña" 
                                value="" placeholder="Contraseña..." >
                        </div>
                    </div>
                    <div class="col">
                        <label class="" style="">Repetir Nueva Contraseña:</label>
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
        
        confirmarConMensaje('Confirmacion','¿Desea editar el usuario?','warning',ejecutarSubmit);
    }

    function ejecutarSubmit(){

        document.frmEditarUsuario.submit(); // enviamos el formulario	  

    }

 
    function validarFormulario(){
        limpiarEstilos(
            ['usuario','contraseñaActual','contraseñaActual2','contraseña','contraseña2']);
        msj = "";
        
        msj = validarTamañoMaximoYNulidad(msj,'usuario',50,'usuario');
        msj = validarTamañoMaximoYNulidad(msj,'contraseñaActual',50,'Contraseña Actual');
        msj = validarTamañoMaximoYNulidad(msj,'contraseñaActual2',50,'Repetir contraseña actual');
        msj = validarTamañoMaximoYNulidad(msj,'contraseña',50,'Nueva Contraseña');
        msj = validarTamañoMaximoYNulidad(msj,'contraseña2',50,'Repetir nueva contraseña');

        msj = validarContenidosIguales(msj,'contraseñaActual','contraseñaActual2','Las actuales contraseñas deben coincidir');
        msj = validarContenidosIguales(msj,'contraseña','contraseña2','Las nuevas contraseñas deben coincidir');
        

        return msj;

    }
    
</script>
@endsection