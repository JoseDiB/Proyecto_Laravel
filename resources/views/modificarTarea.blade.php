@extends('plantilla')
@section('title', 'Modificar Tarea')
@section('content')
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $errors = $_SESSION['errores'] ?? [];
    $verdadero = $_SESSION['flash']['mod'] ?? [];
    ?>

    <form action="{{ mi_route('errores') }}" method="post" class="FormularioTarea" enctype="multipart/form-data">
        <fieldset>
            <legend><strong> Modificar Tarea</strong></legend>
            @if (isset($verdadero) && $verdadero != null)
                <div id="correcto">{{ $verdadero }}</div>
            @endif
            @csrf
            <input hidden name="formilarioMod"type="text" value="mod">
            <input hidden name="id"type="number" value="<?php echo $_GET['id']; ?>">
            <label for="NIF">NIF/CIF:</label>
            <input name="NIF" type="text" value="{{ $datoTarea['nif'] }}"><br>

            @if (isset($errors['NIF']))
                <div class="error">{{ $errors['NIF'] }}</div>
            @endif
            <br><br>

            <label for="nombre">Nombre:</label>
            <input name="nombre" type="text" value="{{ $datoTarea['nombre'] ?? '' }}"><br>
            @if (isset($errors['nombre']))
                <div class="error">{{ $errors['nombre'] }}</div>
            @endif
            <br><br>

            <label for="apellidos">Apellidos:</label>
            <input name="apellidos" type="text" value="{{ $datoTarea['apellidos'] ?? '' }}"><br>
            @if (isset($errors['apellidos']))
                <div class="error">{{ $errors['apellidos'] }}</div>
            @endif
            <br><br>

            <label for="telefono">Teléfono:</label>
            <input name="telefono" type="text" value="{{ $datoTarea['telefono'] ?? '' }}"><br>
            @if (isset($errors['telefono']))
                <div class="error">{{ $errors['telefono'] }}</div>
            @endif
            <br><br>

            <label for="descripcion">Descripción de la tarea:</label><br>
            <textarea name="descripcion">{{ $datoTarea['descripcion'] ?? '' }}</textarea><br>
            @if (isset($errors['descripcion']))
                <div class="error">{{ $errors['descripcion'] }}</div>
            @endif
            <br><br>

            <label for="email">Correo electrónico:</label>
            <input name="email" type="text" value="{{ $datoTarea['email'] ?? '' }}"><br>
            @if (isset($errors['email']))
                <div class="error">{{ $errors['email'] }}</div>
            @endif
            <br><br>

            <label for="direccion">Dirección:</label>
            <input name="direccion" type="text" value="{{ $datoTarea['direccion'] ?? '' }}"><br>
            @if (isset($errors['direccion']))
                <div class="error">{{ $errors['direccion'] }}</div>
            @endif
            <br><br>

            <label for="poblacion">Población:</label>
            <input name="poblacion" type="text" value="{{ $datoTarea['poblacion'] ?? '' }}"><br>
            @if (isset($errors['poblacion']))
                <div class="error">{{ $errors['poblacion'] }}</div>
            @endif
            <br><br>

            <label for="codigoPostal">Código postal:</label>
            <input name="codigoPostal" type="text" value="{{ $datoTarea['codigopostal'] ?? '' }}"><br>
            @if (isset($errors['codigoPostal']))
                <div class="error">{{ $errors['codigoPostal'] }}</div>
            @endif
            <br><br>

            <label for="provincia">Seleccione una provincia:</label>
            <select name="provincia" id="provincia">
                <option selected disabled value="">Seleccione una provincia:</option>
                @foreach ($datosProvincias as $provincia)
                    <option value="{{ $provincia['nombre'] }}">
                        {{ $provincia['nombre'] }}
                    </option>
                @endforeach
            </select><br>
            @if (isset($errors['provincia']))
                <div class="error">{{ $errors['provincia'] }}</div>
            @endif
            <br><br>

            <label for="estado">Eliga el estado de la tarea:</label>
            <select name="estado" id="estado">
                <option selected disabled value="">Seleccione un estado de tarea:</option>
                <option value="B" {{ $infoAntigua['estado'] ?? '' == 'B' ? 'selected' : '' }}>Esperando ser aprobada
                </option>
                <option value="P" {{ $infoAntigua['estado'] ?? '' == 'P' ? 'selected' : '' }}>Pendiente</option>
                <option value="R" {{ $infoAntigua['estado'] ?? '' == 'R' ? 'selected' : '' }}>Realizada</option>
                <option value="C" {{ $infoAntigua['estado'] ?? '' == 'C' ? 'selected' : '' }}>Cancelada</option>
            </select><br>
            @if (isset($errors['estado']))
                <div class="error">{{ $errors['estado'] }}</div>
            @endif
            <br><br>

            <label for="operario">Operario encargado</label>
            <select name="operario" id="operario">
                <option selected disabled value="">Seleccione un operario:</option>
                @foreach ($datosUsuarios as $usuario)
                    <option value="{{ $usuario['id'] }}">
                        {{ $usuario['nombre'] }}
                    </option>
                @endforeach
            </select><br>
            @if (isset($errors['operario']))
                <div class="error">{{ $errors['operario'] }}</div>
            @endif
            <br><br>
            <?php var_dump($infoAntigua['fechaRealizacion'] ?? ''); ?>
            <label for="fechaRealizacion">Fecha de realización:</label><br>
            <input name="fechaRealizacion" type="date" value="{{ $datoTarea['fechaRealizacion'] ?? '' }}"><br>
            @if (isset($errors['fechaRealizacion']))
                <div class="error">{{ $errors['fechaRealizacion'] }}</div>
            @endif
            <br><br>

            <label for="anotacionesAnteriores">Anotaciones anteriores:</label><br>
            <textarea name="anotacionesAnteriores" id="anotacionesAnteriores">{{ $datoTarea['anotacionesAnteriores'] ?? '' }}</textarea><br>
            @if (isset($errors['anotacionesAnteriores']))
                <div class="error">{{ $errors['anotacionesAnteriores'] }}</div>
            @endif
            <br><br>

            <label for="anotacionesPosteriores">Anotaciones posteriores:</label><br>
            <textarea name="anotacionesPosteriores" id="anotacionesPosteriores">{{ $datoTarea['anotacionesPosteriores'] ?? '' }}</textarea><br>
            @if (isset($errors['anotacionesPosteriores']))
                <div class="error">{{ $errors['anotacionesPosteriores'] }}</div>
            @endif
            <br><br>
            <label for="archivo">Subir archivo:</label>
            <input type="file" name="archivo" id="archivo">
            <label for="imagenes">Foto del trabajo realizado:</label>
            <input type="file" name="imagenes" id="imagenes">
            <?php
            $formato = 'Y-m-d';
            $fechaActual = date($formato);
            ?>
            <input hidden name="fechacreacion"type="date" value="<?php echo $fechaActual; ?>">

            <button type="submit">Enviar</button>
        </fieldset>
    </form>
    <?php
    if (isset($_SESSION['flash']['errores'])) {
        unset($_SESSION['flash']['errores']);
    }
    if (isset($_SESSION['flash']['errores'])) {
        unset($_SESSION['flash']['añadido']);
    }
    ?>
@endsection
