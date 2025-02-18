<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/login.css')  }}">
     <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }} ">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="{{asset('js/toastr.min.js')}}"></script>
 
</head>
<body>
    <div class="login-container">
        <div class="left-side d-none d-md-flex">
            <div>
                <h1>Bienvenido a la mejor plataforma organizacional online</h1>
                <p>Gestión efectiva del talento humano</p>
            </div>
        </div>
        <div class="right-side">
            <div class="login-box">
                <img src="/images/logo.png" alt="Logo">
                <form class="
                mx-auto  needs-validation" novalidate id="loginform">
                    <div class="mb-3 text-start">
                        <label class="form-label">email</label>
                        <input type="email" class="form-control radius" id="email" placeholder="email">
                        <span class="invalid-feedback" role="alert">
                                        el campo email es obligatorio
                                    </span>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label">Contraseña</label>
                        <div class="input-group">
                            <input type="password"  class="form-control radius" id="password" placeholder="Contraseña">
                            <span class="input-group-text" id="togglePassword">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        <span class="invalid-feedback" role="alert">
                                        el campo Contraseña es obligatorio
                                    </span>
                    </div>
                    <div class="mb-3 d-flex align-items-center gap-2">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Recordar cuenta</label>
                    </div>
                    <button type="button" id="login" class="btn btn-primary radius">Iniciar sesión

                    <span class="spinner-border spinner-border-sm mr-2" style="display:none;"
                    id="loading2"></span>
                     
                    </button>
                </form>
                <div class="forgot-links mt-3">
                    <a href="#">¿Olvidaste tu usuario?</a>
                    <a href="#">¿Olvidaste tu contraseña?</a>
                </div>
            </div>
        </div>
    </div>

  
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <script>
        $("#togglePassword").click(function() {
            let passwordField = $("#password");
            let type = passwordField.attr("type") === "password" ? "text" : "password";
            passwordField.attr("type", type);
            $(this).find("i").toggleClass("fa-eye fa-eye-slash");
        });

        $("#login").click(function() {
            //console.log('aaaa');
            $("#loading2").show();
            let isValid = document.querySelector('#loginform').reportValidity();

            if (isValid == false) {
                $('#loginform').addClass('was-validated')
                $("#loading2").hide();
                //return false;
            } else {

                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                const datosFormulario = new FormData();
                datosFormulario.append('email', $("#email").val())
                datosFormulario.append('password', $("#password").val())
               
                datosFormulario.append('_token', csrfToken);

                fetch("/login", {
                        method: 'POST',
                        body: datosFormulario
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('La respuesta de la red no fue correcta');
                        }
                        return response
                            .json();
                    })
                    .then(data => {
                        // Manejar la respuesta exitosa
                        if (data['ok'] == false) {
                            toastr.error(data['user'])
                        } else {
                            //var token = data.token;
                            window.location.href = "/home";

                        }

                        //alert("success");
                        $("#loading2").hide();
                    })
                    .catch(error => {
                        // Manejar errores
                        console.error('There was a problem with the fetch operation:', error);
                        console.log("error");
                        $("#loading2").hide();
                    })

            }


        })
    </script>
</body>
</html>
