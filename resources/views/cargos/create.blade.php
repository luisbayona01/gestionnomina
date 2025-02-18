<form method="POST"   role="form" enctype="multipart/form-data"  class="needs-validation" novalidate id="formcreatecargos">
                            @csrf

                            <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nombres</label>
                                <select name="empleado_id" class="form-conntrol form-select" id="empleado_id" required>
                                <option value="0"> seleccione un empleado</option>
                                @foreach($empleado as $emp)
                                            <option value="{{ $emp->id }}">{{ $emp->nombres }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Identificación</label>
                                <input type="text" name="identificacion" class="form-control" id="identificacion" placeholder="Escribe un número de identificación" readonly>

                                <div class="invalid-feedback">
                                      La Identificacion es   requerida
                                    </div>
                            </div>
                        </div>

                        </div>
                    </div>
                    <div class="row">
                      
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Area</label>
                                <input type="text" name="area" class="form-control" placeholder="Escribe el area"  required>

                                <div class="invalid-feedback">
                                      el area es   requerida
                                    </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Cargo</label>
                                <input type="text" name="cargo" class="form-control" placeholder="Escribe el cargo"  required>
                                <div class="invalid-feedback">
                                    el cargo es requerido
                                    </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="row">
                      
                      
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" >rol</label>
                                <select class="form-select" name="rol"  required>
                                  <option value="">seleccione un rol</option>
                                    <option value="empleado">empleado</option>
                                    <option value="colaborador">colaborador</option>   
                                    <option value="jefe">jefe</option>
                                </select>
                                <div class="invalid-feedback">
                                     selecione  un rol
                                    </div>
                            </div>
                        </div>         
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jefe</label>
                                <input type="text" name="jefe" class="form-control" placeholder="Escribe una direccion"  required>

                                <div class="invalid-feedback">
                                    el jefe es requerido
                                    </div>
                            </div>
                        </div>
                    </div>           
                    </div>

</form>