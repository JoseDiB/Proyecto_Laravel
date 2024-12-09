@extends('plantilla')
@section('title', 'Configuración de la Aplicación')
@section('content')
<div class="contenedor" id="configuracion-contenedor">
    <form action="guardarConfiguracion" method="POST" class="formulario-configuracion" id="formulario-configuracion">
        @csrf
        <div class="campo" id="campo-provincia">
            <label for="provincia_default" class="etiqueta" id="etiqueta-provincia">Provincia por defecto:</label>
            <input type="text" id="provincia_default" name="provincia_default" placeholder="Ingresa la provincia" class="input" />
        </div>
        <div class="campo" id="campo-poblacion">
            <label for="poblacion_default" class="etiqueta" id="etiqueta-poblacion">Población por defecto:</label>
            <input type="text" id="poblacion_default" name="poblacion_default" placeholder="Ingresa la población" class="input" />
        </div>
        <div class="campo" id="campo-zona">
            <label for="zona_default" class="etiqueta" id="etiqueta-zona">Zona por defecto:</label>
            <input type="text" id="zona_default" name="zona_default" placeholder="Ingresa la zona" class="input" />
        </div>
        <div class="campo" id="campo-elementos">
            <label for="elementos_por_pagina" class="etiqueta" id="etiqueta-elementos">Elementos por página:</label>
            <input type="number" id="elementos_por_pagina" name="elementos_por_pagina" value="<?php echo $tema = $_SESSION['config']['elementos_por_pagina'] ?? '6'; ?>" placeholder="Número de elementos" class="input" />
        </div>
        <div class="campo" id="campo-sesion">
            <label for="tiempo_sesion" class="etiqueta" id="etiqueta-sesion">Tiempo de sesión (en segundos):</label>
            <input type="number" id="tiempo_sesion" name="tiempo_sesion" value="<?php echo $tema = $_SESSION['config']['tiempo_sesion'] ?? '6'; ?>" placeholder="Tiempo en segundos" class="input" />
        </div>
        <div class="campo" id="campo-tema">
            <label for="tema" class="etiqueta" id="etiqueta-tema">Tema de la aplicación:</label>
            <select id="tema" name="tema" class="select">
                <option value="oscuro" <?php echo ($_SESSION['config']['tema'] ?? '') === 'oscuro' ? 'selected' : ''; ?>>Oscuro</option>
        <option value="claro" <?php echo ($_SESSION['config']['tema'] ?? '') === 'claro' ? 'selected' : ''; ?>>Claro</option>
            </select>
        </div>
        <button type="submit" class="boton" id="boton-guardar">Guardar Configuración</button>
    </form>
</div>
@endsection
