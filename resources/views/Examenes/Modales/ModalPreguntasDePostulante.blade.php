
                <div class="row">
                    <div class="col-1">
                        <label class="" style="margin-top: 6px" >Nombre:</label>
                    </div>  
                    <div class="col-4">    
                        <div class="">
                            <input type="text" class="form-control"  
                                value="{{$postulanteElevado->postulante()->apellidosYnombres}}"  readonly>
                        </div>
                    </div>
                    <div class="col-1">
                        <label class="" style="margin-top: 6px" >Carrera:</label>
                    </div>  
                    <div class="col">    
                        <div class="">
                            <input type="text" class="form-control"  
                                value="{{$postulanteElevado->examenActual()->getCarrera()->nombre}}"  readonly>
                        </div>
                    </div>
                    <div class="col-1">
                        <label class="" style="margin-top: 6px" >Condic.:</label>
                    </div>  
                    <div class="col">    
                        <div class="">
                            <input type="text" class="form-control"  
                                value="{{$postulanteElevado->examenActual()->getCondicion()->nombre}}"  readonly>
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
                        <div class="row">
                            <div class="col">
                                <label class=""  style="line-height : 15px; margin-top: 4px">Puntaje AP:</label>
                            </div>  
                            <div class="col">    
                                <div class="">
                                    <input type="text" class="form-control"  
                                        value="{{$postulanteElevado->examenActual()->puntajeAPT}}"  readonly>
                                </div>
                            </div>
                            <div class="col">
                                <label class=""  style="line-height : 15px; margin-top: 4px">Puntaje CON:</label>
                            </div>  
                            <div class="col">    
                                <div class="">
                                    <input type="text" class="form-control"  
                                        value="{{$postulanteElevado->examenActual()->puntajeCON}}"  readonly>
                                </div>
                            </div>
                            <div class="col">
                                <label class="" style="margin-top: 6px" >Total:</label>
                            </div>  
                            <div class="col">    
                                <div class="">
                                    <input type="text" class="form-control"  
                                        value="{{$postulanteElevado->examenActual()->puntajeTotal}}"  readonly>
                                </div>
                            </div>
            
                            <div class="w-100"> <br> </div>
            
                            <div class="col">
                                <label class="" style="margin-top: 6px" >Correctas:</label>
                            </div>  
                            <div class="col">    
                                <div class="">
                                    <input type="text" class="form-control"  
                                        value="{{$postulanteElevado->examenActual()->nroCorrectas}}"  readonly>
                                </div>
                            </div>
                            <div class="col">
                                <label class="" style="margin-top: 6px" >Incorrectas:</label>
                            </div>  
                            <div class="col">    
                                <div class="">
                                    <input type="text" class="form-control"  
                                        value="{{$postulanteElevado->examenActual()->nroIncorrectas}}"  readonly>
                                </div>
                            </div>
                            <div class="col">
                                <label class="" style="line-height : 15px; margin-top: 3px">Total respondidas:</label>
                            </div>  
                            <div class="col">    
                                <div class="">
                                    <input type="text" class="form-control"  
                                        value="{{$postulanteElevado->examenActual()->nroCorrectas+$postulanteElevado->examenActual()->nroIncorrectas}}"  readonly>
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
            