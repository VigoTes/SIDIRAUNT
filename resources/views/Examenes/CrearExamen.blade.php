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
                                value="" placeholder="Año..." >
                        </div>
                    </div>

                    <div class="col">

                        
                        <label class="" style="">Período:</label>
                        
                        
                        <div class="">
                            <input type="text" class="form-control" id="periodo" name="periodo" 
                                value="" placeholder="2020-I" >
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

                        
                        <label class="" style="">Sede:</label>
                        
                        
                        <div class="">
                           
                            <select class="form-control" name="codSede" id="codSede">
                                <option value="-1">- Sedes -</option>
                            @foreach ($listaSedes as $sede)
                               
                                <option value="{{$sede->codSede}}">
                                    {{$sede->nombre}}
                                </option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    

                    
                    <div class="col">

                        
                        <label class="" style="">Área:</label>
                        
                        
                        <div class="">
                           
                            <select class="form-control" name="codArea" id="codArea">
                                <option value="-1">- Áreas -</option>
                            @foreach ($listaAreas as $area)
                               
                                <option value="{{$area->codArea}}">
                                    [{{$area->area}}] {{$area->descripcion}}
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

        limpiarEstilos(['año','fechaRendicion','codModalidad','codSede']);

        msjError = "";
 

        msjError = validarTamañoMaximoYNulidad(msjError,'año',4,'Año');
        msjError = validarTamañoMaximoYNulidad(msjError,'fechaRendicion',10,'');
        
        msjError = validarSelect(msjError,'codModalidad','-1','Modalidad');
        msjError = validarSelect(msjError,'codSede','-1','Sede');
         
        return msjError;

    }

    
</script>
@endsection