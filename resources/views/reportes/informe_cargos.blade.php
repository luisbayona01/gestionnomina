<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de Empleados</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Informe de Empleados Activos</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Identificación</th>
                <th>Area</th>
                <th>Cargo</th>
                <th>rol</th>
                <th>Jefe</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cargos as $cargo)
                <tr>
                             <td>{{ $cargo->nombres }}</td>
                                <td>{{ $cargo->identificacion }}</td>
                                <td>{{ $cargo->area }}</td>
                                <td>{{ $cargo->cargos }}</td>
                                <td>{{ $cargo->rol }}</td>
                                <td>{{ $cargo->jefe }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
