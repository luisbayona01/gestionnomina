@extends('layouts.plantilla')

@section('content')


<style>
        .search-input {
            border: none;
            background-color: #f8f9fa;
            padding: 8px;
            width: 100%;
        }
        .search-input:focus {
            outline: none;
            background-color: #fff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
        .action-column {
            width: 100px;
        }
        .checkbox-column {
            width: 40px;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: none;
        }
        .btn-action {
            padding: 0;
            background: none;
            border: none;
            color: #0d6efd;
        }
        .btn-action:hover {
            color: #0056b3;
        }
        .checkbox-column {
    width: 100px;  
}

.form-check {
    min-height: auto;
    margin-bottom: 0;
    text-align: left;  
}

.form-check-input {
    margin-top: 0;
}

.input-icon-container {
    position: relative;  /* Necesario para posicionar el ícono dentro del contenedor */
}

.search-input {
    border-radius: 26px;  /* Aplica el radio de 26px al campo de entrada */
    padding-left: 30px;  /* Espacio para que el ícono no se sobreponga */
    width: 100%;
    height: 35px;
    box-sizing: border-box;
}

.input-icon-container i {
    position: absolute;
    left: 10px;  /* Ajusta la distancia del ícono desde el borde izquierdo */
    top: 50%;
    transform: translateY(-50%);  /* Centra el ícono verticalmente */
    font-size: 16px;  /* Tamaño del ícono */
    color: #666;  /* Color del ícono */
}



.modal-dialog {
            max-width: 700px;
            width: 90%;
        }
        .modal-content {
            border-radius: 15px;
            padding: 20px;
        }
        .modal-header {
            background-color: #F5F5F5;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px -4px rgba(0, 0, 0, 0.2);
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            margin: -20px -20px 15px -20px;
            padding: 20px;
        }
        .form-control {
            border-radius: 25px;
            padding: 10px 15px;
            margin-bottom: 15px;
            border: 1px solid #e0e0e0;
        }
        .form-select {
            border-radius: 25px;
            padding: 10px 15px;
            margin-bottom: 15px;
            border: 1px solid #e0e0e0;
            background-position: right 15px center;
        }
        .btn {
            border-radius: 25px;
            padding: 8px 25px;
        }
        .btn-secondary {
            background-color: #e0e0e0;
            border: none;
        }
        .btn-primary {
            background-color: #4040ff;
            border: none;
        }
        .modal-title {
            font-size: 1.1rem;
            color: #333;
        }
        .modal-footer {
            border-top: none;
            padding-top: 10px;
        }
        .btn-close {
            opacity: 0.5;
        }
        .btn-close:hover {
            opacity: 0.75;
        }
        .form-label {
            margin-bottom: 8px;
        }
    </style>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
<script>

document.addEventListener("DOMContentLoaded", function () {
 
                document.getElementById("create-empleado").addEventListener("click", function () {
                    fetch("/empleados/create")
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById("modal-body").innerHTML = html;
                        })
                        .catch(error => console.error("Error al cargar el formulario:", error));
                });


            document.getElementById("saveempleado").addEventListener("click", function () {
                                const form = document.getElementById("formcreateEmpleados");

                                // Verifica si el formulario es válido
                                if (!form.checkValidity()) {
                                    form.classList.add("was-validated"); // Agrega clases de Bootstrap para mostrar errores
                                    return; // Detiene el envío si no es válido
                                }

                                // Si es válido, enviamos por AJAX
                                const formData = new FormData(form);

                                fetch("{{ route('empleados.store') }}", {
                                    method: "POST",
                                    body: formData,
                                    headers: {
                                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        toastr.success(data.message); 
                                        location.reload(); 
                                    } else {
                                        toastr.error(data.message); 
                                    }
                                })
                                .catch(error => console.error("Error en la solicitud:", error));
            });

    

            document.getElementById("Editarempleado").addEventListener("click", function (event) {
                    event.preventDefault();
                    let form = document.getElementById("formeditarEmpleados");

                    if (!form.checkValidity()) {
                        form.classList.add("was-validated");
                        return;
                    }

                    let formData = new FormData(form);

                    fetch("{{ route('empleados.update') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        },
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            toastr.success(data.message);
                            location.reload(); 
                        } else {
                            toastr.error("Hubo un error al actualizar el empleado.");
                        }
                    })
                    .catch(error => {
                        toastr.error("Error en el servidor.");
                        console.error("Error:", error);
                    });
                });

                document.addEventListener("change", function (event) {
                    if (event.target && event.target.id === "departamento") { 
                        const departamentoId = event.target.value;
                        const ciudadSelect = document.getElementById("ciudad");

                        if (departamentoId) {
                            fetch(`/ciudades/${departamentoId}`)
                                .then(response => response.json())
                                .then(data => {
                                    ciudadSelect.innerHTML = '<option selected disabled>Selecciona una ciudad</option>';
                                    data.forEach(ciudad => {
                                        let option = document.createElement("option");
                                        option.value = ciudad.id;
                                        option.textContent = ciudad.nombre;
                                        ciudadSelect.appendChild(option);
                                    });
                                })
                                .catch(error => console.error("Error al obtener las ciudades:", error));
                        } else {
                            ciudadSelect.innerHTML = '<option selected disabled>Selecciona una ciudad</option>';
                        }
                    }

                    if (event.target && event.target.id === "departamentoE") { 
                        const departamentoId = event.target.value;
                        const ciudadSelect = document.getElementById("ciudadE");

                        if (departamentoId) {
                            fetch(`/ciudades/${departamentoId}`)
                                .then(response => response.json())
                                .then(data => {
                                    ciudadSelect.innerHTML = '<option selected disabled>Selecciona una ciudad</option>';
                                    data.forEach(ciudad => {
                                        let option = document.createElement("option");
                                        option.value = ciudad.id;
                                        option.textContent = ciudad.nombre;
                                        ciudadSelect.appendChild(option);
                                    });
                                })
                                .catch(error => console.error("Error al obtener las ciudades:", error));
                        } else {
                            ciudadSelect.innerHTML = '<option selected disabled>Selecciona una ciudad</option>';
                        }
                    }
                    


                });
});

