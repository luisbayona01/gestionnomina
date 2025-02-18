<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="shortcut icon" href="{{ asset('img/Isotipo-Krypto.ico') }}" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
   
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <script src="{{ asset('js/toastr.min.js') }}"></script>

    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>




    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">


    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="{{ asset('css/light.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}"rel="stylesheet">


</head>

<body data-theme="light">
    <div id="app">

        <div class="wrapper">
            <nav id="sidebar" class="sidebar js-sidebar">
                <div class="sidebar-content js-simplebar">
                  

                    <ul class="sidebar-nav">
                        <li class="sidebar-header">

                        </li>

                        <a href="{{ url('/home') }}" class="sidebar-link collapsed">

                            <i class="fa fa-home"></i> <span class="align-middle">inicio</span>
                        </a>

                        <li class="sidebar-item ">

                            <a data-bs-target="#lista" data-bs-toggle="collapse" class="sidebar-link collapsed">

                                <i class="fa fa-users"></i> <span class="align-middle">
                                    lista</span>
                            </a>
                            <ul id="lista" class="sidebar-dropdown list-unstyled collapse"
                                data-bs-parent="#sidebar">

                                <li class="sidebar-item"><a class="sidebar-link" href="{{ url('/empleados') }}">Empleados </a></li>
                                <li class="sidebar-item"><a class="sidebar-link"
                                        href="{{ url('/categoriaproductos') }}">cargos </a>
                                </li>
                            </ul>

                     


                    
                </div>
            </nav>

            <div class="main">
                <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle d-flex align-items-center">
    <i class="hamburger align-self-center"></i>
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="ms-4" style="height: 30px;">
</a>
                    <div class="float-start">

                    </div>
                    <div class="navbar-collapse collapse">

                        <ul class="navbar-nav navbar-align">



                            <li class="nav-item dropdown">
                                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#"
                                    data-bs-toggle="dropdown">
                                 <span class="text-dark"> {{ Auth::user()->name }}
                                  </span>
                                    <i class="align-middle" data-feather="settings"> </i>
                                </a>

                                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#"
                                    data-bs-toggle="dropdown">
                                    <span class="text-dark"> {{ Auth::user()->name }}
                                         </span>
                                    <img src="{{ asset('images/perfil.jpg') }}" class="avatar img-fluid rounded me-1"
                                        alt="" />
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href=""><i class="align-middle me-1"
                                            data-feather="user"></i>{{ Auth::user()->name }}</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="index.html"><i class="align-middle me-1"
                                            data-feather="settings"></i> Settings & Privacy</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href=""
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    {{ __('Logout') }}
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>



                <main class="content">
                   
                        @yield('content')
               
                </main>

            </div>


            @yield('scripts')
</body>

</html>
