<?php
/**
 * @file Ayuda.php
 * 
 * @author José Díaz Bourre
 * @date 2024-12-08
 * @version 1.0
 * 
 * 
 * @brief Genera una URL basada en rutas con nombre y parámetros.
 * 
 * Esta función permite obtener una URL completa para rutas definidas manualmente, 
 * con la posibilidad de reemplazar parámetros dinámicos en la ruta.
 * 
 * @param string $name Nombre de la ruta.
 * @param array $parameters [Opcional] Arreglo asociativo de parámetros dinámicos 
 *                           a reemplazar en la ruta. Ejemplo: `['id' => 1]`.
 * 
 * @return string URL completa de la ruta generada.
 * 
 * @throws InvalidArgumentException Si el nombre de la ruta no está definido en `$routes`.
 * 
 * @details
 * Las rutas se definen manualmente en un arreglo `$routes`. La función verifica 
 * si la ruta existe, reemplaza los parámetros dinámicos definidos como `{param}` 
 * y retorna la URL completa con la base definida en `$baseUrl`.
 * 
 * @example
 * ```php
 * echo mi_route('eliminar-tarea', ['id' => 5]);
 * // Resultado: http://localhost/Proyecto_Laravel/public/eliminar_tarea/5
 * ```
 */
function mi_route($name, $parameters = [])
{
    // Definir manualmente las rutas con nombre
    $routes = [
        'iniciar-sesion' => '/inicioSesion',
        '/listadoTareas' => '/listadoTareas',
        'tarea' => '/tarea',
        'tareasPendientes' => '/tareasPendientes',
        'modificar' => '/modificar',
        'borrar' => '/borrar',
        'eliminar-tarea' => '/eliminar_tarea/{id}',
        'verDetalles' => '/verDetalles',
        'completar' => '/completarTareas',
        'accionCompletar' => '/accionCompletar',
        'filtrar' => '/filtrarTarea',
        'errores' => '/errores',
        'errores.detalle' => '/errores/{id}',
        'cerrarSesion' => '/cerrarSesion',
        'añadirUsuario' => '/añadirUsuario',
        'añadir' => '/añadir',
        'eliminar' => '/eliminarUsuario',
        'eliminar-usuario' => '/eliminar-usuario/{id}',
        'listarUsuario' => '/listarUsuario',
        'editarUsuario' => '/editarUsuario',
        'actualizarUsuario' => '/actualizarUsuario/{id}',
        'configuracion' => '/configuracion',
        'guardarConfiguracion' => '/guardarConfiguracion'
    ];

    // Verificar si la ruta existe
    if (!isset($routes[$name])) {
        throw new InvalidArgumentException("La ruta con nombre '{$name}' no fue encontrada.");
    }

    // Obtener la ruta base
    $route = $routes[$name];

    // Reemplazar parámetros dinámicos en la ruta
    foreach ($parameters as $key => $value) {
        $route = str_replace("{{$key}}", $value, $route);
    }

    // Agregar la URL base (si es necesario)
    $baseUrl = 'http://192.168.1.136/Proyecto_Laravel/public'; 
    return $baseUrl . $route;
}
