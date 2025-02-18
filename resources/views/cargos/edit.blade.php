<form method="POST" role="form" enctype="multipart/form-data" class="needs-validation" novalidate id="formeditcargos">
  
    <input  type="hidden"  name="cargo_id" value="{{ $cargo->id }}">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Nombres</label>
                <select name="empleado_id" class="form-select" id="empleado_idE" required>
                    <option value="0">Seleccione un empleado</option>
                    @foreach($empleados as $emp)
                        <option value="{{ $emp->id }}" {{ $emp->id == $cargo->empleado_id ? 'selected' : '' }}>
                            {{ $emp->nombres }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Identificación</label>
                <input type="text" name="identificacion" class="form-control" id="identificacionE"
                       value="{{ $cargo->identificacion }}" readonly>
                <div class="invalid-feedback">
                    La Identificación es requerida
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Área</label>
                <input type="text" name="area" class="form-control" placeholder="Escribe el área"
                       value="{{ $cargo->area }}" required>
                <div class="invalid-feedback">
                    El área es requerida
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Cargo</label>
                <input type="text" name="cargo" class="form-control" placeholder="Escribe el cargo"
                       value="{{ old('cargo', $cargo->cargo) }}" required>
                <div class="invalid-feedback">
                    El cargo es requerido
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select class="form-select" name="rol" required>
                    <option value="">Seleccione un rol</option>
                    <option value="empleado" {{ $cargo->rol == 'empleado' ? 'selected' : '' }}>Empleado</option>
                    <option value="colaborador" {{ $cargo->rol == 'colaborador' ? 'selected' : '' }}>Colaborador</option>
                    <option value="jefe" {{ $cargo->rol == 'jefe' ? 'selected' : '' }}>Jefe</option>
                </select>
                <div class="invalid-feedback">
                    Seleccione un rol
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Jefe</label>
                <input type="text" name="jefe" class="form-control" placeholder="Escribe una dirección"
                       value="{{ old('jefe', $cargo->jefe) }}" required>
                <div class="invalid-feedback">
                    El jefe es requerido
                </div>
            </div>
        </div>
    </div>
</form>