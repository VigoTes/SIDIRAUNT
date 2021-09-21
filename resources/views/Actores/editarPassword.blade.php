@extends('Layout.Plantilla')

@section('titulo')
    Editar Usuario
@endsection

@section('contenido')

<form id="frmEditarUsuario" name="frmEditarUsuario" role="form" action="{{route("user.guardarPassword")}}" class="form-horizontal form-groups-bordered" method="post">

@csrf 

<div class="well">
    <H3 style="text-align: center;">
        Editar Usuario
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
                        <label class="" style="">Contraseña:</label>
                        <div class="">
                            <input type="password" class="form-control" id="contraseña" name="contraseña" 
                                value="" placeholder="Contraseña..." >
                        </div>
                    </div>

                    <div class="w-100"></div>

                    <div class="col">

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
        
        confirmarConMensaje('Confirmacion','¿Desea editar el usuario?','warning',ejecutarSubmit);
    }

    function ejecutarSubmit(){

        document.frmEditarUsuario.submit(); // enviamos el formulario	  

    }

 
    function validarFormulario(){
        limpiarEstilos(
            ['usuario','contraseña','contraseña2']);
        msj = "";
        
        msj = validarTamañoMaximoYNulidad(msj,'usuario',50,'usuario');
        msj = validarTamañoMaximoYNulidad(msj,'contraseña',50,'contraseña');
        msj = validarTamañoMaximoYNulidad(msj,'contraseña2',50,'Repetir contraseña');

        msj = validarContenidosIguales(msj,'contraseña','contraseña2','Las contraseñas deben coincidir');
        

        return msj;

    }
    
</script>
@endsection