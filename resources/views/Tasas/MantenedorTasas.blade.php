@extends('Layout.Plantilla')
@section('titulo')
    Tasas
@endsection

@section('contenido')
<br>
<form id="frmTasas" name="frmTasas" role="form" action="{{route("Dashboard.actualizar")}}" method="post">
@csrf 
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header border-1">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">TASAS:</h3>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th style="text-align: center">Rango de Puntajes</th>
                            <th>Tasa</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($tasas as $itemTasa)
                        <tr>
                            <td style="text-align: center">{{$itemTasa->valorMinimo}} - {{$itemTasa->valorMaximo}}</td>
                            <td>
                                <input type="number" min="0.1" class="form-control" style="width: 30%;" value="{{$itemTasa->valorTasa}}" id="tasa{{$itemTasa->codTasa}}" name="tasa{{$itemTasa->codTasa}}">
                            </td>
                        </tr>
                      @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col">
        <div class="card">
            <div class="card-header border-1">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">PARÁMETROS:</h3>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>Descripción</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($parametros as $itemParametro)
                      <tr>
                        <td>{{$itemParametro->campo}}</td>
                        <td>
                            <input type="number" min="0.1" class="form-control" style="width: 30%;" value="{{$itemParametro->valor}}" id="parametro{{$itemParametro->codParametro}}" name="parametro{{$itemParametro->codParametro}}">
                        </td>
                      </tr>
                      @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</form>
<button type="button" class="btn btn-primary float-right" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" 
    onclick="clickGuardar()">
    <i class='fas fa-save'></i> 
    Registrar
</button> 

@include('Layout.ValidatorJS')
<script type="text/javascript"> 
          
    function clickGuardar() 
    {
        msjError = validarFormulario();
        if(msjError!=""){
            alerta(msjError);
            return;
        }
        
        document.frmTasas.submit(); // enviamos el formulario	
    }

    function validarFormulario(){
        let inputs = [];
        @foreach($tasas as $itemTasa)
        inputs.push('tasa{{$itemTasa->codTasa}}');
        @endforeach
        @foreach($parametros as $itemParametro)
        inputs.push('parametro{{$itemParametro->codParametro}}');
        @endforeach
        limpiarEstilos(inputs);

        msjError = "";
        @foreach($tasas as $itemTasa)
        msjError = validarPositividadYNulidad(msjError,'tasa{{$itemTasa->codTasa}}','{{$itemTasa->valorMinimo}} - {{$itemTasa->valorMaximo}}');
        @endforeach
        @foreach($parametros as $itemParametro)
        msjError = validarPositividadYNulidad(msjError,'parametro{{$itemParametro->codParametro}}','{{$itemParametro->campo}}');
        @endforeach
        

        return msjError;

    }

    
</script>

@endsection