<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
@extends('plantilla')
@section('title', 'Lista de tareas pendientes')
@section('content')
<div id="contenido">
    <div id="cajaTabla">
        <table id="tablaTareas">
            <thead>
                <th>Nombre</th>
                <th>NIF</th>
                <th>Provincia</th>
                <th>Fecha de Realización</th>
                <th>Estado</th>
            </thead>
            <tbody>
                @foreach ($datosPaginacion['tareas'] as $tarea)
                    <tr>
                        <td>{{ $tarea['nombre'] }}, {{ $tarea['apellidos'] }}</td>
                        <td>{{ $tarea['nif'] }}</td>
                        <td>{{ $tarea['provincia'] }}</td>
                        <?php $fecha_obj = new DateTime($tarea['fecharealizacion']);?>
                        <td><?php echo $fecha_obj->format('d/m/Y');?></td>
                        @if ($tarea['estado'] == 'P')
                        <td>Pendiente</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div id="paginacion">
        @if ($datosPaginacion['paginaActual'] > 1)
            <a href="?page=1" class="btn">Primera</a>
            <a href="?page={{ $datosPaginacion['paginaActual'] - 1 }}" class="btn">Anterior</a>
        @endif

        @for ($i = 1; $i <= $datosPaginacion['totalPaginas']; $i++)
            <a href="?page={{ $i }}"
                class="btn {{ $i == $datosPaginacion['paginaActual'] ? 'active' : '' }}">{{ $i }}</a>
        @endfor

        @if ($datosPaginacion['paginaActual'] < $datosPaginacion['totalPaginas'])
            <a href="?page={{ $datosPaginacion['paginaActual'] + 1 }}" class="btn">Siguiente</a>
            <a href="?page={{ $datosPaginacion['totalPaginas'] }}" class="btn">Última</a>
        @endif
    </div>
</div>
@endsection