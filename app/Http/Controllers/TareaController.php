<?php

namespace App\Http\Controllers;

use App\Models\Filtrado;
use App\Models\Tarea;
use App\Models\Usuario;
use App\Models\Provincia;

/**
 * @file TareaController.php
 * 
 * @author José Díaz Bourre
 * @date 2024-12-08
 * @version 1.0
 * 
 * @class TareaController
 * @brief Controlador para todo lo que tenga que ver con las tareas de la aplicación.
 * 
 * 
 * La función de este controlador es redirigir a las vistas precisas y controlar,
 * el tema de peticiónes, filtros, modificaciones, listar, añadir, eliminar, todo lo
 * que tenga que ver con las tareas se hace en este controlador.
 * 
 * En todos los métodos de esta clase hay condiciones en las que verificamos si, existe
 * en la variable $_COOKIE si el nombre de usuario está guardado y por otro lado si 
 * isset($_COOKIE['recuerdame'] está activo, esta cookie es generada al principio de la aplicación cuando nos logeamos
 * al indicar que nos rescuerde, este tendrá un token, que se guardará en la base de datos e irá 
 * comprobando que el token es correcto, aparte de que durará 3 días como máximo hasta que se
 * elimine.
 */
class TareaController
{
    /**
     * Instancia del modelo `Tarea`.
     * @var Tarea
     */
    private $tareas;

    /**
     * Instancia del modelo `Usuario`.
     * @var Usuario
     */
    private $usuario;

    /**
     * Instancia del modelo `Provincia`.
     * @var Provincia
     */
    private $provincia;

