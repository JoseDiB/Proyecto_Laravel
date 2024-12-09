@extends('plantilla')
@section('title', 'Detalles de la tarea')
@section('content')
    <div id="cuerpoDetalles">
        <div class="tablaDetalles">
            <div class="tituloDetalles">Datos Generales</div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NIF</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Teléfono</th>
                        <th>Descripción</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Población</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $datoTarea['id'] }}</td>
                        <td>{{ $datoTarea['nif'] }}</td>
                        <td>{{ $datoTarea['nombre'] }}</td>
                        <td>{{ $datoTarea['apellidos'] }}</td>
                        <td>{{ $datoTarea['telefono'] }}</td>
                        <td>{{ $datoTarea['descripcion'] }}</td>
                        <td>{{ $datoTarea['email'] }}</td>
                        <td>{{ $datoTarea['direccion'] }}</td>
                        <td>{{ $datoTarea['poblacion'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tablaDetalles">
            <div class="tituloDetalles">Detalles Adicionales</div>
            <table>
                <thead>
                    <tr>

                        <th>Código Postal</th>
                        <th>Provincia</th>
                        <th>Estado</th>
                        <th>Operario</th>
                        <th>Fecha Creación</th>
                        <th>Fecha Realización</th>
                        <th>Anotaciones Anteriores</th>
                        <th>Anotaciones Posteriores</th>
                        <th>Fichero Resumen</th>
                        <th>Fotos Trabajo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>

                        <td>{{ $datoTarea['codigopostal'] }}</td>
                        <td>{{ $datoTarea['provincia'] }}</td>
                        @if ($datoTarea['estado'] == 'B')
                            <td>Esperando ser aprobada</td>
                        @endif
                        @if ($datoTarea['estado'] == 'P')
                            <td>Pendiente</td>
                        @endif
                        @if ($datoTarea['estado'] == 'R')
                            <td>Realizada</td>
                        @endif
                        @if ($datoTarea['estado'] == 'C')
                            <td>Cancelada</td>
                        @endif
                        <td>{{ $datoTarea['operario'] }}</td>
                        <?php $fecha_obj = new DateTime($datoTarea['fechacreacion']); ?>
                        <td><?php echo $fecha_obj->format('d/m/Y'); ?></td>
                        <?php $fecha_obj = new DateTime($datoTarea['fecharealizacion']); ?>
                        <td><?php echo $fecha_obj->format('d/m/Y'); ?></td>
                        <td>{{ $datoTarea['anotacionesanteriores'] }}</td>
                        <td>{{ $datoTarea['anotacionesposteriores'] }}</td>
                        <td><a href="storage/uploads/archivos{{ $datoTarea['ficheroresumen'] }}"
                                download="resumen.pdf">Descargar Resumen</a></td>
                        <td><a href="storage/uploads/imagenes{{ $datoTarea['fotostrabajo'] }}" download="">Descargar
                                Imagen</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
