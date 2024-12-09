@extends('plantilla')
@section('title', 'Editar Usuario')
@section('content')
<div class="formulario-contenedor">
    <form action="{{ mi_route('actualizarUsuario',['id' => $datosUsuario['id']]) }}" method="POST">
        @csrf
        <h1>Modificar Usuario</h1>
        <div class="grupo-formulario">
            <label for="nombre">Nombre de Usuario</label>
            <input type="text" id="nombre" name="nombre" placeholder="Escribe el nuevo nombre" value="<?php echo $datosUsuario['nombre']?>">
        </div>
        <div class="grupo-formulario">
            <label for="contraseña">Nueva Contraseña</label>
            <input type="text" id="contraseña" name="contraseña" placeholder="Escribe la nueva contraseña" value="<?php echo $datosUsuario['contrasena']?>">
        </div>
        <button type="submit" class="boton-enviar">Actualizar</button>
    </form>
</div>
@endsection