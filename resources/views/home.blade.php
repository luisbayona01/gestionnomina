@extends('layouts.plantilla')

@section('content')
<style>
    :root {
            --primary-color: #6f42c1;
        }

        body {
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .welcome-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .profile-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .profile-upload {
            width: 69px;
            height: 69px;
            background-color: #f8f9fa;
            border: 2px dashed var(--primary-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin-bottom: 0.5rem;
        }

        .profile-upload:hover {
            background-color: #e9ecef;
        }

        .profile-container a {
            display: block;
            text-decoration: none;
            color: var(--primary-color);
            font-weight: 500;
            font-size: 1rem;
            margin-top: 0.5rem;
        }

        .profile-container a:hover {
            color: #5a32b1;
        }

        .illustration {
            position: relative;
        }

        .illustration::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: rgba(111, 66, 193, 0.1);
            border-radius: 50%;
            transform: scale(1.2);
            z-index: -1;
        }

        .welcome-text {
            color: #2c3e50;
            margin-bottom: 2rem;
        }

        .instruction-text {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 2rem;
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
                //location.reload(); 
            } else {
                toastr.error(data.message); 
            }
        })
        .catch(error => console.error("Error en la solicitud:", error));
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
    });
});
</script>

<div class="container-fluid">
        <div class="row welcome-container">
            <div class="col-md-6 p-5">
                <div class="text-center">
                    <h1 class="welcome-text">Te damos la bienvenida</h1>
                    <h2 class="h4 mb-4">{{Auth::user()->name}}</h2>
                    <p class="instruction-text">Añade los datos personales de tus empleados y después agrega su cargo en tu empresa</p>
                    
                    <!-- Contenedor del icono y el enlace -->
                    <div class="profile-container">
                    <a   id="create-empleado" data-toggle="modal" data-target="#modalcreate">    
                    <div class="profile-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                                <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664z"/>
                                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                            </svg>
                        </div>
                        Empieza aquí</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 d-none d-md-block">
                <div class="illustration position-relative">
                    <img src="{{asset('images/logo-home.png') }}" alt="Ilustración" class="img-fluid">
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


   
         @endsection

       

