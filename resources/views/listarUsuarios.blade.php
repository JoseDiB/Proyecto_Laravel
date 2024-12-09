@extends('plantilla')
@section('title', 'Lista de Usuarios')
@section('content')
    <div class="contenedorU">
        <h1>Listado de Usuarios</h1>
        <table class="tabla-usuarios">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Contraseña</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datosUsuarios as $usuario)
                <tr>
                    <td>{{$usuario['id']}}</td>
                    <td>{{$usuario['nombre']}}</td>
                    <td>{{$usuario['contrasena']}}</td>
                    @if($usuario['rol'] == 1)
                    <td>Administrador/a</td>
                    @endif
                    @if($usuario['rol'] == 0)
                    <td>Operador/a</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection