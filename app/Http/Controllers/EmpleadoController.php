<?php

namespace App\Http\Controllers;
use App\Models\Empleado;
use App\Models\User;
use App\Notifications\NewEmployeeNotification;
use Illuminate\Support\Facades\Notification;

use App\Models\Ciudad;
use App\Models\Cargo;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str; 
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Exception;
class EmpleadoController extends Controller
{       public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $empleados = DB::table('empleados as E')
                ->join('ciudades as C', 'C.id', '=', 'E.ciudad_id')
                ->join('departamentos as D', 'D.id', '=', 'C.departamento_id')
                ->select('E.id', 'E.nombres', 'E.apellidos', 'E.identificacion', 'E.direccion', 'E.telefono', 'D.nombre as departamento', 'C.nombre as ciudad')
                ->where('E.activo', 1)
                ->get();
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        $departamento = Departamento::all();
      
        return view('empleados.create', compact('departamento' ));
    }

  
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            // Crear el rol "empleado" si no existe
            $role = Role::firstOrCreate(['name' => 'empleado']);
            
            // Verifica que el rol se creó correctamente
            if (!$role) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se pudo crear o encontrar el rol "empleado".',
                ], 500);
            }
            
            // Generar contraseña inicial
            $password = Str::random(10);
            
            // Crear el usuario
            $user = User::create([
                'name' => $request->nombres,
                'apellidos' => $request->apellidos,
                'identificacion' => $request->identificacion,
                'telefono' => $request->telefono,
                'ciudad_id' => $request->ciudad_id,
                'email' => Str::slug($request->nombres . $request->apellidos . $request->identificacion) . '@gmail.com',
                'password' => Hash::make($password),
                'role_id' => $role->id,
            ]);
            
            // Verificar si el usuario fue creado correctamente
            if (!$user) {
                DB::rollback();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error al crear el usuario.',
                ], 500);
            }
            
            // Asignar el rol "empleado" - Modificado para usar syncRoles en lugar de assignRole
            $user->syncRoles([$role->id]);
            
            // Crear el empleado
            $empleado = Empleado::create([
                'user_id' => $user->id,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'identificacion' => $request->identificacion,
                'direccion'=>$request->direccion,
                'telefono' => $request->telefono,
                'ciudad_id' => $request->ciudad_id,
                'activo' => true
            ]);
            
            // Verificar que se creó el empleado correctamente
            if (!$empleado) {
                DB::rollback();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error al crear el empleado.',
                ], 500);
            }
              //dd($empleado);
            // Enviar notificación al administrador
           /* $admins = User::role('Administrador')->get();
            
            if ($admins->count() > 0) {
                Notification::send($admins, new NewEmployeeNotification($empleado, true));
            }
            
             //Enviar notificación al nuevo empleado
            if ($user->email) {
                $user->notify(new NewEmployeeNotification($empleado, false, $password));
            }*/
            
            DB::commit();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Empleado creado exitosamente ',
                'empleado' => $empleado
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Error al crear el empleado',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    
    
    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id); // Buscar el empleado por ID
        $departamento = Departamento::all();
        $ciudades = Ciudad::where('departamento_id', $empleado->ciudad->departamento_id)->get();
        
        return view('empleados.edit', compact('empleado', 'departamento', 'ciudades'));
    }

    public function update(Request $request)
    {
      
        $empleado = Empleado::findOrFail($request->id);

        // Actualizar el empleado
        $empleado->update($request->all());
    
        // Retornar respuesta JSON
        return response()->json([
            'message' => 'Empleado actualizado correctamente',
            'empleado' => $empleado
        ]);
        
    }

    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->activo = 0;  // Cambia el estado a inactivo
        $empleado->save();
        return redirect()->route('empleados.index')
            ->with('success', 'Empleado eliminado exitosamente');
    }

    public function getCiudades($departamento_id)
    {
        $ciudades = Ciudad::where('departamento_id', $departamento_id)->get();
        return response()->json($ciudades);
    }

    

}