    /**
     * Constructor de la clase `TareaController`.
     *
     * Inicializa las instancias de los modelos `Tarea`, `Usuario` y `Provincia`.
     */
    public function __construct()
    {
        $this->tareas = new Tarea();
        $this->usuario = new Usuario();
        $this->provincia = new Provincia();
    }
    /**
     * La función de tarea, es consultar usando la instacia de provincia y usuario
     * para obtener la información precisa y cargar la vista junto con esa información.
     *
     * @return mixed Muestra la vista 'tarea' con los datos de las
     * provinias y usuarios o redirige al inicio.
     */
    public function tarea()
    {
        session_start();
        // Obtener todas las tareas
        if (isset($_COOKIE['nombreUsuario']) || isset($_COOKIE['recuerdame'])) {
            $datosProvincias =  $this->provincia->obtenerProvincia();
            $datosUsuarios =  $this->usuario->obtenerUsuarios();
            return view('tarea', ['datosProvincias' => $datosProvincias, 'datosUsuarios' => $datosUsuarios]); // Carga la vista de inicio   
        } else {
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
    }

    /**
     * La función de modificar, es consultar usando la instacia de provincia y usuario
     * para obtener la información precisa y cargar la vista junto con el id del registro que se 
     * esté intentando modificar que se obtendrá con $_GET. Luego se hará una petición a la 
     * base de datos hacia la tabla de tareas para que devuelva toda la información de
     * del id proporcionado.
     *
     * @return mixed Muestra la vista 'modificarTarea' incluyendo los datos de tarea o redirige al inicio.
     */
    public function modificar()
    {
        session_start();
        if (isset($_COOKIE['nombreUsuario']) || isset($_COOKIE['recuerdame'])) {
            $datosProvincias =  $this->provincia->obtenerProvincia();
            $datosUsuarios =  $this->usuario->obtenerUsuarios();
            $idTarea = $_GET['id'];
            $datoTarea = $this->tareas->obtenerTarea($idTarea);
            return view('modificarTarea', ['datoTarea' => $datoTarea, 'datosProvincias' => $datosProvincias, 'datosUsuarios' => $datosUsuarios]);
        } else {
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
    }
    public function eliminarArchivo($rutaA, $rutaI)
    {
        // Ruta base
        // $baseDirArchivo = __DIR__ . '/../../../storage/app/public/uploads/archivos';
        $rutaArchivoA =__DIR__.'/../../../storage/app/public/uploads/archivos'.$rutaA;
        $rutaArchivoI =__DIR__.'/../../../storage/app/public/uploads/imagenes'.$rutaI;
        // dd($rutaArchivoA);
        if (file_exists($rutaArchivoA)&& $rutaA != null) {
            unlink($rutaArchivoA); // Elimina el archivo
        }
        if (file_exists($rutaArchivoI)&& $rutaI != null) {
    
            unlink($rutaArchivoI); // Elimina la imagen
        }
    }
    /**
     * La función de borrar, es borrar un registro bajo la condición del parametro
     * id que se le pasa. Nos mandará a la vista borrarTareas donde podremos ver información
     * relevante del registro en cuestión.
     *
     * @return mixed Muestra la vista 'borrarTareas' incluyendo los datos de la tarea o redirige al inicio.
     */
    public function borrar()
    {
        session_start();
        if (isset($_COOKIE['nombreUsuario']) || isset($_COOKIE['recuerdame'])) {
            $idTarea = $_GET['id'];
            
            $datoTarea = $this->tareas->obtenerTarea($idTarea);
            return view('borrarTareas', ['datoTarea' => $datoTarea]);
        } else {
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
    }
    /**
     * La función de eliminar_tarea, tendrá un formulario la vista que acciona esta función
     * donde con un botón confirmaremos la eliminación del registro con la información
     * que previamente se le ha pasado.
     * @param string|int $id Identificador que se usará para crear una subcarpeta.
     *
     * @return void Muestra la vista 'listadoTareas' o redirige al inicio.
     */
    public function eliminar_tarea($id)
    {
        session_start();
        if (isset($_COOKIE['nombreUsuario']) || isset($_COOKIE['recuerdame'])) {
            $rutas = $this->tareas->obtenerRutas($id);
            // dd($rutas);
            $this->eliminarArchivo($rutas['ficheroresumen'], $rutas['fotostrabajo']);
            $this->tareas->eliminarTarea($id);
            header('Location: /Proyecto_Laravel/public/listadoTareas');
            exit();
        } else {
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
    }
    public function verDetalles()
    {
        session_start();
        if (isset($_COOKIE['nombreUsuario']) || isset($_COOKIE['recuerdame'])) {
            $datoTarea = $this->tareas->obtenerTarea($_GET['id']);
            return view('verDetalles', ['datoTarea' => $datoTarea]);
        } else {
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
    }

    /**
     * La función de completarTarea, mandará a la vista completarTarea donde tendremos unos
     * parámetros para completar la tarea. Previamente le pasaremos un id, para
     * que cuando vayamos a obtener la tarea nos pase la tarea con el id concreto y su
     * información, todo esto será enviado a la vista completarTareas.
     *
     * @return mixed Vista con los datos de la tarea a completar, o redirección al inicio.
     */
    public function completarTarea()
    {
        session_start();
        if (isset($_COOKIE['nombreUsuario']) || isset($_COOKIE['recuerdame'])) {
            $idTarea = $_GET['id'];
            $datoTarea = $this->tareas->obtenerTarea($idTarea);
            return view('completarTareas', ['datoTarea' => $datoTarea]);
        } else {
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
    }
    /**
     * La función de accionCompletar, obtendrá el id del registro por la variable $_SESSION,
     * y los datos pasados por el POST. 
     * 
     * LLamaremos a dos funciones, para procesar y guardar los archivos o imagenes en sus
     * directorios correspondientes.
     * 
     * LLamaremos a la función completarTarea, que junto con el id, los datos y las rutas de cada archivo o imagen
     * actualizaremos ese registros concreto con los datos actuales.
     * 
     * Posteriormente si todo a salido bien, nos mandará a la vista listadoTareas.
     *
     * @return void Muestra la vista 'listadoTareas' o redirige al inicio.
     */
    public function accionCompletar()
    {
        
        session_start();
        
        if (isset($_COOKIE['nombreUsuario']) || isset($_COOKIE['recuerdame'])) {
            
            $id = (int)$_SESSION['completar_id'] ?? null;
            $datos = $_POST;
            

            if (!$id) {
                die("ID inválido.");
            }

            // Configuración de directorios
            $baseDirArchivo = __DIR__ . '/../../../storage/app/public/uploads/archivos';
            $baseDirImagenes = __DIR__ . '/../../../storage/app/public/uploads/imagenes';

            // Procesar archivo (genérico)
            $rutaParaBBDDA = $this->procesarArchivo($baseDirArchivo, $id, 'archivo');

            // Procesar imagen (específica para fotos)
            $rutaParaBBDDI = $this->procesarImagen($baseDirImagenes, $id, 'imagenes');

            // Completar tarea en la base de datos
            $this->tareas->completarTarea($id, $datos, $rutaParaBBDDA, $rutaParaBBDDI);

            header('Location: /Proyecto_Laravel/public/listadoTareas');
            exit();
        } else {
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
    }

    /**
     * Procesa un archivo subido por el usuario.
     *
     * Este método crea un directorio basado en el ID proporcionado, valida
     * y mueve el archivo cargado desde el formulario a la ubicación especificada.
     *
     * @param string $baseDir Directorio base donde se almacenarán los archivos.
     * @param string|int $id Identificador que se usará para crear una subcarpeta.
     * @param string $campoArchivo Nombre del campo del formulario que contiene el archivo.
     *
     * @return string|null Devuelve la ruta relativa del archivo guardado para almacenarla en la base de datos,
     *                     o `null` si no se cargó ningún archivo o ocurrió un error.
     */
    private function procesarArchivo($baseDir, $id, $campoArchivo)
    {
        $targetDir = $baseDir . '/' . $id;

        // Crear carpeta si no existe
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Validar y mover el archivo
        if (isset($_FILES[$campoArchivo]) && $_FILES[$campoArchivo]['error'] === UPLOAD_ERR_OK) {
            $archivoTmp = $_FILES[$campoArchivo]['tmp_name'];
            $nombreArchivo = basename($_FILES[$campoArchivo]['name']);
            $rutaArchivo = $targetDir . '/' . $nombreArchivo;

            if (move_uploaded_file($archivoTmp, $rutaArchivo)) {
                return '/' . $id . '/' . $nombreArchivo; // Ruta para guardar en la base de datos
            } else {
                die("Error al mover el archivo.");
            }
        }

        echo "No se subió ningún archivo o hubo un error en la subida.";
        return null;
    }

    /**
     * Procesa una imagen subida por el usuario.
     *
     * Este método crea un directorio basado en el ID proporcionado, valida
     * el archivo subido (tipo MIME, tamaño) y lo guarda en la ubicación especificada.
     *
     * @param string $baseDir Directorio base donde se almacenarán las imágenes.
     * @param string|int $id Identificador que se usará para crear una subcarpeta.
     * @param string $campoArchivo Nombre del campo del formulario que contiene la imagen.
     *
     * @return string|null Devuelve la ruta relativa de la imagen guardada para almacenarla en la base de datos,
     *                     o `null` si no se cargó ninguna imagen o ocurrió un error.
     */
    private function procesarImagen($baseDir, $id, $campoArchivo)
    {
        $targetDir = $baseDir . '/' . $id;

        // Crear carpeta si no existe
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        if (isset($_FILES[$campoArchivo]) && $_FILES[$campoArchivo]['error'] === UPLOAD_ERR_OK) {
            $archivoTmp = $_FILES[$campoArchivo]['tmp_name'];
            $nombreArchivo = basename($_FILES[$campoArchivo]['name']);
            $tipoArchivo = mime_content_type($archivoTmp);
            $extensionesPermitidas = ['image/jpeg', 'image/png', 'image/gif'];
            $tamañoMaximo = 5 * 1024 * 1024;

            // Validar tipo MIME
            if (!in_array($tipoArchivo, $extensionesPermitidas)) {
                die("El archivo subido no es una imagen válida.");
            }

            // Validar tamaño
            if ($_FILES[$campoArchivo]['size'] > $tamañoMaximo) {
                die("El archivo supera el tamaño máximo permitido (5 MB).");
            }

            // Generar nombre único
            $nombreArchivo = uniqid() . '-' . $nombreArchivo;
            $rutaArchivo = $targetDir . '/' . $nombreArchivo;

            // Mover la imagen
            if (move_uploaded_file($archivoTmp, $rutaArchivo)) {
                return '/' . $id . '/' . $nombreArchivo;
            } else {
                die("Error al mover la foto.");
            }
        } else {
            echo "No se subió ninguna foto o hubo un error en la subida.";
        }
    }

    /**
     * Muestra el listado de tareas.
     *
     * Este método obtiene todas las tareas disponibles y renderiza la vista correspondiente.
     *
     * @return mixed Renderiza el listado de tareas o redirige a la página principal.
     */
    public function listadoTareas()
    {
        session_start();
        if (isset($_COOKIE['nombreUsuario']) || isset($_COOKIE['recuerdame'])) {
            $tareas = $this->tareas->listarTareas();
            $accion = "listarTareas";
            return $this->renderizarListado($tareas, $accion);
        } else {
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
    }

    public function tareasPendientes()
    {
        session_start();
        if (isset($_COOKIE['nombreUsuario']) || isset($_COOKIE['recuerdame'])) {
            $tareas = $this->tareas->listarTareasPendientes();
            $accion = "listarPendientes";
            return $this->renderizarListado($tareas, $accion);
        } else {
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
    }

    /**
     * Filtra las tareas según los criterios especificados.
     *
     * Este método procesa los datos enviados desde un formulario para establecer criterios de filtrado
     * en las tareas.
     * 
     * Luego hace la función filtrarTareas, que bajo los criterios especificados
     * creará una sentencia SQL, para filtrar según los parametros. Nos dará los
     * resultados correspondientes y lo mandaremos a la función renderizarListado.
     *
     * @return mixed Renderiza el listado de tareas filtradas o redirige a la página principal.
     */
    public function filtrarTareas()
    {
        session_start();
        if (isset($_COOKIE['nombreUsuario']) || isset($_COOKIE['recuerdame'])) {
            $datos = $_POST;
            if (isset($_POST['campo']) && $datos['campo'] !== null && $datos['operador'] !== null && $datos['valor'] !== null) {
                $_SESSION['filtros'] = [
                    'campo' => $datos['campo'] ?? null,
                    'operador' => $datos['operador'] ?? null,
                    'valor' => $datos['valor'] ?? null,
                ];
            }
            $tareas = $this->tareas->filtrarTareas($_SESSION['filtros']);
            $accion = "listarTareas";
            return $this->renderizarListado($tareas, $accion);
        } else {
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
    }
    /**
     * Renderiza el listado de tareas con paginación.
     *
     * Este método divide la lista de tareas en páginas y genera los datos necesarios para la vista
     * basada en la configuración del usuario (elementos por página) y la página actual seleccionada.
     *
     * @param array $tareas Lista de tareas a mostrar.
     *
     * @return mixed Retorna la vista `listadoTareas` con los datos de paginación y las tareas correspondientes.
     */
    private function renderizarListado($tareas, $accion)
    {
        
        // Número de elementos por página
        $itemsPorPagina = (int)$_SESSION['config']['elementos_por_pagina'] ?? 6;

        // Obtener la página actual desde la URL (si no se define, es la página 1)
        $paginaActual = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // Calcular el índice inicial y el total de páginas
        if ($itemsPorPagina == 0 || $itemsPorPagina == "") {
            $itemsPorPagina = 6;
        }
        $totalItems = count($tareas);
        $totalPaginas = ceil($totalItems / $itemsPorPagina);
        $indiceInicial = ($paginaActual - 1) * $itemsPorPagina;

        // Dividir los datos para la página actual
        $tareasPagina = array_slice($tareas, $indiceInicial, $itemsPorPagina);

        // Generar las variables necesarias para la vista
        $datosPaginacion = [
            'paginaActual' => $paginaActual,
            'totalPaginas' => $totalPaginas,
            'tareas' => $tareasPagina,
        ];
        if ($accion == "listarTareas") {
            return view('listadoTareas', ['datosPaginacion' => $datosPaginacion]);
        } else if ($accion == "listarPendientes") {
            return view('tareasPendientes', ['datosPaginacion' => $datosPaginacion]);
        }
    }

    /**
     * Procesa y valida datos del formulario, gestionando errores y redirecciones.
     *
     * Este método valida los datos enviados desde un formulario. Si hay errores,
     * los guarda en la sesión y redirige al formulario original. Si los datos son válidos,
     * actualiza o añade una tarea dependiendo del formulario enviado.
     * 
     *
     * @return void Realiza redirecciones en caso de error o éxito.
     */
    public function errores()
    {
        session_start();
    
        if (isset($_COOKIE['nombreUsuario']) || isset($_COOKIE['recuerdame'])) {
            $baseDirArchivo = __DIR__ . '/../../../storage/app/public/uploads/archivos';
                $baseDirImagenes = __DIR__ . '/../../../storage/app/public/uploads/imagenes';
            $datos = $_POST;
            $errores = Filtrado::validar($datos);
            if (!empty($errores)) {
                $_SESSION['inf_vieja'] = $datos;
                $_SESSION['flash']['errores'] = $errores;


                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            }
            if (isset($_POST['formilarioMod'])) {
                $rutas = $this->tareas->obtenerRutas($_POST['id']);
                // dd($rutas);
                $this->eliminarArchivo($rutas['ficheroresumen'], $rutas['fotostrabajo']);
                $rutaParaBBDDA = $this->procesarArchivo($baseDirArchivo, $_POST['id'], 'archivo');
                $rutaParaBBDDI = $this->procesarImagen($baseDirImagenes, $_POST['id'], 'imagenes');
                $resultado = $this->tareas->actualizarTarea($_POST['id'], $datos, $rutaParaBBDDA,$rutaParaBBDDI);
                if($resultado['success']){
                    $_SESSION['flash']['mod'] = "Se ha modificado la tarea";
                }
                $_SESSION['success'] = 'Los datos se procesaron correctamente.';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                
                $resultado = $this->tareas->anadirTareas($datos);
                if($resultado['success']){
                    $_SESSION['flash']['añadido'] = "Se ha añadido la tarea";
                }
                $id = $this->tareas->ultimoIdTarea();
                $rutaParaBBDDA = $this->procesarArchivo($baseDirArchivo, $id[0]['id'], 'archivo');
                // Procesar imagen (específica para fotos)
                $rutaParaBBDDI = $this->procesarImagen($baseDirImagenes, $id[0]['id'], 'imagenes');
                $this->tareas->modificarRutas($id[0]['id'],$rutaParaBBDDA,$rutaParaBBDDI );
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            }
        } else {
            header('Location: /Proyecto_Laravel/public/');
            exit();
        }
        //Usar flash en los errores para diferenciarlo
    }
}
