@extends('Layout.Plantilla')
@section('titulo')
    Reporte de Irregularidades
@endsection

@section('contenido')
<br>

<div class="card">
    <!--
    <div class="card-header border-0">
        <div class="d-flex justify-content-between">
        <h3 class="card-title">Sales</h3>
        <a href="javascript:void(0);">View Report</a>
        </div>
    </div>
    -->
    <div class="card-body">
        <div class="d-flex">
            <div class="row">
                <div class="col-1">
                    <label class="" style="margin-top: 6px" >Año:</label>
                </div>  
                <div class="col-2">    
                    <div class="">
                        <input type="text" class="form-control"  
                            value=""  >
                    </div>
                </div>
                <div class="col-1">
                    <label class="" style="margin-top: 6px" >Fecha:</label>
                </div>  
                <div class="col-2">    
                    <div class="">
                        <input type="text" class="form-control"  
                            value=""  >
                    </div>
                </div>
                <div class="col-1">
                    <label class="" style="margin-top: 6px" >Asistentes:</label>
                </div>  
                <div class="col-2">    
                    <div class="">
                        <input type="text" class="form-control"  
                            value=""  >
                    </div>
                </div>

                <div class="w-100"> <br> </div>

                <div class="col-1">
                    <label class="" style="margin-top: 6px" >Modalidad:</label>
                </div>  
                <div class="col-2">    
                    <div class="">
                        <input type="text" class="form-control"  
                            value=""  >
                    </div>
                </div>
                <div class="col-1">
                    <label class="" style="margin-top: 6px" >#Vacantes:</label>
                </div>  
                <div class="col-2">    
                    <div class="">
                        <input type="text" class="form-control"  
                            value=""  >
                    </div>
                </div>
                <div class="col-1">
                    <label class="" style="margin-top: 6px" >Ausentes:</label>
                </div>  
                <div class="col-2">    
                    <div class="">
                        <input type="text" class="form-control"  
                            value=""  >
                    </div>
                </div>

                <div class="w-100"> <br> </div>

                <div class="col-1">
                    <label class="" style="margin-top: 6px" >Área:</label>
                </div>  
                <div class="col-2">    
                    <div class="">
                        <input type="text" class="form-control"  
                            value=""  >
                    </div>
                </div>
                <div class="col-1">
                    <label class="" style="margin-top: 6px" >#Postulantes:</label>
                </div>  
                <div class="col-2">    
                    <div class="">
                        <input type="text" class="form-control"  
                            value=""  >
                    </div>
                </div>
                <div class="col-1">
                    <label class="" style="line-height : 15px;">Tasa Ausentismo:</label>
                </div>  
                <div class="col-2">    
                    <div class="">
                        <input type="text" class="form-control"  
                            value=""  >
                    </div>
                </div>
                <div class="col">    
                    <a href="#" class='btn btn-info float-right'>
                        <i class="far fa-file-pdf"></i>Ver examen en PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <div class="contanier">
                    <h5 style="text-align: center">GRUPO DE PUNTAJES IGUALES EN PJE TOTAL</h5>
                    <div class="card-body">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="pieGrupoPuntajesIguales" style="min-height: 190px; height: 190px; max-height: 250px; max-width: 100%; display: block; width: 604px;" width="604" height="190" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
                <div class="contanier">
                    <h5 style="text-align: center">CRECIMIENTO ANORMAL EN PUNTAJES</h5>
                    <div class="card-body">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="pieGrupoRespuestasIguales" style="min-height: 190px; height: 190px; max-height: 190px; max-width: 100%; display: block; width: 604px;" width="604" height="190" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="contanier">
                    <h5 style="text-align: center">GRUPO DE ALUMNOS CON RESPUESTAS IGUALES</h5>
                    <div class="card-body">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="pieCrecimientoAnormal" style="min-height: 190px; height: 190px; max-height: 190px; max-width: 100%; display: block; width: 604px;" width="604" height="190" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
                <div class="contanier">
                    <br><br><br>
                    <h5 style="text-align: center">TASA DE IRREGULARIDAD DE LOS RESULTADOS</h5>
                    <h1 style="text-align: center; color: red">20%</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header border-1">
        <div class="d-flex justify-content-between">
            <h3 class="card-title">GRUPO DE EXAMENES EXACTAMENTE IGUALES:</h3>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>Grupo</th>
                    <th>Cantidad de estudiantes</th>
                    <th>Puntaje AP</th>
                    <th>Puntaje CON</th>
                    <th>Total</th>
                    <th>Ver</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>0001</td>
                    <td>15</td>
                    <td>170.005</td>
                    <td>20.001</td>
                    <td>220.006</td>
                    <td>
                        <button type="button" id="" class="btn btn-info btn-sm" onclick="limpiarModalResultadoEsperado()"
                            data-toggle="modal" data-target="#ModalExamenesIguales"><i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header border-1">
        <div class="d-flex justify-content-between">
            <h3 class="card-title">PATRONES COINCIDENTES DE RESPUESTAS DE PREGUNTAS:</h3>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>Patron ID</th>
                    <th>Cantidad de estudiantes</th>
                    <th>Cantidad de Preguntas</th>
                    <th>Detalle</th>
                    <th>Ver</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>0001</td>
                    <td>15</td>
                    <td>70</td>
                    <td>1A;2B;3A;4B;5A;...</td>
                    <td>
                        <button type="button" id="" class="btn btn-info btn-sm" onclick="limpiarModalResultadoEsperado()"
                            data-toggle="modal" data-target="#ModalGrupoRespuestasIguales"><i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header border-1">
        <div class="d-flex justify-content-between">
            <h3 class="card-title">ALUMNOS CON CRECIMIENTO ANORMAL DE PUNTAJES:</h3>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Codigo Postulante</th>
                    <th>Carrera</th>
                    <th>Puntaje Anterior</th>
                    <th>Puntaje Actual</th>
                    <th>Historial</th>
                    <th>Preguntas</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Miguel Moreira</td>
                    <td>0845192</td>
                    <td>Ingenieria Mecanica</td>
                    <td>60.010</td>
                    <td>300.039</td>
                    <td>
                        <a href="#" class="btn btn-warning btn-sm" title="Ver Reposición"><i class="fas fa-eye"></i></a>
                    </td>
                    <td>
                        <button type="button" id="" class="btn btn-info btn-sm" onclick="limpiarModalResultadoEsperado()"
                            data-toggle="modal" data-target="#ModalPreguntasDePostulante"><i class="fas fa-list-ol"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<a href="{{route("Examen.Director.Listar")}}" class='btn btn-info'>
    <i class="fas fa-arrow-left"></i> 
    Regresar al Menu
