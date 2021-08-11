<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Irregularidades {{$examen->getModalidad()->nombre}} {{$examen->periodo}}</title>
    <style>
        @page {
            margin: 0cm 0cm;
            font-size: 0.7em;
        }
        body {
            margin: 1cm 1cm 1cm;
        }
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #46C66B;
            color: white;
            text-align: center;
            line-height: 30px;
        }
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #46C66B;
            color: white;
            text-align: center;
            line-height: 35px;
        }

        table {
            width: 100%;
            border: 1px solid #000;
        }
        th, td {
            width: 25%;
            text-align: left;
            vertical-align: top;
            border: 1px solid #000;
            border-collapse: collapse;
            padding: 0.3em;
            caption-side: bottom;
        }
        caption {
            padding: 0.3em;
            color: #fff;
            background: #000;
        }
        th {
            background: #eee;
        }
    </style>
</head>
<body>
    

    <h3 style="text-align: center;text-decoration: underline">REPORTE DE IRREGULARIDADES</h3>
    <h4>Datos Generales:</h4>
    <ul>
        <li> Fecha: {{$examen->fechaRendicion}}</li>
        <li> Modalidad: {{$examen->getModalidad()->nombre}}</li>
        <li> Area: {{$examen->getArea()->area}}</li>
        <li> Numero de Postulantes: {{$examen->nroPostulantes}}</li>
        <li> Numero de Asistentes: {{$examen->asistentes}}</li>
    </ul>
    <h4>Grupo de examenes exactamente iguales:</h4>
    <table>
        <thead>
            <tr>
                <th>Grupo</th>
                <th>Cantidad de estudiantes</th>
                <th>Puntaje AP</th>
                <th>Puntaje CON</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gruposIguales as $itemGrupo)
            <tr>
                <td>{{$itemGrupo->identificador()}}</td>
                <td>{{$itemGrupo->cantidadPostulantes()}}</td>
                <td>{{$itemGrupo->puntajeAP}}</td>
                <td>{{$itemGrupo->puntajeCON}}</td>
                <td>{{$itemGrupo->puntajeAP+$itemGrupo->puntajeCON}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h4>Patrones coincidentes de respuestas de preguntas:</h4>
    <table>
        <thead>
            <tr>
                <th>Patron ID</th>
                <th style="width: 40px">Estudiantes</th>
                <th style="width: 40px">Preguntas</th>
                <th style="width: 535px">Detalle</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gruposPatron as $itemGrupo)
            <tr>
                <td>{{$itemGrupo->identificador()}}</td>
                <td>{{$itemGrupo->cantidadPostulantes()}}</td>
                <td>{{$itemGrupo->nroCorrectas+$itemGrupo->nroIncorrectas}}</td>
                <td>{{$itemGrupo->respuestasResumen()}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h4>Alumnos con crecimiento anormal de puntajes:</h4>
    <table>
        <thead>
            <tr>
                <th style="width: 300px">Nombre</th>
                <th>Codigo Postulante</th>
                <th style="width: 130px">Carrera</th>
                <th style="width: 90px">Puntaje Anterior</th>
                <th style="width: 90px">Puntaje Actual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($postulantesElevados as $itemPostulante)
            <tr>
                <td>{{$itemPostulante->postulante()->apellidosYnombres}}</td>
                <td>{{$itemPostulante->postulante()->codUsuario}}</td>
                <td>{{$itemPostulante->examenActual()->getCarrera()->nombre}}</td>
                <td>{{$itemPostulante->examenAnterior()->puntajeTotal}}</td>
                <td>{{$itemPostulante->examenActual()->puntajeTotal}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    
</body>
</html>