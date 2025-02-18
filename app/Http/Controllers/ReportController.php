<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function generarInforme()
    {
        // Obtener los empleados con la consulta
        $empleados = DB::table('empleados as E')
            ->join('ciudades as C', 'C.id', '=', 'E.ciudad_id')
            ->join('departamentos as D', 'D.id', '=', 'C.departamento_id')
            ->select('E.id', 'E.nombres', 'E.apellidos', 'E.identificacion', 'E.direccion', 'E.telefono', 'D.nombre as departamento', 'C.nombre as ciudad')
            ->where('E.activo', 1)
            ->get();

        // Cargar la vista con los datos de los empleados
        $pdf = PDF::loadView('reportes.informe_empleados', compact('empleados'));

        // Retornar el PDF generado
        return $pdf->download('informe_empleados.pdf');
    }
}
