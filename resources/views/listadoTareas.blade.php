<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
@extends('plantilla')
@section('title', 'Listado de Tareas')
@section('content')
    <div id="contenido">
        <div id="cajaFiltrado">
            <?php
            ?>
            <form action="{{ mi_route('filtrar') }}" method="POST">
                @csrf
                <div>
                    <label for="">Campo:</label>
                    <select name="campo" id="">
                        <option selected disabled value="">Selecciona un campo:</option>
                        <option value="nombre">Nombre</option>
                        <option value="nif">Nif</option>
                        <option value="provincia">Provincia</option>
                        <option value="fecharealizacion">Fecha de realización</option>
                        <option value="estado">Estado</option>
                    </select>
                </div>
                <div><label for="">Criterio:</label>
                    <select name="operador" id="">
                        <option selected disabled value="">Seleccione un operador:</option>
                        <option value="=">=</option>
                        <option value=">">></option>
                        <option value="<">
                            << /option>
                    </select>
                </div>
                <div><label for="">Valor:</label>
                    <input type="text" name="valor" id="">
                </div>
                <button type="submit">Filtrar</button>
            </form>
        </div>
        <div id="cajaTabla">
            <table id="tablaTareas">
                <thead>
                    <th>Nombre</th>
                    <th>NIF</th>
                    <th>Provincia</th>
                    <th>Fecha de Realización</th>
                    <th>Estado</th>
                    <th colspan="4">Operaciones</th>
                </thead>
                <tbody>
                    @foreach ($datosPaginacion['tareas'] as $tarea)
                        <tr>
                            <td>{{ $tarea['nombre'] }}, {{ $tarea['apellidos'] }}</td>
                            <td>{{ $tarea['nif'] }}</td>
                            <td>{{ $tarea['provincia'] }}</td>
                            <?php $fecha_obj = new DateTime($tarea['fecharealizacion']);?>
                            <td><?php echo $fecha_obj->format('d/m/Y');?></td>
                            @if ($tarea['estado'] == 'B')
                            <td>Esperando ser aprobada</td>
                            @endif
                            @if ($tarea['estado'] == 'P')
                            <td>Pendiente</td>
                            @endif
                            @if ($tarea['estado'] == 'R')
                            <td>Realizada</td>
                            @endif
                            @if ($tarea['estado'] == 'C')
                            <td>Cancelada</td>
                            @endif
                            @if ($_SESSION['usuario']['datos']['rol'] == 1)
                                <td><a href='{{ mi_route('borrar') }}?id={{ $tarea['id'] }}'>Borrar</a></td>
                                <td><a href='{{ mi_route('modificar') }}?id={{ $tarea['id'] }}'>Modificar</a></td>
                            @endif
                            @if ($_SESSION['usuario']['datos']['rol'] == 0)
                                <td><a href='{{ mi_route('completar') }}?id={{ $tarea['id'] }}'>Completar</a></td>
                            @endif
                            <td><a href='{{ mi_route('verDetalles') }}?id={{ $tarea['id'] }}'>Ver detalles</a></td>
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
