<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$tema = $_SESSION['config']['tema'] ?? 'claro'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Página Principal')</title>
    <link rel="stylesheet" href="css/style-<?php echo $tema ?>.css">
    <link rel="stylesheet" href="css/inicioSesion-<?php echo $tema ?>.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

    <aside id="asideIzquierdo">
        <ul>
            <li><a href="{{ mi_route('/listadoTareas') }}">Inicio</a></li>
            <li><a href="{{ mi_route('tarea') }}">Añadir Tarea</a></li>
            <li><a href="{{ mi_route('tareasPendientes') }}">Listar tareas pendientes</a></li>
            @if ($_SESSION['usuario']['datos']['rol'] == 1)
                <li><a href="{{ mi_route('añadirUsuario') }}">Añadir Usuario</a></li>
                <li><a href="{{ mi_route('eliminar') }}">Eliminar Usuario</a></li>
                <li><a href="{{ mi_route('listarUsuario') }}">Listar usuarios</a></li>
            @endif
            <li><a href="{{ mi_route('editarUsuario') }}">Editar usuario</a></li>
        </ul>
    </aside>

    <header id="encabezado">
        <h1>@yield('title', 'Página Principal')</h1>
        <div id="cajaCerrarSesion">
            <div>
               @if ($_SESSION['usuario']['datos']['rol'] == 1) 
                <span>
                    Administrador/a: <?php echo $_SESSION['usuario']['datos']['nombre']; ?>
                </span>                    
                @else 
                <span>
                    Operador/a: <?php echo $_SESSION['usuario']['datos']['nombre']; ?>
                </span>   
                @endif
                <span class="hora">
                    Hora inicio sesion: <?php $fecha_obj = new DateTime($_SESSION['usuario']['hora']); echo $fecha_obj->format('d/m/Y H:i:s');?>
                </span>
                <a href="{{ mi_route('cerrarSesion') }}">Cerrar Sesión</a>
            </div>
            <div id="imagen">
                <a href="{{ mi_route('configuracion') }}"><img id="imagen-config" src="images/icono-config.png" alt="Configuracion"></a>
            </div>
        </div>
    </header>

    <div id="cuerpo">
        @yield('content')
    </div>
    <footer id="footer">

    </footer>
</body>

</html>
