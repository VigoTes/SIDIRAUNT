
    <div class="row">
        <div class="col">
            <label class="" style="margin-top: 6px" >Puntaje AP:</label>
        </div>  
        <div class="col">    
            <div class="">
                <input type="text" class="form-control"  
                    value="{{$grupoIguales->puntajeAP}}"  readonly>
            </div>
        </div>
        <div class="col">
            <label class="" style="margin-top: 6px" >Puntaje CON:</label>
        </div>  
        <div class="col">    
            <div class="">
                <input type="text" class="form-control"  
                    value="{{$grupoIguales->puntajeCON}}"  readonly>
            </div>
        </div>
        <div class="col">
            <label class="" style="margin-top: 6px" >Total:</label>
        </div>  
        <div class="col">    
            <div class="">
                <input type="text" class="form-control"  
                    value="{{$grupoIguales->puntajeTotal}}"  readonly>
            </div>
        </div>

        <div class="w-100"> <br> </div>

        <div class="col">
            <label class="" style="margin-top: 6px" >Correctas:</label>
        </div>  
        <div class="col">    
            <div class="">
                <input type="text" class="form-control"  
                    value="{{$grupoIguales->correctas}}"  readonly>
            </div>
        </div>
        <div class="col">
            <label class="" style="margin-top: 6px" >Incorrectas:</label>
        </div>  
        <div class="col">    
            <div class="">
                <input type="text" class="form-control"  
                    value="{{$grupoIguales->incorrectas}}"  readonly>
            </div>
        </div>
        <div class="col">
            <label class="" style="line-height : 15px;">Total respondidas:</label>
        </div>  
        <div class="col">    
            <div class="">
                <input type="text" class="form-control"  
                    value="{{$grupoIguales->correctas+$grupoIguales->incorrectas}}"  readonly>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($postulantes as $itemPostulante)
                    <tr>
                        <td>{{$itemPostulante->codActor}}</td>
                        <td>{{$itemPostulante->apellidosYnombres}}</td>
                        <td>{{$itemPostulante->getExamenPostulante($analisis->codExamen)->getCarrera()->nombre}}</td>
                    </tr>
                    @endforeach
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
