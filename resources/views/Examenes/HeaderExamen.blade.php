
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
               

                <a target="blank-1"  href="{{route('Examen.VerPDF',$examen->codExamen)}}" class='btn btn-success float-right' style="margin-left: 5px">
                  <i class="fas fa-file-pdf"></i> Ver Examen
                </a>

              </div>

          </div>

      </div>
    </div>

</div>