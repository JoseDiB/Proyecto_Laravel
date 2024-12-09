<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="contenedor-login">
        <div class="caja-login">
            <h1>Iniciar Sesión</h1>
            <form action="{{ mi_route('iniciar-sesion') }}" method="POST">
                @csrf
                <div class="grupo-input">
                    <label for="usuario">Usuario</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Ingresa tu usuario"
                        value="<?php echo isset($_COOKIE['nombreUsuario']) ? htmlspecialchars($_COOKIE['nombreUsuario']) : ''; ?>" />
                </div>
                <div class="grupo-input">
                    <label for="contraseña">Contraseña</label>
                    <input type="password" id="contraseña" name="contraseña" placeholder="Ingresa tu contraseña">
                </div>
                <div class="grupo-input recuerdame">
                    <label for="recuerdame">Recordarme</label>
                    <input type="checkbox" id="recuerdame" name="recuerdame">
                    
                </div>
                <button type="submit" class="boton-login">Entrar</button>
                <p class="link-registro">
                    ¿No tienes una cuenta? <a href="/registro">Regístrate aquí</a>
                </p>
            </form>
        </div>
    </div>
</body>

</html>
