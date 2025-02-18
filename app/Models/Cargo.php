<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{   
    protected $table = 'cargos';
    protected $fillable = ['nombre','area'];

    public function empleados()
    {
        return $this->belongsToMany(Empleado::class, 'empleado_cargo')
                    ->withTimestamps();
    }
}