</a>
<button type="button" id="" class="btn btn-danger float-right"
    data-toggle="modal" data-target="#ModalConfirmacion"><i class="fas fa-exclamation-triangle"></i> Registrar decision del CU
</button>
<br><br>



{{-- MODALE DE EXAMENES IGUALES --}}
<div class="modal fade" id="ModalExamenesIguales" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            

                <div class="modal-header">
                    <h5 class="modal-title" id="">Grupo 0001 - Exactamente Iguales</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <label class="" style="margin-top: 6px" >Puntaje AP:</label>
                        </div>  
                        <div class="col">    
                            <div class="">
                                <input type="text" class="form-control"  
                                    value=""  readonly>
                            </div>
                        </div>
                        <div class="col">
                            <label class="" style="margin-top: 6px" >Puntaje CON:</label>
                        </div>  
                        <div class="col">    
                            <div class="">
                                <input type="text" class="form-control"  
                                    value=""  readonly>
                            </div>
                        </div>
                        <div class="col">
                            <label class="" style="margin-top: 6px" >Total:</label>
                        </div>  
                        <div class="col">    
                            <div class="">
                                <input type="text" class="form-control"  
                                    value=""  readonly>
                            </div>
                        </div>
        
                        <div class="w-100"> <br> </div>
        
                        <div class="col">
                            <label class="" style="margin-top: 6px" >Correctas:</label>
                        </div>  
                        <div class="col">    
                            <div class="">
                                <input type="text" class="form-control"  
                                    value=""  readonly>
                            </div>
                        </div>
                        <div class="col">
                            <label class="" style="margin-top: 6px" >Incorrectas:</label>
                        </div>  
                        <div class="col">    
                            <div class="">
                                <input type="text" class="form-control"  
                                    value=""  readonly>
                            </div>
                        </div>
                        <div class="col">
                            <label class="" style="line-height : 15px;">Total respondidas:</label>
                        </div>  
                        <div class="col">    
                            <div class="">
                                <input type="text" class="form-control"  
                                    value=""  readonly>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <div class="row">
                                <div class="col">
                                    <p>
                                        1. <b style="color: red; font-weight: normal">A</b> <br>
                                        2. <b style="color: green; font-weight: normal">A</b>  <br>
                                        3. A <br>
                                        4. A <br>
                                        5. A <br>
                                        6. A <br>
                                        7. A <br>
                                        8. A <br>
                                        9. A <br>
                                        10. A <br>
                                        11. A <br>
                                        12. A <br>
                                        13. A <br>
                                        14. A <br>
                                        15. A <br>
                                        16. A <br>
                                        17. A <br>
                                        18. A <br>
                                        19. A <br>
                                        20. B
                                    </p>
                                </div>
                                <div class="col">
                                    <p>
                                        21. A <br>
                                        22. A <br>
                                        23. A <br>
                                        24. A <br>
                                        25. A <br>
                                        26. A <br>
                                        27. A <br>
                                        28. A <br>
                                        29. A <br>
                                        30. A <br>
                                        31. A <br>
                                        32. A <br>
                                        33. A <br>
                                        34. A <br>
                                        35. A <br>
                                        36. A <br>
                                        37. A <br>
                                        38. A <br>
                                        39. A <br>
                                        40. B
                                    </p>
                                </div>
                                <div class="col">
                                    <p>
                                        41. A <br>
                                        42. A <br>
                                        43. A <br>
                                        44. A <br>
                                        45. A <br>
                                        46. A <br>
                                        47. A <br>
                                        48. A <br>
                                        49. A <br>
                                        50. A <br>
                                        51. A <br>
                                        52. A <br>
                                        53. A <br>
                                        54. A <br>
                                        55. A <br>
                                        56. A <br>
                                        57. A <br>
                                        58. A <br>
                                        59. A <br>
                                        60. B
                                    </p>
                                </div>
                                <div class="col">
                                    <p>
                                        61. A <br>
                                        62. A <br>
                                        63. A <br>
                                        64. A <br>
                                        65. A <br>
                                        66. A <br>
                                        67. A <br>
                                        68. A <br>
                                        69. A <br>
                                        70. A <br>
                                        71. A <br>
                                        72. A <br>
                                        73. A <br>
                                        74. A <br>
                                        75. A <br>
                                        76. A <br>
                                        77. A <br>
                                        78. A <br>
                                        79. A <br>
                                        80. B
                                    </p>
                                </div>
                                <div class="col">
                                    <p>
                                        81. A <br>
                                        82. A <br>
                                        83. A <br>
                                        84. A <br>
                                        85. A <br>
                                        86. A <br>
                                        87. A <br>
                                        88. A <br>
                                        89. A <br>
                                        90. A <br>
                                        91. A <br>
                                        92. A <br>
                                        93. A <br>
                                        94. A <br>
                                        95. A <br>
                                        96. A <br>
                                        97. A <br>
                                        98. A <br>
                                        99. A <br>
                                        100.B
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <label class="" style="margin-bottom: 6px">Relacion de Postulantes:</label>
                            <table class="table table-sm">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Carrera</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>000145</td>
                                        <td>Juan Alberto</td>
                                        <td>Carranza Diaz</td>
                                        <td>Ingenieria Civil</td>
                                    </tr>
                                    <tr>
                                        <td>000145</td>
                                        <td>Juan Alberto</td>
                                        <td>Carranza Diaz</td>
                                        <td>Ingenieria Civil</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <small class="badge badge-success">CORRECTA</small>
                            <small class="badge badge-danger">INCORRECTA</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            
        </div>
    </div>
