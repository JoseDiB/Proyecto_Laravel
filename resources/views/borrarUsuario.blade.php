@extends('plantilla')
@section('title', 'Borrar Usuario')
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
                    <th>Acciones</th>
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
                    <td>
                        <a href="{{ mi_route('eliminar-usuario',['id' => $usuario['id']]) }}" class="btn-eliminar">Eliminar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
