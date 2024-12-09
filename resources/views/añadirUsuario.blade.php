@extends('plantilla')
@section('title', 'Añadir Usuarios')
@section('content')
<div class="formulario-contenedor">
    <form id="formAñadirU" action="{{ mi_route('añadir') }}" method="POST">
        @csrf
        <h1>Registro de Usuario</h1>
        <div class="grupo-formulario">
            <label for="usuario">Nombre de Usuario</label>
            <input type="text" id="usuario" name="usuario" placeholder="Escribe tu nombre de usuario">
        </div>
        <div class="grupo-formulario">
            <label for="contraseña">Contraseña</label>
            <input type="password" id="contraseña" name="contraseña" placeholder="Escribe tu contraseña">
        </div>
        <div class="grupo-formulario">
            <label for="rol">Rol</label>
            <select id="rol" name="rol">
                <option value="" disabled selected>Selecciona un rol</option>
                <option value="1">Administrador</option>
                <option value="0">Operador</option>
            </select>
        </div>
        <button type="submit" class="boton-enviar">Añadir Usuario</button>
    </form>
</div>

@endsection