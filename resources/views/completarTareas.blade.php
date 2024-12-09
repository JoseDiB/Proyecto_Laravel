@extends('plantilla')
@section('title', 'Completar Tarea')
@section('content')
    {{-- $hash = hash_hmac('sha256', $id, $secretKey);
$hashEsperado = hash_hmac('sha256', $id, $secretKey); --}}
    {{-- {{var_dump($datoTarea)}} --}}
    <?php
    session_start();
    $_SESSION['completar_id'] = (int) $datoTarea['id'];
    ?>
    <form id="completarTarea" action="{{ mi_route('accionCompletar') }}" method="post" enctype="multipart/form-data">
        @csrf 
        <label for="">Estado:</label>
        <input type="radio" name="estado" value="Completado" checked> Completado
        <br>
        <input type="radio" name="estado" value="Cancelado"> Cancelado
        <br>
        <?php $_POST['id'] = $datoTarea['id']; ?>
        <label for="">Fecha de realización:</label>
        <input type="date" name="fecharealizacion" id="fechaRealizacion"
            value="{{ $datoTarea['fecharealizacion'] ?? '' }}">
        <label for="">Anotaciónes posteriores:</label>
        <textarea name="anotacionesposteriores" id="" cols="30" rows="10">{{ $datoTarea['anotacionesposteriores'] ?? '' }}</textarea>
        <label for="archivo">Subir archivo:</label>
        <input type="file" name="archivo" id="archivo">
        <label for="imagenes">Selecciona una imagen:</label>
        <input type="file" name="imagenes" id="imagenes">
        <button type="submit">Completar Tarea</button>
    </form>
@endsection
