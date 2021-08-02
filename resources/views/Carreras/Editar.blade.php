@extends('Layout.Plantilla')

@section('titulo')
    Editar Carrera
@endsection
@section('estilos')
    <link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
    <link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection

@section('contenido')

<form id="frmEditarCarrera" name="frmEditarCarrera" role="form" action="{{route("Carrera.update")}}" class="form-horizontal form-groups-bordered" method="post">

    @csrf 
    <input type="hidden" name="codCarrera" id="codCarrera" value="{{$carrera->codCarrera}}">

<div class="well">
    <H3 style="text-align: center;">
        Editar Carrera
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
                                value="{{$carrera->nombre}}" placeholder="Nombre..." >
                        </div>
                    </div>
                    <div class="col">
                        <label class="" style="">Abreviacion:</label>
                        <div class="">
                            <input type="text" class="form-control" id="abreviacion" name="abreviacion" 
                                value="{{$carrera->abreviacionMayus}}" placeholder="Abreviacion..." >
                        </div>
                    </div>

                    <div class="w-100"></div>
                   
                    <div class="col">
                        <label class="" style="">Area:</label>
                        <div class="">
                            <select class="form-control" name="codArea" id="codArea">
                                <option value="-1">- Areas -</option>
                            @foreach ($areas as $itemArea)
                                <option value="{{$itemArea->codArea}}" {{$itemArea->codArea==$carrera->codAreaActual ? "selected" : ""}} >
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
                                
                                <option value="{{$itemFacultad->codFacultad}}" {{$itemFacultad->codFacultad==$carrera->codFacultad ? "selected" : ""}} >
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
        
        document.frmEditarCarrera.submit(); // enviamos el formulario	
    }

    function validarFormulario(){

        limpiarEstilos(['nombre','codArea','codFacultad','abreviacion']);
        msjError = "";

        msjError = validarTamañoMaximoYNulidad(msjError,'nombre',200,'Nombre');
        msjError = validarTamañoMaximoYNulidad(msjError,'abreviacion',50,'Abreviacion');
        
        msjError = validarSelect(msjError,'codArea','-1','Area');
        msjError = validarSelect(msjError,'codFacultad','-1','Facultad');

        return msjError;

    }

    
</script>
@endsection