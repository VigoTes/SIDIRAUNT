<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte de Postulantes.xls";
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");

?>
<meta charset="utf-8">


<table border="1">
    <thead class="thead-dark">
        <tr>
            <th>Nombres</th>
            <th>Último examen</th>
            <th>Puntaje Promedio</th>
            <th># Postulaciones</th>
            <th>Carrera más postulada</th>
        </tr>
    </thead>
    <tbody>
      
      @foreach($listaPostulantes as $postulante)
          <tr>
              
            <td>
              {{$postulante->apellidosYnombres}}
            </td>
            <td>
              {{$postulante->getUltimoExamen()->periodo}}
            </td>
            <td>
              {{$postulante->getPuntajePromedio()}}
            </td>
            <td>
              {{$postulante->getCantidadPostulaciones()}}
            </td>

            <td>
              {{$postulante->getCarreraMásPostulada()->nombre}}
            </td>
    
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