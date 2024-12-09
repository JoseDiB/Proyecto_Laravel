<?php
/**
 * @file Web.php
 * 
 * @author José Díaz Bourre
 * @date 2024-12-08
 * @version 1.0
 * 
 * @file web.php
 * @brief Archivo de configuración de rutas para la aplicación Laravel.
 * 
 * Este archivo define todas las rutas de la aplicación y los controladores asociados.
 * 
 * @details
 * Las rutas están configuradas utilizando `Route::any`, lo que permite aceptar cualquier tipo
 * de petición HTTP (GET, POST, PUT, DELETE, etc.). Las rutas apuntan a diferentes controladores
 * y métodos que manejan la lógica de cada endpoint.
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ConfiguracionController;

// Rutas definidas
/**
 * @brief Ruta para la página principal.
 * @details Redirige al método `incioSesion` del controlador `UsuarioController`.
 */
Route::any('/', [UsuarioController::class, 'incioSesion']);

/**
 * @brief Ruta para manejar el inicio de sesión.
 * @details Llama al método `comprobarUsuario` del controlador `UsuarioController`.
 */
Route::any('/inicioSesion', [UsuarioController::class, 'comprobarUsuario']);

/**
 * @brief Ruta para listar tareas.
 * @details Llama al método `listadoTareas` del controlador `TareaController`.
 */
Route::any('/listadoTareas', [TareaController::class, 'listadoTareas']);

/**
 * @brief Ruta para gestionar tareas específicas.
 * @details Llama al método `tarea` del controlador `TareaController`.
 */
Route::any('/tarea', [TareaController::class, 'tarea']);
Route::any('/tareasPendientes', [TareaController::class, 'tareasPendientes']);
/**
 * @brief Ruta para la sección "Acerca de".
 * @details Llama al método `acerca` del controlador `TareaController`.
 */
Route::any('/acerca', [TareaController::class, 'acerca']);

/**
 * @brief Ruta para la página de errores.
 * @details Llama al método `errores` del controlador `TareaController` y tiene un nombre de ruta `errores`.
 */
Route::any('/errores', [TareaController::class, 'errores'])->name('errores');

/**
 * @brief Ruta para modificar tareas.
 * @details Llama al método `modificar` del controlador `TareaController`.
 */
Route::any('/modificar', [TareaController::class, 'modificar']);

/**
 * @brief Ruta para borrar tareas.
 * @details Llama al método `borrar` del controlador `TareaController`.
 */
Route::any('/borrar', [TareaController::class, 'borrar']);

/**
 * @brief Ruta para eliminar una tarea específica.
 * @details Llama al método `eliminar_tarea` del controlador `TareaController` y tiene un nombre de ruta `eliminar-tarea`.
 * @param int $id ID de la tarea a eliminar.
 */
Route::any('/eliminar_tarea/{id}', [TareaController::class, 'eliminar_tarea'])->name('eliminar-tarea');
Route::any('/verDetalles', [TareaController::class, 'verDetalles']);
/**
 * @brief Ruta para completar tareas.
 * @details Llama al método `completarTarea` del controlador `TareaController`.
 */
Route::any('/completarTareas', [TareaController::class, 'completarTarea']);

/**
 * @brief Ruta para realizar la acción de completar una tarea.
 * @details Llama al método `accionCompletar` del controlador `TareaController`.
 */
Route::any('/accionCompletar', [TareaController::class, 'accionCompletar']);

/**
 * @brief Ruta para filtrar tareas.
 * @details Llama al método `filtrarTareas` del controlador `TareaController`.
 */
Route::any('/filtrarTarea', [TareaController::class, 'filtrarTareas']);

/**
 * @brief Ruta para cerrar sesión.
 * @details Llama al método `cerrarSesion` del controlador `UsuarioController`.
 */
Route::any('/cerrarSesion', [UsuarioController::class, 'cerrarSesion']);

/**
 * @brief Ruta para añadir un nuevo usuario.
 * @details Llama al método `añadirUsuario` del controlador `UsuarioController`.
 */
Route::any('/añadirUsuario', [UsuarioController::class, 'añadirUsuario']);

/**
 * @brief Ruta para procesar la acción de añadir un usuario.
 * @details Llama al método `añadirU` del controlador `UsuarioController`.
 */
Route::any('/añadir', [UsuarioController::class, 'añadirU']);

/**
 * @brief Ruta para la página de eliminación de usuarios.
 * @details Llama al método `eliminarUsuario` del controlador `UsuarioController`.
 */
Route::any('/eliminarUsuario', [UsuarioController::class, 'eliminarUsuario']);

/**
 * @brief Ruta para confirmar la eliminación de un usuario específico.
 * @details Llama al método `confirmarEliminar` del controlador `UsuarioController`.
 * @param int $id ID del usuario a eliminar.
 */
Route::any('/eliminar-usuario/{id}', [UsuarioController::class, 'confirmarEliminar']);

/**
 * @brief Ruta para listar usuarios.
 * @details Llama al método `listarUsuario` del controlador `UsuarioController`.
 */
Route::any('/listarUsuario', [UsuarioController::class, 'listarUsuario']);

/**
 * @brief Ruta para editar un usuario.
 * @details Llama al método `editarUsuario` del controlador `UsuarioController`.
 */
Route::any('/editarUsuario', [UsuarioController::class, 'editarUsuario']);

/**
 * @brief Ruta para actualizar los datos de un usuario específico.
 * @details Llama al método `actualizarUsuario` del controlador `UsuarioController`.
 * @param int $id ID del usuario a actualizar.
 */
Route::any('/actualizarUsuario/{id}', [UsuarioController::class, 'actualizarUsuario']);

/**
 * @brief Ruta para acceder a la configuración de la aplicación.
 * @details Llama al método `configuracion` del controlador `ConfiguracionController`.
 */
Route::any('/configuracion', [ConfiguracionController::class, 'configuracion']);

/**
 * @brief Ruta para guardar los cambios de configuración.
 * @details Llama al método `guardarConfiguracion` del controlador `ConfiguracionController`.
 */
Route::any('/guardarConfiguracion', [ConfiguracionController::class, 'guardarConfiguracion']);