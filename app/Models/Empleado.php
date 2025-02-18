<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
class Empleado extends Model
{
    //use SoftDeletes;

    protected $table = 'empleados';
    
    protected $fillable = [
        'user_id',
        'nombres',
        'apellidos',
        'identificacion',
        'direccion',
        'telefono',
        'ciudad_id',
        'jefe',
        'activo'
    ];

    // Relación con Cargos (muchos a muchos)
    public function cargos()
    {
        return $this->belongsToMany(Cargo::class, 'empleado_cargo')
                    ->withTimestamps();
    }

    // Relación con Ciudad
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class);
    }

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

   
}