$(document).ready(function(){

   
    $('#modaledit .btn-close, #modaledit .btn-secondary').click(function() {
    $('#modaledit').modal('hide');
});

$('#deleteModal .btn-close, #deleteModal .btn-secondary').click(function() {
    $('#deleteModal').modal('hide');
});
$("#searchNombre").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#tablaEmpleados tbody tr").filter(function () {
       
        var cellText = $(this).find("td:nth-child(3)").text().toLowerCase();
        
     
        var inputText = $(this).find("td:nth-child(3) input").length > 0 ? $(this).find("td:nth-child(3) input").val().toLowerCase() : "";

    
        var matches = cellText.indexOf(value) > -1 || inputText.indexOf(value) > -1;
        
        $(this).toggle(matches);
    });
});


$("#searchIdentificacion").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#tablaEmpleados tbody tr").filter(function () {
        // Obtén el texto de la celda
        var cellText = $(this).find("td:nth-child(4)").text().toLowerCase();
        

        var inputText = $(this).find("td:nth-child(4) input").length > 0 ? $(this).find("td:nth-child(4) input").val().toLowerCase() : "";

       
        var matches = cellText.indexOf(value) > -1 || inputText.indexOf(value) > -1;
        
        $(this).toggle(matches);
    });
});

$("#searchDireccion").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#tablaEmpleados tbody tr").filter(function () {
   
        var cellText = $(this).find("td:nth-child(5)").text().toLowerCase();
        
      
        var inputText = $(this).find("td:nth-child(5) input").length > 0 ? $(this).find("td:nth-child(5) input").val().toLowerCase() : "";

     
        var matches = cellText.indexOf(value) > -1 || inputText.indexOf(value) > -1;
        
        $(this).toggle(matches);
    });
});



$("#searchTelefono").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#tablaEmpleados tbody tr").filter(function () {

        var cellText = $(this).find("td:nth-child(6)").text().toLowerCase();
        
    
        var inputText = $(this).find("td:nth-child(6) input").length > 0 ? $(this).find("td:nth-child(6) input").val().toLowerCase() : "";

        var matches = cellText.indexOf(value) > -1 || inputText.indexOf(value) > -1;
        
        $(this).toggle(matches);
    });
});


$("#searchCiudad").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#tablaEmpleados tbody tr").filter(function () {

        var cellText = $(this).find("td:nth-child(7)").text().toLowerCase();
        
       
        var inputText = $(this).find("td:nth-child(7) input").length > 0 ? $(this).find("td:nth-child(7) input").val().toLowerCase() : "";

        
        var matches = cellText.indexOf(value) > -1 || inputText.indexOf(value) > -1;
        
        $(this).toggle(matches);
    });
});


$("#searchDepartamento").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#tablaEmpleados tbody tr").filter(function () {
   
        var cellText = $(this).find("td:nth-child(8)").text().toLowerCase();
        
  
        var inputText = $(this).find("td:nth-child(8) input").length > 0 ? $(this).find("td:nth-child(8) input").val().toLowerCase() : "";

       
        var matches = cellText.indexOf(value) > -1 || inputText.indexOf(value) > -1;
        
        $(this).toggle(matches);
    });
});



//searchTelefono

$('#tablaEmpleados').DataTable({
    "searching": false,  
    "paging": true,      
    "ordering": true,    
    "info": false,           
    "lengthChange": false 
});
    //$('#tablaEmpleados').DataTable();

})

            function EditarEmpleado(id) {
            
                        $.ajax({
                            url: '/empleados/' + id + '/edit',
                            type: 'GET',
                            success: function(response) {
                                $('#modal-bodyEdit').html(response);
                                $('#modaledit').modal('show');
                            },
                            error: function() {
                                alert('Error al cargar los datos');
                            }
                        });
            }





