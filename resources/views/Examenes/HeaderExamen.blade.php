
  <div class="card fontSize9">
    <div class="card-body">
      <div class="d-flex">
          <div class="row">
              <div class="col-1">
                  <label class="" style="margin-top: 6px" >Año:</label>
              </div>  
              <div class="col-2">    
                  <div class="">
                      <input type="text" class="form-control"  
                          value="{{$examen->año}}"  readonly>
                  </div>
              </div>
              <div class="col-1">
                  <label class="" style="margin-top: 6px" >Fecha:</label>
              </div>  
              <div class="col-2">    
                  <div class="">
                      <input type="text" class="form-control"  
                          value="{{$examen->getFechaRendicion()}}"  readonly>
                  </div>
              </div>
              <div class="col-1">
                  <label class="" style="margin-top: 6px" >Asistentes:</label>
              </div>  
              <div class="col-2">    
                  <div class="">
                      <input type="text" class="form-control"  
                          value="{{$examen->asistentes}}"  readonly>
                  </div>
              </div>
              <div class="col-3">    
                <a href="{{route("Examen.ExportarPostulantes",$examen->codExamen)}}" class='btn btn-success float-right'>
                  <i class="fas fa-file-excel"></i> Reporte Postulantes
                </a>
              </div>

              <div class="w-100"> <br> </div>

              <div class="col-1">
                  <label class="" style="margin-top: 6px" >Modalidad:</label>
              </div>  
              <div class="col-2">    
                  <div class="">
                      <input type="text" class="form-control"  
                          value="{{$examen->getModalidad()->nombre}}"  readonly>
                  </div>
              </div>
              <div class="col-1">
                  <label class="" style="margin-top: 6px" >#Vacantes:</label>
              </div>  
              <div class="col-2">    
                  <div class="">
                      <input type="text" class="form-control"  
                          value="{{$examen->nroVacantes}}"  readonly>
                  </div>
              </div>
              <div class="col-1">
                  <label class="" style="margin-top: 6px" >Ausentes:</label>
              </div>  
              <div class="col-2">    
                  <div class="">
                      <input type="text" class="form-control"  
                          value="{{$examen->ausentes}}"  readonly>
                  </div>
              </div>
              

              <div class="w-100"> <br> </div>

              <div class="col-1">
                  <label class="" style="margin-top: 6px" >Área:</label>
              </div>  
              <div class="col-2">    
                  <div class="">
                      <input type="text" class="form-control"  
                          value="{{$examen->getArea()->area}}"  readonly>
                  </div>
              </div>
              <div class="col-1">
                  <label class="" style="margin-top: 6px" >#Postulantes:</label>
              </div>  
              <div class="col-2">    
                  <div class="">
                      <input type="text" class="form-control"  
                          value="{{$examen->nroPostulantes}}"  readonly>
                  </div>
              </div>
              <div class="col-1">
                  <label class="" style="margin-top: 6px" >Tasa Ausentismo:</label>
              </div>  
              <div class="col-2">    
                  <div class="">
                      <input type="text" class="form-control"  
                          value="{{$examen->getTasaAusentismo()}} %"  readonly>
                  </div>
              </div>
              <div class="col-3">    
               

                <a target="blank-1"  href="{{route('Examen.VerPDF',$examen->codExamen)}}" class='btn btn-success' style="margin-left: 5px">
                  <i class="fas fa-file-pdf"></i> Ver Examen
                </a>

                <button class="btn btn-success" data-toggle="modal" data-target="#ModalListaPreguntas">
                    <i class="fas fa-tasks"></i>
                    Ver preguntas
                </button>

              </div>

          </div>

      </div>
    </div>

</div>


<div class="modal fade" id="ModalListaPreguntas" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">
                    Preguntas del examen {{$examen->periodo}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="">
                <table class="table table-sm table-hover fontSize9" >
                    <thead class="thead-dark">
                        <tr>
                            <th>Item</th>
                            <th>Pregunta</th>
                            <th>Respuesta</th>
                        </tr>
                    </thead>
                    

                    <tbody>

                        @foreach ($examen->getListaPreguntas() as $pregunta)
                            <tr>
                                <td>
                                    <b>
                                        {{$pregunta->nroPregunta}}
                                    </b>
                                    
                                </td>
                                <td class="text-left">
                                    {{$pregunta->enunciado}}
                                </td>
                                <td>
                                    <b>
                                        {{$pregunta->respuestaCorrecta}}
                                    </b>
                               
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
