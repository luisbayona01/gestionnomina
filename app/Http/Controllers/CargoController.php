<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;  // Si tienes un modelo Cargo
use Illuminate\Support\Facades\DB;
use  App\Models\Empleado;

class CargoController extends Controller
{
    // Método para listar todos los cargos con los empleados y roles
    public function index()
    {
        $cargos = DB::table('cargos as C')
            ->join('empleado_cargo as Ec', 'Ec.cargo_id', '=', 'C.id')
            ->join('empleados as E', 'E.id', '=', 'Ec.empleado_id')
            ->join('users as U', 'U.id', '=', 'E.user_id')
            ->join('roles as R', 'R.id', '=', 'U.role_id')
            //->where('E.activo', 1)  // Filtro para empleados activos
            ->select('C.id', 'E.nombres', 'E.identificacion', 'C.area', 'C.nombre as cargos', 'R.name as rol', 'E.jefe')
            ->get();
     //dd($empleados);
        return view('cargos.index', compact('cargos'));  // Asumiendo que tienes una vista `index.blade.php`
    }

    // Método para mostrar un solo cargo con detalles
    public function show($id)
    {
        $cargo = Cargo::find($id);  // Asumiendo que tienes un modelo Cargo
        return view('cargos.show', compact('cargo'));
    }

    // Método para mostrar el formulario de creación
    public function create()
    {     
        $empleado= Empleado::all();
        return view('cargos.create',compact('empleado'));  // Crear vista de formulario
    }

    // Método para almacenar un nuevo cargo
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            // Otras validaciones según sea necesario
        ]);

        $cargo = Cargo::create($validatedData);  // Crear nuevo cargo
        return redirect()->route('cargos.index')->with('success', 'Cargo creado exitosamente.');
    }

    // Método para mostrar el formulario de edición
    public function edit($id)
    {
        $cargo = Cargo::find($id);
        return view('cargos.edit', compact('cargo'));  // Crear vista de edición
    }

    // Método para actualizar un cargo
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            // Otras validaciones
        ]);

        $cargo = Cargo::find($id);
        $cargo->update($validatedData);  // Actualizar cargo
        return redirect()->route('cargos.index')->with('success', 'Cargo actualizado exitosamente.');
    }

    // Método para eliminar un cargo
    public function destroy($id)
    {
        $cargo = Cargo::find($id);
        $cargo->delete();  // Eliminar cargo
        return redirect()->route('cargos.index')->with('success', 'Cargo eliminado exitosamente.');
    }

    public  function empleadosid($id){


    }
}
