@extends('Layout.Plantilla')

@section('titulo')
    Crear Examen
@endsection
@section('estilos')
    <link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
    <link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection

@section('contenido')

    

<form id="frmExamen" name="frmExamen" role="form" action="{{route('Examen.Director.Guardar')}}" 
class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">

@csrf 


<div class="well">
    <H3 style="text-align: center;">
        Nuevo Examen
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
                            <input type="text" class="form-control" id="año" name="año" 
                                value="" placeholder="Nombre..." >
                        </div>
                    </div>
                    <div class="col">

                        
                        <label class="" style="">Modalidad:</label>
                        
                        <select class="form-control" name="codModalidad" id="codModalidad">
                            <option value="-1">- Seleccionar Modalidad -</option>
                            @foreach ($listaModalidades as $modalidad )
                                <option value="{{$modalidad->codModalidad}}">{{$modalidad->nombre}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="w-100"></div>
                   
                    <div class="col">

                        
                        <label class="" style="">Vacantes:</label>
                        
                        
                        <div class="">
                            <input type="number" class="form-control" id="nroVacantes" name="nroVacantes" 
                                value="" placeholder="Cantidad vacantes" >
                        </div>
                    </div>
                    <div class="col">

                        
                        <label class="" style="">Valoracion CON+:</label>
                        
                        
                        <div class="">
                            <input type="number" class="form-control" id="valoracionPositivaCON" name="valoracionPositivaCON" 
                                value="" placeholder="3.612" >
                        </div>
                    </div>
                    <div class="col">

                        
                        <label class="" style="">Valoracion APT+:</label>
                        
                        
                        <div class="">
                            <input type="number" class="form-control" id="valoracionPositivaAPT" name="valoracionPositivaAPT" 
                                value="" placeholder="4.0101" >
                        </div>
                    </div>


                    <div class="w-100"></div>
                    <div class="col">

                        
                        <label class="" style="">Valoracion CON -:</label>
                        
                        
                        <div class="">
                            <input type="number" class="form-control" id="valoracionNegativaCON" name="valoracionNegativaCON" 
                                value="" placeholder="3.612" >
                        </div>
                    </div>
                    <div class="col">

                        
                        <label class="" style="">Valoracion APT -:</label>
                        
                        
                        <div class="">
                            <input type="number" class="form-control" id="valoracionNegativaAPT" name="valoracionNegativaAPT" 
                                value="" placeholder="4.0101" >
                        </div>
                    </div>


                    <div class="w-100"></div>
                    <div class="col">

                        
                        <label class="" style="">Fecha rendición:</label>
                        
                                        
                        <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                            <input type="text"  class="form-control" name="fechaRendicion" id="fechaRendicion" style="text-align: center"
                                value="" style="text-align:center;font-size: 10pt;">
                            <div class="input-group-btn" >                                        
                                <button class="btn btn-primary date-set" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </div>
                        </div>


                    </div>
                    <div class="col">

                        
                        <label class="" style="">Postulantes:</label>
                        
                        
                        <div class="">
                            <input type="number" class="form-control" id="nroPostulantes" name="nroPostulantes" 
                                value="" placeholder="Nombre..." >
                        </div>
                    </div>
                    <div class="col">

                        
                        <label class="" style="">Sede:</label>
                        
                        
                        <div class="">
                           
                            <select class="form-control" name="codSede" id="codSede">
                            @foreach ($listaSedes as $sede)
                                <option value="-1">- Sedes -</option>
                                <option value="{{$sede->codSede}}">
                                    {{$sede->nombre}}
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