  
  <form method="POST"   role="form" enctype="multipart/form-data"  class="needs-validation" novalidate id="formeditarEmpleados">
  @csrf
  
  <input   type="hidden" name="id" value="{{ $empleado->id}}">
  <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Nombres</label>
                <input type="text" name="nombres" class="form-control" value="{{ $empleado->nombres }}" required>
                
                <div class="invalid-feedback">
                            el  nombre es requerido
                                    </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Apellidos</label>
                <input type="text" name="apellidos" class="form-control" value="{{ $empleado->apellidos }}" required>

                <div class="invalid-feedback">
                                el apellido es requerido
                                    </div>
            </div>
            

        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Identificación</label>
                <input type="text" name="identificacion" class="form-control" value="{{ $empleado->identificacion }}" required>
                <div class="invalid-feedback">
                                la identificacion es  requerida
                                    </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="{{ $empleado->telefono }}" required>
                <div class="invalid-feedback">
                                el telefono es requerido
                                    </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Departamento</label>
                <select class="form-select" name="departamento_id" id="departamentoE" required>
                    <option selected disabled>Selecciona un departamento</option>
                    @foreach($departamento as $dep)
                        <option value="{{ $dep->id }}" {{ $empleado->ciudad->departamento_id == $dep->id ? 'selected' : '' }}>
                            {{ $dep->nombre }}
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                                seleccione un departamento
                                    </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Ciudad</label>
                <select class="form-select" name="ciudad_id" id="ciudadE" required>
                    <option selected disabled>Selecciona una ciudad</option>
                    @foreach($ciudades as $ciudad)
                        <option value="{{ $ciudad->id }}" {{ $empleado->ciudad_id == $ciudad->id ? 'selected' : '' }}>
                            {{ $ciudad->nombre }}
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                                seleccione una ciudad
                                    </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-control" value="{{ $empleado->direccion }}" required>
                <div class="invalid-feedback">
                                la direccion es  requerida
                                    </div>
            </div>
        </div>
    </div>