</div>

{{-- MODALE DE GRUPOS CON RESPUESTAS IGUALES --}}
<div class="modal fade" id="ModalGrupoRespuestasIguales" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            

                <div class="modal-header">
                    <h5 class="modal-title" id="">Patron 0001 - Grupo de respuestas iguales</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <label class="" style="margin-top: 6px" >Correctas:</label>
                        </div>  
                        <div class="col">    
                            <div class="">
                                <input type="text" class="form-control"  
                                    value=""  readonly>
                            </div>
                        </div>
                        <div class="col">
                            <label class="" style="margin-top: 6px" >Incorrectas:</label>
                        </div>  
                        <div class="col">    
                            <div class="">
                                <input type="text" class="form-control"  
                                    value=""  readonly>
                            </div>
                        </div>
                        <div class="col">
                            <label class="" style="line-height : 15px;margin-top: 3px">Total puntaje aportado:</label>
                        </div>  
                        <div class="col">    
                            <div class="">
                                <input type="text" class="form-control"  
                                    value=""  readonly>
                            </div>
                        </div>
        
                       
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <div class="row">
                                <div class="col">
                                    <p>
                                        1. <b style="color: red; font-weight: normal">A</b> <br>
                                        2. <b style="color: green; font-weight: normal">A</b>  <br>
                                        3. A <br>
                                        4. A <br>
                                        5. A <br>
                                        6. A <br>
                                        7. A <br>
                                        8. A <br>
                                        9. A <br>
                                        10. A <br>
                                        11. A <br>
                                        12. A <br>
                                        13. A <br>
                                        14. A <br>
                                        15. A <br>
                                        16. A <br>
                                        17. A <br>
                                        18. A <br>
                                        19. A <br>
                                        20. B
                                    </p>
                                </div>
                                <div class="col">
                                    <p>
                                        21. A <br>
                                        22. A <br>
                                        23. A <br>
                                        24. A <br>
                                        25. A <br>
                                        26. A <br>
                                        27. A <br>
                                        28. A <br>
                                        29. A <br>
                                        30. A <br>
                                        31. A <br>
                                        32. A <br>
                                        33. A <br>
                                        34. A <br>
                                        35. A <br>
                                        36. A <br>
                                        37. A <br>
                                        38. A <br>
                                        39. A <br>
                                        40. B
                                    </p>
                                </div>
                                <div class="col">
                                    <p>
                                        41. A <br>
                                        42. A <br>
                                        43. A <br>
                                        44. A <br>
                                        45. A <br>
                                        46. A <br>
                                        47. A <br>
                                        48. A <br>
                                        49. A <br>
                                        50. A <br>
                                        51. A <br>
                                        52. A <br>
                                        53. A <br>
                                        54. A <br>
                                        55. A <br>
                                        56. A <br>
                                        57. A <br>
                                        58. A <br>
                                        59. A <br>
                                        60. B
                                    </p>
                                </div>
                                <div class="col">
                                    <p>
                                        61. A <br>
                                        62. A <br>
                                        63. A <br>
                                        64. A <br>
                                        65. A <br>
                                        66. A <br>
                                        67. A <br>
                                        68. A <br>
                                        69. A <br>
                                        70. A <br>
                                        71. A <br>
                                        72. A <br>
                                        73. A <br>
                                        74. A <br>
                                        75. A <br>
                                        76. A <br>
                                        77. A <br>
                                        78. A <br>
                                        79. A <br>
                                        80. B
                                    </p>
                                </div>
                                <div class="col">
                                    <p>
                                        81. A <br>
                                        82. A <br>
                                        83. A <br>
                                        84. A <br>
                                        85. A <br>
                                        86. A <br>
                                        87. A <br>
                                        88. A <br>
                                        89. A <br>
                                        90. A <br>
                                        91. A <br>
                                        92. A <br>
                                        93. A <br>
                                        94. A <br>
                                        95. A <br>
                                        96. A <br>
                                        97. A <br>
                                        98. A <br>
                                        99. A <br>
                                        100.B
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <label class="" style="margin-bottom: 6px">Relacion de Postulantes:</label>
                            <table class="table table-sm">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Carrera</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>000145</td>
                                        <td>Juan Alberto</td>
                                        <td>Carranza Diaz</td>
                                        <td>Ingenieria Civil</td>
                                    </tr>
                                    <tr>
                                        <td>000145</td>
                                        <td>Juan Alberto</td>
                                        <td>Carranza Diaz</td>
                                        <td>Ingenieria Civil</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <small class="badge badge-success">CORRECTA</small>
                            <small class="badge badge-danger">INCORRECTA</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            
        </div>
    </div>
