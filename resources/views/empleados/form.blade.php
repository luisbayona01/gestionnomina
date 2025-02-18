                     

                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nombres</label>
                                <input type="text" name="nombres" class="form-control" placeholder="Escribe el nombre de tu empleado" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Apellidos</label>
                                <input type="text"  name= "apellidos" class="form-control" placeholder="Escribe los apellidos de tu empleado" required>
                                <div class="invalid-feedback">
            el apellido es   requerido
               </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Identificación</label>
                                <input type="text" name="identificacion" class="form-control" placeholder="Escribe un número de identificación" required>

                                <div class="invalid-feedback">
                                      La Identificacion es   requerida
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="text" name="telefono" class="form-control" placeholder="Escribe un número de teléfono"  required>

                                <div class="invalid-feedback">
                                      el Telefono es   requerido
                                    </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="row">
                      
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Departamento</label>
                                <select class="form-select" name="departamento_id" id="departamento" required>
                                        <option selected disabled>Selecciona un departamento</option>
                                        @foreach($departamento as $dep)
                                            <option value="{{ $dep->id }}">{{ $dep->nombre }}</option>
                                        @endforeach
                                </select>
                                <div class="invalid-feedback">
                                     selecione  un departamento
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" >Ciudad</label>
                                <select class="form-select" name="ciudad_id" id="ciudad" required>
                                    <option selected disabled>Selecciona una ciudad</option>
                                </select>
                                <div class="invalid-feedback">
                                     selecione  una ciudad
                                    </div>
                            </div>
                        </div>         
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Dirección</label>
                                <input type="text" name="direccion" class="form-control" placeholder="Escribe una direccion"  required>

                                <div class="invalid-feedback">
                                      la  direccion es   requerida
                                    </div>
                            </div>
                        </div>
                    </div>           
                    </div>
            