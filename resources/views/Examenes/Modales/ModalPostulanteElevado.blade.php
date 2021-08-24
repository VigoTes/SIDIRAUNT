{{-- En este modal se vé las características de 
    la postulacion actual vs la de la postulacion anterior con la que se compara, 
    además se muestra el grafico de subida de puntaje y la tasa de elevacion --}}

  
    <div class="row">
        <div class="col text-center">
            Crecimiento anormal de
            <h3 style="color:red">{{$postulanteElevado->getElevacionPorcentual()}}</h3>
        </div>
    </div>

    <label for="">Examen actual:</label>
    <div class="row">
        <div class="col">
            <label for="">Puntaje:</label>
            <input type="text" class="form-control" value="{{$actualPostulacion->puntajeTotal}}">
        </div>
        <div class="col">
            <label for="">Puntaje APT:</label>
            <input type="text" class="form-control" value="{{$actualPostulacion->puntajeAPT}}">
        </div>

        <div class="col">
            <label for="">Puntaje CON:</label>
            <input type="text" class="form-control" value="{{$actualPostulacion->puntajeCON}}">
        </div>
    </div>

    <label for="">Examen anterior</label>
    <div class="row">
       
        <br>
        <div class="col">
            <label for="">Puntaje:</label>
            <input type="text" class="form-control" value="{{$anteriorPostulacion->puntajeTotal}}">
        </div>
        <div class="col">
            <label for="">Puntaje APT:</label>
            <input type="text" class="form-control" value="{{$anteriorPostulacion->puntajeAPT}}">
        </div>

        <div class="col">
            <label for="">Puntaje CON:</label>
            <input type="text" class="form-control" value="{{$anteriorPostulacion->puntajeCON}}">
        </div>
    </div>
    <br>
    <div class="row">
        @if($postulanteElevado->estaObservado())
            <b>
                Este postulante fue observado con la siguiente nota:
            </b>
            <textarea class="form-control" name="" readonly id="" cols="30" rows="3"
            >{{$postulanteElevado->getObservacion()->notaObservacion}}</textarea>

            <label for="">Estado de la observación:</label>
            <input type="text" class="form-control" value="{{$postulanteElevado->getObservacion()->getEstado()->nombre}}" readonly>
            <div class="row ">
                             
                            
                @if($postulanteElevado->getObservacion()->estaPlanteada())
                    <div class="col">
                        <button type="button" id="" class="btn btn-danger btn-sm m-1" title="Se elimina que este registro estuvo observado alguna  vez."
                        onclick="clickCancelarObservacion({{$postulanteElevado->codObservacion}})">
                        <i class="fas fa-minus-circle"></i>
                            Eliminar Observación
                        </button>
                    
                    </div>
                    <div class="w-100"></div>
                    <div class="col">
                        <button type="button" id="" class="btn btn-info btn-sm m-1" onclick="clickDejarPasarObservacion({{$postulanteElevado->codObservacion}})">
                            <i class="fas fa-check"></i>
                            Dejar pasar irregularidad
                        </button>

                    </div>
                    <div class="col">
                        <button type="button" id="" class="btn btn-danger btn-sm m-1" onclick="clickAnularObservacion({{$postulanteElevado->codObservacion}})">
                            <i class="fas fa-ban"></i>
                            Anular postulaciones
                        </button>
                    </div>
                   
                   

                @endif

              
            </div>           

        @else
            <div class="col text-center">


                <button type="button" id="" class="btn btn-danger" onclick="clickModalObservarPostulantesElevados({{$postulanteElevado->codPostulanteElevado}})"
                    data-toggle="modal" data-target="#ModalObservacion"> 
                    Observar Grupo
                    <i class="fas fa-exclamation-circle"></i>
                    
                </button>


            </div>


        @endif

    </div>