function Deleempleado(id, nombre) {
   
    document.getElementById("userName").textContent = nombre;

    document.getElementById("confirmDelete").href = "/empleados/eliminar/" + id;

       $('#deleteModal').modal('show');
}

</script>

<div class="container-fluid py-4">
        <!-- Header con botones -->
        <div class="d-flex justify-content-between mb-4">
            <div>
                <button class="btn btn-outline-secondary me-2">
                    <i class="fa fa-trash"></i> Borrar selección
                </button>
                <a href="{{ route('generar-informe-empleados') }}" class="btn btn-outline-secondary">
    <i class="fa fa-download"></i> Descargar datos
</a>
            </div>
            <a  id="create-empleado" data-toggle="modal" data-target="#modalcreate" class="btn btn-primary" style="
    color: white;
">
                <i class="fa fa-plus"></i> Agregar
            </a>
        </div>

        <!-- Tabla -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="tablaEmpleados">
                        <thead>
                            <tr>
                            <th>  <span>Todos</span></th> 
                            <th >
                               
                               <div class="form-check">
                                   <input class="form-check-input" type="checkbox" id="selectAll">
                               </div>
                             
                           
                            </th>
                                
                               
                                <th>Nombre</th>
                                <th>Identificación</th>
                                <th>Area</th>
                                <th>Cargo</th>
                                <th>rol</th>
                                <th>Jefe</th>
                                <th class="action-column">Acciones</th>
                            </tr>
                            
                        </thead>
                        <tbody>
                        <tr>
                              <td></td>
                              <td></td>
                            <td>
                                <div class="input-icon-container">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    <input type="text" class="search-input" placeholder="Buscar por nombre" id="searchNombre">
                                </div>
                            </td>
                            <td>
                                <div class="input-icon-container">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    <input type="text" class="search-input" placeholder="Buscar por identificación" id="searchIdentificacion">
                                </div>
                            </td>
                            <td>
                                <div class="input-icon-container">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    <input type="text" class="search-input" placeholder="Buscar por dirección" id="searchDireccion">
                                </div>
                            </td>
                            <td>
                                <div class="input-icon-container">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    <input type="text" class="search-input" placeholder="Buscar por teléfono" id="searchTelefono">
                                </div>
                            </td>
                            <td>
                                <div class="input-icon-container">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    <input type="text" class="search-input" placeholder="Buscar por ciudad" id="searchCiudad">
                                </div>
                            </td>
                            <td>
                                <div class="input-icon-container">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    <input type="text" class="search-input" placeholder="Buscar por departamento" id="searchDepartamento">
                                </div>
                            </td>
                                <td></td>
                            </tr>
                            @foreach($empleados as $empleado)
                            <tr>
                               
                                <td></td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input empleado-checkbox" type="checkbox">
                                    </div>
                                </td>
                                <td>{{ $empleado->nombres }}</td>
                                <td>{{ $empleado->identificacion }}</td>
                                <td>{{ $empleado->direccion }}</td>
                                <td>{{ $empleado->telefono }}</td>
                                <td>{{ $empleado->ciudad }}</td>
                                <td>{{ $empleado->departamento }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a  class="btn-action"  onclick="EditarEmpleado('{{ $empleado->id }}')" >
                                            <i class="fa fa-edit"></i>
                                        </a>
                                       
                                            <button type="button" class="btn-action" onclick="Deleempleado('{{ $empleado->id }}', '{{ $empleado->nombres }}')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

   
    </div>


<div class="modal fade"  id="modalcreate" tabindex="-1" role="dialog" aria-labelledby="modalcreateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo empleado</h5>
                <button type="button" class="btn-close"  data-dismiss="modal" aria-label="Close" ></button>
            </div>
            <div class="modal-body" id="modal-body">
         
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveempleado">Guardar</button>
            </div>
        </div>
    </div>
</div>


    <div class="modal fade"  id="modaledit" tabindex="-1" role="dialog" aria-labelledby="modaleditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
                    <div class="modal-content">
                                <div class="modal-header" style="background-color: #4040ff;  color: white; ">
                                    <h5 class="modal-title" style="color: white;">Editar Empleado</h5>
                                        <button type="button" class="btn-close"  data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                    <div class="modal-body" id="modal-bodyEdit">
                                
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close" >Cancelar</button>
                                        <button type="button" class="btn btn-primary" id="Editarempleado">Guardar</button>
                                    </div>
                    </div>
            </div>
    </div>




    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar a <strong id="userName"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <a id="confirmDelete" class="btn btn-danger">Sí, eliminar</a>
            </div>
        </div>
    </div>
</div>
@endsection