<?php

namespace App\Http\Controllers;

/**
 * @file ConfiguracionController.php
 * 
 * @author José Díaz Bourre
 * @date 2024-12-08
 * @version 1.0
 * 
 * @class ConfiguracionController
 * @brief Controlador para la configuración de la aplicación.
 * 
 * 
 * La función de este controlador es administrar parte de la configuración
 * de la aplicación, como por ejemplo, el número de registros que saldrá en
 * el listado de tareas o el cambiar entre el modo oscuro y el modo claro, tambíen tenemos otras
 * configuraciónes como mensajes estandar que aparecén en las vistas como añadir tarea o editar tarea.
 * Ese último caso de configuración no está implementado.
 * 
 * En todos los métodos de esta clase hay condiciones en las que verificamos si, existe
 * en la variable $_COOKIE si el nombre de usuario está guardado y por otro lado si 
 * isset($_COOKIE['recuerdame'] está activo, esta cookie es generada al principio de la aplicación cuando nos logeamos
 * al indicar que nos rescuerde, este tendrá un token, que se guardará en la base de datos e irá 
 * comprobando que el token es correcto, aparte de que durará 3 días como máximo hasta que se
 * elimine.
 */
class ConfiguracionController
{
    public function __construct() {}
    /**
     * Muestra la vista de configuración o redirige a la página principal si no hay sesión activa.
     *
     * @return mixed Muestra la vista 'configApp' o redirige al inicio.
     */
    public function configuracion()
    {
        session_start();

        if (isset($_COOKIE['nombreUsuario']) || isset($_COOKIE['recuerdame'])) {
            return view('configApp');
        } else {
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
    }

    /**
     * Guarda la configuración del usuario en un archivo JSON.
     * 
     * Este método procesa los datos enviados por el formulario de configuración
     * y los guarda asociandolo al id del usuario autenticado. Este usuario se recoge
     * por la variable $_SESSION.
     *
     * @return mixed Muestra la vista 'configApp' o redirige al inicio en caso de error.
     */
    public function guardarConfiguracion()
    {
        if (isset($_COOKIE['recuerdame'])) {
            session_start();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $_SESSION['config'] = [
                    'provincia_default' => $_POST['provincia_default'],
                    'poblacion_default' => $_POST['poblacion_default'],
                    'zona_default' => $_POST['zona_default'],
                    'elementos_por_pagina' => (int) $_POST['elementos_por_pagina'],
                    'tiempo_sesion' => (int) $_POST['tiempo_sesion'],
                    'tema' => $_POST['tema']
                ];
                $config_file = __DIR__ . '/../../../storage/app/config/config.json';

                // Lee el archivo de configuración existente
                $config_data = [];
                if (file_exists($config_file)) {
                    $config_data = json_decode(file_get_contents($config_file), true);
                }
                $usuario_id = $_SESSION['usuario']['datos']['id'];
                //  Nueva configuración
                $new_config = [
                    'provincia_default' => $_POST['provincia_default'] ?? '',
                    'poblacion_default' => $_POST['poblacion_default'] ?? '',
                    'zona_default' => $_POST['zona_default'] ?? '',
                    'elementos_por_pagina' => (int) ($_POST['elementos_por_pagina'] ?? 0),
                    'tiempo_sesion' => (int) ($_POST['tiempo_sesion'] ?? 0),
                    'tema' => $_POST['tema'] ?? ''
                ];

                // Asociar la nueva configuración al usuario en sesión
                $config_data[$usuario_id] = $new_config;

                // Guardar los datos actualizados en el archivo JSON
                file_put_contents($config_file, json_encode($config_data, JSON_PRETTY_PRINT));

                return view('configApp');
            } 
        } else if(isset($_COOKIE['nombreUsuario'])){
            $tiempo_sesion = $_POST['tiempo_sesion'] ?? 3600;
            session_start();
            setcookie('nombreUsuario', $_SESSION['usuario']['datos']['nombre'], time() + $tiempo_sesion, "/");
                $_SESSION['config'] = [
                    'provincia_default' => $_POST['provincia_default'],
                    'poblacion_default' => $_POST['poblacion_default'],
                    'zona_default' => $_POST['zona_default'],
                    'elementos_por_pagina' => (int) $_POST['elementos_por_pagina'],
                    'tiempo_sesion' => (int) $_POST['tiempo_sesion'],
                    'tema' => $_POST['tema']
                ];
                // Obtener el ID del usuario en sesión
                $usuario_id = $_SESSION['usuario']['datos']['id']; 

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $config_file = __DIR__ . '/../../../storage/app/config/config.json';

                    $config_data = [];
                    if (file_exists($config_file)) {
                        $config_data = json_decode(file_get_contents($config_file), true);
                    }
                    $new_config = [
                        'provincia_default' => $_POST['provincia_default'] ?? '',
                        'poblacion_default' => $_POST['poblacion_default'] ?? '',
                        'zona_default' => $_POST['zona_default'] ?? '',
                        'elementos_por_pagina' => (int) ($_POST['elementos_por_pagina'] ?? 0),
                        'tiempo_sesion' => (int) ($_POST['tiempo_sesion'] ?? 0),
                        'tema' => $_POST['tema'] ?? ''
                    ];
                    $config_data[$usuario_id] = $new_config;

                    file_put_contents($config_file, json_encode($config_data, JSON_PRETTY_PRINT));

                    return view('configApp');
                } 

        }else{
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
    }
}
