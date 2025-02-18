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

    public function generarInformeCargos()
    {
        // Obtener los empleados con la consulta
        $cargos = DB::table('cargos as C')
        ->join('empleado_cargo as Ec', 'Ec.cargo_id', '=', 'C.id')
        ->join('empleados as E', 'E.id', '=', 'Ec.empleado_id')
        ->join('users as U', 'U.id', '=', 'E.user_id')
        ->join('roles as R', 'R.id', '=', 'U.role_id')
        //->where('E.activo', 1)  // Filtro para empleados activos
        ->select('C.id', 'E.nombres', 'E.identificacion', 'C.area', 'C.nombre as cargos', 'R.name as rol', 'E.jefe')
        ->get();

        // Cargar la vista con los datos de los empleados
        $pdf = PDF::loadView('reportes.informe_cargos', compact('cargos'));

        // Retornar el PDF generado
        return $pdf->download('informe_cargos.pdf');
    }



}
