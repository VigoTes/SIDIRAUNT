<?php 
    header("Pragma: public");
    header("Expires: 0");
    $filename = "Reporte de Postulantes de Examen ".$examen->periodo.".xls";
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$filename");
    header("Pragma: no-cache");

?>
<meta charset="utf-8">

<table border="1">
    <thead>
        <tr>
            <th>Orden</th>
            <th>Carnet</th>
            <th>Nombres</th>
            
            <th>Puntaje APT</th>
            <th>Puntaje CON</th>
            <th>Puntaje Total</th>
        
            <th>Escuela</th>
            <th>Condición</th>
        </tr>
    </thead>
    <tbody>
      
      @foreach($listaExamenes as $examenPostulante)
        <tr>
            <td>{{$examenPostulante->orden}}</td>
            <td>{{$examenPostulante->nroCarnet}}</td>
            
            <td>{{$examenPostulante->getActor()->apellidosYnombres}}</td>
            <td>{{$examenPostulante->puntajeAPT}}</td>
            <td>{{$examenPostulante->puntajeCON}}</td>
            <td>{{$examenPostulante->puntajeTotal}}</td>
        
            <td>{{$examenPostulante->getCarrera()->nombre}}</td>
            <td>{{$examenPostulante->getCondicion()->nombre}}</td>
            
        </tr>
      @endforeach
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th colspan="20" style="font-style: oblique;font-weight: normal;text-align: left">* Reporte generado el {{date("d/m/Y")}} mediante el <b>Sistema Web SIDIRAUNT</b></th> 
        </tr>
    </tbody>
</table>