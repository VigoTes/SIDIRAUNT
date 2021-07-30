@extends('Layout.Plantilla')

@section('titulo')
    Crear Examen
@endsection
@section('estilos')
    <link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
    <link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection

@section('contenido')

<form id="frmCarrera" name="frmCarrera" role="form" action="" class="form-horizontal form-groups-bordered" method="post">

@csrf 


<div class="well">
    <H3 style="text-align: center;">
        Nueva Carrera
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
                        <label class="" style="">Nombre:</label>
                        <div class="">
                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                value="" placeholder="Nombre..." >
                        </div>
                    </div>

                    <div class="w-100"></div>
                   
                    <div class="col">
                        <label class="" style="">Area:</label>
                        <div class="">
                            <select class="form-control" name="codArea" id="codArea">
                                <option value="-1">- Areas -</option>
                            @foreach ($areas as $itemArea)
                                <option value="{{$itemArea->codArea}}">
                                    {{$itemArea->descripcion}}
                                </option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="col">
                        <label class="" style="">Facultad:</label>
                        <div class="">
                            <select class="form-control" name="codFacultad" id="codFacultad">
                                <option value="-1">- Facultades -</option>
                            @foreach ($facultades as $itemFacultad)
                                
                                <option value="{{$itemFacultad->codFacultad}}">
                                    {{$itemFacultad->nombre}}
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
                        
                        <a href="{{route('Examen.Director.Listar')}}" class='btn btn-info float-left'>
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
          
    function clickGuardar() 
    {
        msjError = validarFormulario();
        if(msjError!=""){
            alerta(msjError);
            return;
        }
        
        document.frmExamen.submit(); // enviamos el formulario	
    }

    function validarFormulario(){

        limpiarEstilos(['nroVacantes','nroPostulantes','valoracionPositivaCON','valoracionPositivaAPT','valoracionNegativaCON','valoracionNegativaAPT'
           , 'año','fechaRendicion','codModalidad','codSede','codArea']);

        msjError = "";

        msjError = validarPositividadYNulidad(msjError,'nroVacantes','Vacantes');
        msjError = validarPositividadYNulidad(msjError,'nroPostulantes','Postulantes');

        msjError = validarPositividadYNulidad(msjError,'valoracionPositivaCON','Valoración Positiva de pregunta Aptitud');
        msjError = validarPositividadYNulidad(msjError,'valoracionPositivaAPT','Valoración Positiva de pregunta Conocimiento');
        msjError = validarPositividadYNulidad(msjError,'valoracionNegativaCON','Valoración Negativa de pregunta Aptitud');
        msjError = validarPositividadYNulidad(msjError,'valoracionNegativaAPT','Valoración Negativa de pregunta Conocimiento');
        

        msjError = validarTamañoMaximoYNulidad(msjError,'año',4,'Año');
        msjError = validarTamañoMaximoYNulidad(msjError,'fechaRendicion',10,'');
        
        msjError = validarSelect(msjError,'codModalidad','-1','Modalidad');
        msjError = validarSelect(msjError,'codSede','-1','Sede');
        msjError = validarSelect(msjError,'codArea','-1','Area');
         
        return msjError;

    }

    
</script>
@endsection