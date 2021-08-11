@extends('Layout.Plantilla')

@section('titulo')
    Cargar resultados examen
@endsection
@section('estilos')
    <link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
    <link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection

@section('contenido')

    

<form id="frmExamen" name="frmExamen" role="form" action="{{route('Examen.Director.cargarResultados')}}" 
class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">

<input type="hidden" name="codExamen" id="codExamen" value="{{$examen->codExamen}}" >
@csrf 


<div class="well">
    <H3 style="text-align: center;">
        Cargar resultados de examen
    </H3>
</div>

<br>
<div class="container">
    <div class="row">
        <div class="col-2" style="">
            
        
        </div>
        

        <div class="col" style="">
            <div class="container">
                <div class="row">

                    <div class="col">

                        
                        <label class="" style="">Año:</label>
                        
                        
                        <div class="">
                            <input type="text" class="form-control"  
                                value="{{$examen->año}}"  readonly>
                        </div>
                    </div>
                    <div class="col">

                        
                        <label class="" style="">Modalidad:</label>
                        <input type="text" class="form-control"  
                        value="{{$examen->getModalidad()->nombre}}"  readonly >
                    </div>
                    <div class="w-100"></div>
                  
                    <div class="col">

                        
                        <label class="" style="">Valoración CON+:</label>
                        
                        <input type="text" class="form-control"  
                        value="{{$examen->valoracionPositivaCON}}"  readonly>
                    </div>
                    <div class="col">

                        
                        <label class="" style="">Valoración APT+:</label>
                        
                        <input type="text" class="form-control"   
                        value="{{$examen->valoracionPositivaAPT}}" readonly >
                    </div>


                    <div class="w-100"></div>
                    <div class="col">

                        
                        <label class="" style="">Valoración CON -:</label>
                        
                        <input type="text" class="form-control"  
                        value="{{$examen->valoracionNegativaCON}}"   readonly>
                    </div>
                    <div class="col">

                        
                        <label class="" style="">Valoración APT -:</label>
                        <input type="text" class="form-control"  
                        value="{{$examen->valoracionNegativaAPT}}" readonly >
                    </div>


                    <div class="w-100"></div>
                    <div class="col">

                        
                        <label class="" style="">Fecha rendición:</label>
                        
                        <input type="text" class="form-control"  
                        value="{{$examen->fechaRendicion}}"  readonly >


                    </div>
                  
                    <div class="col">

                        
                        <label class="" style="">Sede:</label>
                        
                        
                        <div class="">
                        <input type="text" class="form-control" 
                            value="{{$examen->getSede()->nombre}}" readonly   >
                        </div>
                    </div>
                    

                    <div class="w-100"></div>
                    <div class="col"> {{-- PARTE IZQUIERDA --}}
                        <div class="row">
                            <label for="">Archivo de respuestas: </label>
                           
                        </div>
                        <div class="row">
                            <input type="file" id="archivoRespuestas" name="archivoRespuestas">
                        </div>

                        <div class="row">

                            <label for="">Archivo del examen escaneado: </label>
                           
                        </div>
                        <div class="row">
                            <input type="file" id="archivoExamenEscaneado" name="archivoExamenEscaneado">
                        </div>
                        
                    </div>


                    
                    <div class="col"> {{-- PARTE DERECHA --}}

                        <div class="row">
                            <label for="">Archivo de preguntas: </label>
                            
                        </div>
                        <div class="row">
                            <input type="file" id="archivoPreguntas" name="archivoPreguntas">
                        </div>
                    </div>

                    <div class="w-100">
                        <br>
                    </div>
                    <div class="col" style="text-align:center">
                        
                        
                        <a href="{{route('Examen.Director.Listar')}}" class='btn btn-info'>
                            <i class="fas fa-arrow-left"></i> 
                            Regresar al Menú
                        </a>
    
                        <button type="button" class="btn btn-primary" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" 
                            onclick="clickCargar()">
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
          
    function clickCargar() 
    {
        msjError = validarFormulario();
        if(msjError!=""){
            alerta(msjError);
            return;
        }
        
        document.frmExamen.submit(); // enviamos el formulario	
    }

    function validarFormulario(){
 

        msjError = "";
        msjError = validarNulidad(msjError,'archivoRespuestas','Archivo de respuestas');
        msjError = validarNulidad(msjError,'archivoExamenEscaneado','Archivo del Examen escaneado');
        msjError = validarNulidad(msjError,'archivoPreguntas','Archivo de preguntas');

        
        
        
         
        return msjError;

    }

    
</script>
@endsection