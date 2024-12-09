@extends('plantilla')
@section('title', 'Borrar Tarea')
@section('content')
    <div id="confBorrar">
        <table></table>
        <h2>¿Estás seguro de eliminar esta tarea?</h2>
        <table>
            <tbody>
                <tr>
                    <td><strong>Nombre y Apellidos:</strong></td>
                    <td><strong>NIF:</strong></td>
                    
                </tr>
                <tr>
                    <td>{{ $datoTarea['nombre'] }}, {{ $datoTarea['apellidos'] }}</td>
                    <td>{{ $datoTarea['nif'] }}</td>
                </tr>
                <tr>
                    <td><strong>Estado:</strong></td>
                    <td><strong>Email:</strong></td>
                </tr>
                <tr>
                    <td>{{ $datoTarea['estado'] }}</td>
                    <td>{{ $datoTarea['email'] }}</td>
                </tr>
                <tr>
                    <td><strong>Teléfono:</strong></td>
                    <td><strong>Descripción:</strong></td>
                </tr>
                <tr>
                    <td>{{ $datoTarea['telefono'] }}</td>
                    <td>{{ $datoTarea['descripcion'] }}</td>
                </tr>
            </tbody>
        </table>
        <form action="{{ mi_route('eliminar-tarea',['id' => $_GET['id']]) }}" method="POST">
            @csrf
            <button type="submit" id="borrar">Borrar</button>
        </form>
        
    </div>
@endsection
