<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Aplicación')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        footer {
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
    <link href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
</head>

<body>
    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="/logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                Mi Aplicación
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/cocktails-api') }}">Nuevos cocktails</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/cocktails') }}">Cocktails existentes</a>
                    </li>
                    @endauth
                </ul>
                <ul class="navbar-nav">
                    @auth
                    <li class="nav-item">
                        <span class="nav-link">Hola, {{ Auth::user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Registro</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container my-4">
        @yield('content')
    </div>

    <!-- Pie de Página -->
    <footer class="bg-light text-center py-3">
        <p class="mb-0">© 2024 Mi Aplicación. Todos los derechos reservados.</p>
    </footer>

    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Registro de Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registerForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div id="registerError" class="text-danger"></div>
                        <button type="submit" class="btn btn-primary w-100">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Iniciar Sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm">
                        @csrf <!-- Token CSRF -->
                        <div class="mb-3">
                            <label for="emailLogin" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="emailLogin" name="emailLogin" required>
                        </div>
                        <div class="mb-3">
                            <label for="passwordLogin" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="passwordLogin" name="passwordLogin" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#registerForm').on('submit', function(e) {
                e.preventDefault(); // Prevenir el envío del formulario tradicional

                const formData = {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    _token: $('input[name="_token"]').val() // CSRF token
                };

                $.ajax({
                    url: '{{ route('register') }}', // Ruta al controlador de registro
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        
                        Swal.fire({
                            title: 'Mensaje',
                            text: 'El registro se creó exitosamente',
                            icon: 'success',
                        })

                        $('#registerModal').modal('hide');
                        $('#registerForm')[0].reset(); // Reiniciar el formulario
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessages = '';
                        for (let key in errors) {
                            errorMessages += errors[key] + '<br>';
                        }
                        $('#registerError').html(errorMessages);
                    }
                });
            });


            $('#loginForm').on('submit', function(e) {
                e.preventDefault(); // Evita el envío tradicional del formulario

                // Obtén los datos del formulario
                const email = $('#emailLogin').val();
                const password = $('#passwordLogin').val();

                // Enviar datos al servidor usando AJAX
                $.ajax({
                    url: '{{ route("login") }}', // Ruta de login definida en Laravel
                    method: 'POST',
                    data: {
                        email: email,
                        password: password
                    },
                    success: function(response) {
                        // Si el inicio de sesión fue exitoso
                        if (response.message === 'Inicio de sesión exitoso.') {
                            alert(response.message);
                            location.reload(); // Refresca la página
                        }
                    },
                    error: function(xhr) {
                        // Manejar errores
                        if (xhr.status === 401) {
                            alert('Credenciales inválidas. Por favor, verifica tus datos.');
                        } else {
                            alert('Ocurrió un error inesperado. Inténtalo nuevamente.');
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>