</div>

{{-- MODALE DE PREGUNTAS DE UN POSTULANTE --}}
<div class="modal fade" id="ModalPreguntasDePostulante" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            

                <div class="modal-header">
                    <h5 class="modal-title" id="">Preguntas respondidas - Postulante 050122 - Examen Ordinario 2019-II</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-1">
                            <label class="" style="margin-top: 6px" >Nombre:</label>
                        </div>  
                        <div class="col-4">    
                            <div class="">
                                <input type="text" class="form-control"  
                                    value=""  readonly>
                            </div>
                        </div>
                        <div class="col-1">
                            <label class="" style="margin-top: 6px" >Carrera:</label>
                        </div>  
                        <div class="col">    
                            <div class="">
                                <input type="text" class="form-control"  
                                    value=""  readonly>
                            </div>
                        </div>
                        <div class="col-1">
                            <label class="" style="margin-top: 6px" >Condic.:</label>
                        </div>  
                        <div class="col">    
                            <div class="">
                                <input type="text" class="form-control"  
                                    value=""  readonly>
                            </div>
                        </div>
        
                       
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <div class="row">
                                <div class="col">
                                    <p>
                                        1. <b style="color: red; font-weight: normal">A</b> <br>
                                        2. <b style="color: green; font-weight: normal">A</b>  <br>
                                        3. A <br>
                                        4. A <br>
                                        5. A <br>
                                        6. A <br>
                                        7. A <br>
                                        8. A <br>
                                        9. A <br>
                                        10. A <br>
                                        11. A <br>
                                        12. A <br>
                                        13. A <br>
                                        14. A <br>
                                        15. A <br>
                                        16. A <br>
                                        17. A <br>
                                        18. A <br>
                                        19. A <br>
                                        20. B
                                    </p>
                                </div>
                                <div class="col">
                                    <p>
                                        21. A <br>
                                        22. A <br>
                                        23. A <br>
                                        24. A <br>
                                        25. A <br>
                                        26. A <br>
                                        27. A <br>
                                        28. A <br>
                                        29. A <br>
                                        30. A <br>
                                        31. A <br>
                                        32. A <br>
                                        33. A <br>
                                        34. A <br>
                                        35. A <br>
                                        36. A <br>
                                        37. A <br>
                                        38. A <br>
                                        39. A <br>
                                        40. B
                                    </p>
                                </div>
                                <div class="col">
                                    <p>
                                        41. A <br>
                                        42. A <br>
                                        43. A <br>
                                        44. A <br>
                                        45. A <br>
                                        46. A <br>
                                        47. A <br>
                                        48. A <br>
                                        49. A <br>
                                        50. A <br>
                                        51. A <br>
                                        52. A <br>
                                        53. A <br>
                                        54. A <br>
                                        55. A <br>
                                        56. A <br>
                                        57. A <br>
                                        58. A <br>
                                        59. A <br>
                                        60. B
                                    </p>
                                </div>
                                <div class="col">
                                    <p>
                                        61. A <br>
                                        62. A <br>
                                        63. A <br>
                                        64. A <br>
                                        65. A <br>
                                        66. A <br>
                                        67. A <br>
                                        68. A <br>
                                        69. A <br>
                                        70. A <br>
                                        71. A <br>
                                        72. A <br>
                                        73. A <br>
                                        74. A <br>
                                        75. A <br>
                                        76. A <br>
                                        77. A <br>
                                        78. A <br>
                                        79. A <br>
                                        80. B
                                    </p>
                                </div>
                                <div class="col">
                                    <p>
                                        81. A <br>
                                        82. A <br>
                                        83. A <br>
                                        84. A <br>
                                        85. A <br>
                                        86. A <br>
                                        87. A <br>
                                        88. A <br>
                                        89. A <br>
                                        90. A <br>
                                        91. A <br>
                                        92. A <br>
                                        93. A <br>
                                        94. A <br>
                                        95. A <br>
                                        96. A <br>
                                        97. A <br>
                                        98. A <br>
                                        99. A <br>
                                        100.B
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col">
                                    <label class=""  style="line-height : 15px; margin-top: 4px">Puntaje AP:</label>
                                </div>  
                                <div class="col">    
                                    <div class="">
                                        <input type="text" class="form-control"  
                                            value=""  readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <label class=""  style="line-height : 15px; margin-top: 4px">Puntaje CON:</label>
                                </div>  
                                <div class="col">    
                                    <div class="">
                                        <input type="text" class="form-control"  
                                            value=""  readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="" style="margin-top: 6px" >Total:</label>
                                </div>  
                                <div class="col">    
                                    <div class="">
                                        <input type="text" class="form-control"  
                                            value=""  readonly>
                                    </div>
                                </div>
                
                                <div class="w-100"> <br> </div>
                
                                <div class="col">
                                    <label class="" style="margin-top: 6px" >Correctas:</label>
                                </div>  
                                <div class="col">    
                                    <div class="">
                                        <input type="text" class="form-control"  
                                            value=""  readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="" style="margin-top: 6px" >Incorrectas:</label>
                                </div>  
                                <div class="col">    
                                    <div class="">
                                        <input type="text" class="form-control"  
                                            value=""  readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="" style="line-height : 15px; margin-top: 3px">Total respondidas:</label>
                                </div>  
                                <div class="col">    
                                    <div class="">
                                        <input type="text" class="form-control"  
                                            value=""  readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <small class="badge badge-success">CORRECTA</small>
                            <small class="badge badge-danger">INCORRECTA</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            
        </div>
    </div>
