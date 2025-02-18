<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;  
use Illuminate\Support\Facades\DB;
use  App\Models\Empleado;
use App\Models\EmpleadoCargo;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Exception;
class CargoController extends Controller
{      public function __construct()
    {
        $this->middleware('auth');
    }
   
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

   
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
              
                $cargo = Cargo::firstOrCreate([
                    'nombre' => $request->cargo,
                    'area' => $request->area
                ]);
    
              
                EmpleadoCargo::updateOrCreate(
                    ['empleado_id' => $request->empleado_id],
                    ['cargo_id' => $cargo->id]
                );
    
                $empleado = Empleado::where('id', $request->empleado_id)->first();
                if ($empleado) {
                    $empleado->update(['jefe' => $request->jefe]);
    
                    
                    $role = Role::firstOrCreate(['name' => $request->rol]);
    
                    
                    $user = User::where('id', $empleado->user_id)->first();
                    if ($user) {
                        $user->update(['role_id' => $role->id]); 
                        $user->assignRole($role); 
                    }
                }
            });
    
            return response()->json([
                'status' => 'success',
                'message' => 'Datos guardados correctamente.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocurrió un error al guardar los datos.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

   
    public function edit($id)
    {
        $cargo = Cargo::find($id);
        $empleados = Empleado::all(); 
    
        return view('cargos.edit', compact('cargo', 'empleados'));
    }

    // Método para actualizar un cargo
    public function update(Request $request, $id)
    {  
    
        try {
            DB::transaction(function () use ($request, $id) {
                dd($request->all());
                $cargo = Cargo::find($request->cargo_id);  
    
              
                if ($id) {
           
                    $empleadoCargo = EmpleadoCargo::where('empleado_id', $id)->first();
                    if ($empleadoCargo) {
                        $empleadoCargo->update(['cargo_id' => $cargo->id]);
                    } else {
                     
                        EmpleadoCargo::create(['empleado_id' => $id, 'cargo_id' => $cargo->id]);
                    }
                } else {
                 
                    EmpleadoCargo::updateOrCreate(
                        ['empleado_id' => $request->empleado_id],
                        ['cargo_id' => $cargo->id]
                    );
                }
    
                $empleado = Empleado::where('id', $request->empleado_id)->first();
                if ($empleado) {
                    $empleado->update(['jefe' => $request->jefe]);
    
            
                    $role = Role::firstOrCreate(['name' => $request->rol]);
    
                    
                    $user = User::where('id', $empleado->user_id)->first();
                    if ($user) {
                        $user->update(['role_id' => $role->id]); 
                        $user->assignRole($role);
                    }
                }
            });
    
            return response()->json([
                'status' => 'success',
                'message' => 'Datos guardados o actualizados correctamente.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'actualizar los datos.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para eliminar un cargo
    public function destroy($id)
    {
        $cargo = Cargo::find($id);
        $cargo->delete();  // Eliminar cargo
        return redirect()->route('cargos.index')->with('success', 'Cargo eliminado exitosamente.');
    }

    public  function geempleadoidentificacion($id){
     $empleado= Empleado:: where('id',$id)->firstOrFail();
     return response()->json($empleado);
     
    }
}
