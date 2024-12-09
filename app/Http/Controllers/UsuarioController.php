<?php

namespace App\Http\Controllers;

use App\Models\Filtrado;
use App\Models\Usuario;

/**
 * @file UsuarionController.php
 * 
 * @author José Díaz Bourre
 * @date 2024-12-08
 * @version 1.0
 * 
 * @class UsuarioController
 * @brief Controlador para gestionar las operaciones relacionadas con los usuarios.
 * 
 * Este controlador incluye métodos para inicio de sesión, cierre de sesión,
 * gestión de usuarios (añadir, listar, eliminar, editar).
 * 
 * En todos los métodos de esta clase hay condiciones en las que verificamos si, existe
 * en la variable $_COOKIE si el nombre de usuario está guardado y por otro lado si 
 * isset($_COOKIE['recuerdame'] está activo, esta cookie es generada al principio de la aplicación cuando nos logeamos
 * al indicar que nos rescuerde, este tendrá un token, que se guardará en la base de datos e irá 
 * comprobando que el token es correcto, aparte de que durará 3 días como máximo hasta que se
 * elimine.
 */
class UsuarioController
{
    private $usuario;
    /**
     * @brief Instancia la clase UsuarioController.
     * 
     * Inicializa la propiedad `$usuario` con una instancia del modelo `Usuario`.
     */
    public function __construct()
    {
        $this->usuario = new Usuario();
    }
    /**
     * @brief Maneja el inicio de sesión automático basado en cookies.
     * 
     * Verifica si hay una cookie de "recuerdame" válida y autentica automáticamente al usuario. 
     * Si no, muestra la vista de inicio de sesión.
     * 
     * @return mixed Vista de inicio de sesión o redirección al listado de tareas.
     */
    public function incioSesion()
    {
        if (isset($_COOKIE['recuerdame'])) {
            $token = $_COOKIE['recuerdame'];

            // Verificar si el token es válido
            $usuario_id = $this->usuario->verificarToken($token);
            if ($usuario_id) {
                    header('Location: /Proyecto_Laravel/public/listadoTareas');
                    exit();
                }else{
                    return view('inicioSesion');
                }

        }else{
            return view('inicioSesion');

        }
    }
    /**
     * @brief Comprueba las credenciales del usuario para iniciar sesión.
     * 
     * Verifica el usuario y la contraseña proporcionados. Si son válidos, crea una sesión y 
     * guarda configuración personalizada si existe, o aplica configuración predeterminada.
     * 
     * @return mixed Redirección al listado de tareas o vista de inicio de sesión.
     */
    public function comprobarUsuario()
    {
        
        $resultado = $this->usuario->comprobar($_POST['usuario'], $_POST['contraseña']);
        date_default_timezone_set('Europe/Madrid');
        // Verificar si el usuario fue autenticado
        if ($resultado['success']) {
            if (isset($_POST['recuerdame'])) {
                // dd($_POST['recuerdame']);
                session_set_cookie_params([
                    'lifetime' => 86400 * 3, 
                    'path' => '/',
                    'domain' => '',
                    'secure' => false,
                    'httponly' => true,
                ]);
                session_start();
                // dd(ini_get('session.cookie_lifetime'));
                $nombreUsuario = $resultado['datos']['nombre'];
                // Generar un token único
                $token = bin2hex(string: random_bytes(16));
                $this->usuario->crearTokenInicio($resultado['datos']['id'], $token);
                
                // Guardar el token en una cookie (3 días de duración)
                setcookie('recuerdame', $token, time() + (86400 * 3), "/", "", false, true);
                
                $usuario_id = $resultado['datos']['id'];
                $_SESSION['usuario'] = [
                    'datos' => $resultado['datos'], // Los datos del usuario
                    'hora' => date('Y-m-d H:i:s')   // Hora actual en formato Año-Mes-Día Hora:Minuto:Segundo
                ];
                $config_file = __DIR__ . '/../../../storage/app/config/config.json';
                if (file_exists($config_file)) {
                    $config_data = json_decode(file_get_contents($config_file), true);
                    if (isset($config_data[$usuario_id])) {
                        $_SESSION['config'] = $config_data[$usuario_id];
                    } else {
                        // Configuración predeterminada si no hay nada guardado
                        $_SESSION['config'] = [
                            'provincia_default' => '',
                            'poblacion_default' => '',
                            'zona_default' => '',
                            'elementos_por_pagina' => 10,
                            'tiempo_sesion' => 3600,
                            'tema' => 'claro'
                        ];
                    }
                }
                header('Location: /Proyecto_Laravel/public/listadoTareas');
                exit();
            } else {
                session_start();
                $nombreUsuario = $resultado['datos']['nombre'];
                $usuario_id = $resultado['datos']['id'];
                $config_file = __DIR__ . '/../../../storage/app/config/config.json';
                if (file_exists($config_file)) {
                    $config_data = json_decode(file_get_contents($config_file), true);

                    if (isset($config_data[$usuario_id])) {
                        $tiempoSesion = $config_data[$usuario_id]['tiempo_sesion'];
                        $tiempoExpiracion = time() +  $tiempoSesion;
                        setcookie('nombreUsuario', $nombreUsuario, $tiempoExpiracion, "/");
                        $_SESSION['config'] = $config_data[$usuario_id];
                        $_SESSION['usuario'] = [
                            'datos' => $resultado['datos'], // Los datos del usuario
                            'hora' => date('Y-m-d H:i:s')   // Hora actual en formato Año-Mes-Día Hora:Minuto:Segundo
                        ];
                    } else {
                        $_SESSION['config'] = [
                            'provincia_default' => '',
                            'poblacion_default' => '',
                            'zona_default' => '',
                            'elementos_por_pagina' => 10,
                            'tiempo_sesion' => 3600,
                            'tema' => 'claro'
                        ];
                    }
                }
                header('Location: /Proyecto_Laravel/public/listadoTareas');
                exit();
            }
        } else {
            // Fallo en la autenticación
            return view('inicioSesion'); 
        }
    }
    /**
     * @brief Cierra la sesión del usuario.
     * 
     * Elimina las cookies de sesión, limpia la sesión activa y redirige al usuario a la página principal.
     */
    public function cerrarSesion()
    {
        session_start();
        if (isset($_COOKIE['recuerdame'])) {
            $token = $_COOKIE['recuerdame'];
            $this->usuario->eliminarToken($token);
            setcookie('recuerdame', '', time() - 3600, "/", "", true, true);
        }

        unset($_SESSION['usuario']);
        header('Location: /Proyecto_Laravel/public/');
        exit();
    }
    /**
     * @brief Muestra la vista para añadir un nuevo usuario.
     * 
     * Verifica si hay una sesión o cookies válidas antes de mostrar la vista.
     * 
     * @return mixed Vista para añadir usuario o redirección al inicio.
     */
    public function añadirUsuario()
    {
        session_start();
        if (isset($_COOKIE['nombreUsuario']) || isset($_COOKIE['recuerdame'])) {
            return view('añadirUsuario');
        } else {
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
    }
    /**
     * @brief Añade un nuevo usuario a la bbdd.
     * 
     * Verifica si el usuario ya existe antes de añadirlo. Si no existe, lo añade con los datos proporcionados.
     * 
     * @return void Redirección tras completar la operación.
     */
    public function añadirU()
    {
        if (isset($_COOKIE['nombreUsuario']) || isset($_COOKIE['recuerdame'])) {
            $resultado = $this->usuario->comprobarP($_POST['usuario']);
            if ($resultado) {
                //Añadir de ya existe
                header('Location: /Proyecto_Laravel/public/añadirUsuario');
                exit();
            } else {
                $this->usuario->añadirU($_POST['usuario'], $_POST['contraseña'], $_POST['rol']);
                header('Location: /Proyecto_Laravel/public/añadirUsuario');
                exit();
            }
        } else {
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
    }
    /**
     * @brief Muestra la lista de usuarios disponibles para eliminar.
     * 
     * Carga los datos de los usuarios y los pasa a la vista correspondiente.
     * 
     * @return mixed Vista con los usuarios listados o redirección al inicio.
     */
    public function eliminarUsuario()
    {
        session_start();
        if (isset($_COOKIE['nombreUsuario']) || isset($_COOKIE['recuerdame'])) {
            // $resultado = $this->usuario->comprobarP($_POST['usuario']);
            $datosUsuarios = $this->usuario->obtenerUsuarios();
            return view('borrarUsuario', ['datosUsuarios' => $datosUsuarios]);
        } else {
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
    }
    /**
     * @brief Elimina un usuario específico de la bbdd
     * 
     * Verifica si hay una sesión válida antes de realizar la eliminación.
     * 
     * @param int $id ID del usuario a eliminar.
     * @return void Redirección tras completar la operación.
     */
    public function confirmarEliminar($id)
    {
        if (isset($_COOKIE['nombreUsuario']) || isset($_COOKIE['recuerdame'])) {
            $this->usuario->eliminarUsuario($id);
            header('Location: /Proyecto_Laravel/public/eliminarUsuario');
            exit();
        } else {
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
    }
    /**
     * @brief Lista todos los usuarios disponibles de la bbdd
     * 
     * Muestra una vista con los datos de los usuarios.
     * 
     * @return mixed Vista con la lista de usuarios o redirección al inicio.
     */
    public function ListarUsuario()
    {
        if (isset($_COOKIE['nombreUsuario']) || isset($_COOKIE['recuerdame'])) {
            session_start();
            $datosUsuarios = $this->usuario->obtenerUsuarios();
            return view('listarUsuarios', ['datosUsuarios' => $datosUsuarios]);
        } else {
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
    }
    /**
     * @brief Muestra la vista para editar un usuario específico.
     * 
     * Obtiene los datos del usuario en sesión y los pasa a la vista de edición.
     * 
     * @return mixed Vista de edición o redirección al inicio.
     */
    public function editarUsuario()
    {
        if (isset($_COOKIE['nombreUsuario']) || isset($_COOKIE['recuerdame'])) {
            session_start();
            $idUsuario = $_SESSION['usuario']['datos']['id'];
            $datosUsuario = $this->usuario->obtenerUsuario($idUsuario);
            return view('editarUsuario', ['datosUsuario' => $datosUsuario]);
        } else {
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
    }
    /**
     * @brief Actualiza los datos de un usuario en la bbdd.
     * 
     * Aplica los cambios proporcionados al usuario con el ID especificado.
     * 
     * @param int $id ID del usuario a actualizar.
     * @return void Redirección tras completar la operación.
     */
    public function actualizarUsuario($id)
    {
        if (isset($_COOKIE['nombreUsuario']) || isset($_COOKIE['recuerdame'])) {
            $datos = $_POST;
            $this->usuario->actualizarUsuario($id, $datos);
            header('Location: /Proyecto_Laravel/public/editarUsuario');
            exit();
        } else {
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
    }
}
