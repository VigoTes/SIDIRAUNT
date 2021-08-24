
                <div class="row">
                    <div class="col">
                        <label class="" style="margin-top: 6px" >Correctas:</label>
                    </div>  
                    <div class="col">    
                        <div class="">
                            <input type="text" class="form-control"  
                                value="{{$grupoPatrones->nroCorrectas}}"  readonly>
                        </div>
                    </div>
                    <div class="col">
                        <label class="" style="margin-top: 6px" >Incorrectas:</label>
                    </div>  
                    <div class="col">    
                        <div class="">
                            <input type="text" class="form-control"  
                                value="{{$grupoPatrones->nroIncorrectas}}"  readonly>
                        </div>
                    </div>
                    <div class="col">
                        <label class="" style="line-height : 15px;margin-top: 3px">Total puntaje aportado:</label>
                    </div>  
                    <div class="col">    
                        <div class="">
                            <input type="text" class="form-control"  
                                value="{{$grupoPatrones->puntajeAdquirido}}"  readonly>
                        </div>
                    </div>
    
                    
                </div>
                <br>
                <div class="row">
                    <div class="col-4">
                        <div class="row">
                            <div class="col">
                                <p>
                                    @for($i = 1; $i <= 20; $i++)
                                        @if($i==20)
                                        {{$i}}. <b style="color: {{$arr['color'][$i]}}; font-weight: normal">{{$arr['clave'][$i]}}</b>
                                        @else
                                        {{$i}}. <b style="color: {{$arr['color'][$i]}}; font-weight: normal">{{$arr['clave'][$i]}}</b> <br>
                                        @endif
                                    @endfor
                                </p>
                            </div>
                            <div class="col">
                                <p>
                                    @for($i = 21; $i <= 40; $i++)
                                        @if($i==40)
                                        {{$i}}. <b style="color: {{$arr['color'][$i]}}; font-weight: normal">{{$arr['clave'][$i]}}</b>
                                        @else
                                        {{$i}}. <b style="color: {{$arr['color'][$i]}}; font-weight: normal">{{$arr['clave'][$i]}}</b> <br>
                                        @endif
                                    @endfor
                                </p>
                            </div>
                            <div class="col">
                                <p>
                                    @for($i = 41; $i <= 60; $i++)
                                        @if($i==60)
                                        {{$i}}. <b style="color: {{$arr['color'][$i]}}; font-weight: normal">{{$arr['clave'][$i]}}</b>
                                        @else
                                        {{$i}}. <b style="color: {{$arr['color'][$i]}}; font-weight: normal">{{$arr['clave'][$i]}}</b> <br>
                                        @endif
                                    @endfor
                                </p>
                            </div>
                            <div class="col">
                                <p>
                                    @for($i = 61; $i <= 80; $i++)
                                        @if($i==80)
                                        {{$i}}. <b style="color: {{$arr['color'][$i]}}; font-weight: normal">{{$arr['clave'][$i]}}</b>
                                        @else
                                        {{$i}}. <b style="color: {{$arr['color'][$i]}}; font-weight: normal">{{$arr['clave'][$i]}}</b> <br>
                                        @endif
                                    @endfor
                                </p>
                            </div>
                            <div class="col">
                                <p>
                                    @for($i = 81; $i <= 100; $i++)
                                        @if($i==100)
                                        {{$i}}.<b style="color: {{$arr['color'][$i]}}; font-weight: normal">{{$arr['clave'][$i]}}</b>
                                        @else
                                        {{$i}}. <b style="color: {{$arr['color'][$i]}}; font-weight: normal">{{$arr['clave'][$i]}}</b> <br>
                                        @endif
                                    @endfor
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
                                    <th>Nombres Y Apellidos</th>
                                    <th>Carrera</th>
                                    <th>Perfil</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($postulantes as $itemPostulante)
                                <tr>
                                    <td>{{$itemPostulante->codActor}}</td>
                                    <td>{{$itemPostulante->apellidosYnombres}}</td>
                                    <td>{{$itemPostulante->getExamenPostulante($analisis->codExamen)->getCarrera()->nombre}}</td>
                                    <td>
                            
                                        <a href="{{route('Postulante.VerPerfil',$itemPostulante->codActor)}}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                       
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            
                            @if($grupoPatrones->estaObservado())
                                <b>
                                    Este grupo fue observado con la siguiente nota:
                                </b>
                                
                                <textarea class="form-control" name="" readonly id="" cols="30" rows="3"
                                    >{{$grupoPatrones->getObservacion()->notaObservacion}}</textarea>
                                <label for="">Estado de la observación:</label>
                                <input type="text" class="form-control" value="{{$grupoPatrones->getObservacion()->getEstado()->nombre}}" readonly>
                                
                                
                                @if($grupoPatrones->getObservacion()->estaPlanteada())
                                    <div class="col">
                                        <button type="button" id="" class="btn btn-danger btn-sm m-1" title="Se elimina que este registro estuvo observado alguna  vez."
                                            onclick="clickCancelarObservacion({{$grupoPatrones->codObservacion}})">
                                            <i class="fas fa-minus-circle"></i>
                                            Eliminar Observación
                                        </button>
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col">
                                        <button type="button" id="" class="btn btn-info btn-sm m-1" onclick="clickDejarPasarObservacion({{$grupoPatrones->codObservacion}})">
                                            <i class="fas fa-check"></i>
                                            Dejar pasar irregularidad
                                        </button>
                                    </div>
                                    <div class="col">

                                        <button type="button" id="" class="btn btn-danger btn-sm m-1" onclick="clickAnularObservacion({{$grupoPatrones->codObservacion}})">
                                            <i class="fas fa-ban"></i>
                                            Anular postulaciones
                                        </button>
                                    </div>

                                @endif
                               
                                
                            @else
                                <div class="col text-center">

                                    <button type="button" id="" class="btn btn-danger" onclick="clickModalObservarGrupoPatron({{$grupoPatrones->codGrupoPatron}})"
                                        data-toggle="modal" data-target="#ModalObservacion"> 
                                        Observar Grupo
                                        <i class="fas fa-exclamation-circle"></i>
                                        
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-3">
                        <small class="badge badge-success">CORRECTA</small>
                        <small class="badge badge-danger">INCORRECTA</small>
                    </div>
                </div>

<script>
    console.log(
    @php
        echo json_encode($respuestasProbando);
    @endphp
    );
</script>