</div>

{{-- MODALE DE CONFIRMACION --}}
<div class="modal fade" id="ModalConfirmacion" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            

                <div class="modal-header">
                    <h5 class="modal-title" id="">Cambiar estado del examen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <h3 class="profile-username text-center" style="font-weight: bold">Decisión final de Consejo Universitario</h3>
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="../../img/usuario.png" alt="User profile picture">
                        </div>
                        <br>
                        <form id="" name="" action="" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Contraseña">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Repetir contraseña">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <p class="" style="margin-bottom: 0" >Nuevo Estado: </p>
                                <div class="w-100"></div>
                                <select class="form-control" name="" id="">
                                    <option value="1">Aprobado</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>

                    <button type="button" class="m-1 btn btn-success" onclick="clickGuardarNuevoResEsp()">
                        <i class="fas fa-save"></i> Guardar
                    </button>   
                </div>
            
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="../../plugins/chart.js/Chart.min.js"></script>
<script type="text/javascript">
    $(function () {
      //-------------
      //- DONUT CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      //var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
      var donutData        = {
        labels: [
            'Chrome',
            'IE',
            'FireFox',
            'Safari',
            'Opera',
            'Navigator',
        ],
        datasets: [
          {
            data: [700,500,400,600,300,100],
            backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
          }
        ]
      }
      var donutOptions     = {
        maintainAspectRatio : false,
        responsive : true,
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      /*
      new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
      });
      */
      //-------------
      //- PIE CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      var pieGrupoPuntajesIguales = $('#pieGrupoPuntajesIguales').get(0).getContext('2d')
      var pieGrupoRespuestasIguales = $('#pieGrupoRespuestasIguales').get(0).getContext('2d')
      var pieCrecimientoAnormal = $('#pieCrecimientoAnormal').get(0).getContext('2d')

      var pieData        = donutData;
      var pieOptions     = {
        maintainAspectRatio : false,
        responsive : true,
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      new Chart(pieGrupoPuntajesIguales, {
        type: 'pie',
        data: pieData,
        options: pieOptions
      })
      new Chart(pieGrupoRespuestasIguales, {
        type: 'pie',
        data: pieData,
        options: pieOptions
      })
      new Chart(pieCrecimientoAnormal, {
        type: 'pie',
        data: pieData,
        options: pieOptions
      })
    })
  </script>

@endsection