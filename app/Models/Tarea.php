<?php
namespace App\Models;

use App\Models\Db;
use PDO;
/**
 * 
 * @file Tarea.php
 * 
 * @author José Díaz Bourre
 * @date 2024-12-08
 * @version 1.0
 * 
 * @class Tarea
 * @brief Clase para gestionar operaciones relacionadas con las tareas.
 * 
 * Esta clase permite crear, leer, actualizar, eliminar y filtrar tareas almacenadas en la base de datos.
 */
class Tarea{
    /**
     * @var Db $db Instancia de la clase Db para manejar las consultas a la base de datos.
     */
    private $db;

    /**
     * @brief Constructor de la clase Tarea.
     * 
     * Inicializa la instancia de la base de datos utilizando la clase `Db`.
     */
    public function __construct()
    {
        $this->db = Db::getInstance();
    }
    /**
     * @brief Añade una nueva tarea a la base de datos.
     * 
     * @param array $datos Datos de la tarea a añadir.
     * @return array Resultado del proceso de inserción con un mensaje de éxito.
     */
    public function anadirTareas($datos) {
        $sql = "INSERT INTO tareas (nif,
                                    nombre,
                                    apellidos,
                                    telefono,
                                    descripcion,
                                    email,
                                    direccion,
                                    poblacion,
                                    codigopostal,
                                    provincia,
                                    estado,
                                    operario,
                                    fechacreacion,
                                    fecharealizacion,
                                    anotacionesanteriores,
                                    anotacionesposteriores,
                                    ficheroresumen,
                                    fotostrabajo
                    ) VALUES (
                                        :nif,
                                        :nombre,
                                        :apellidos,
                                        :telefono,
                                        :descripcion,
                                        :email,
                                        :direccion,
                                        :poblacion,
                                        :codigopostal,
                                        :provincia,
                                        :estado,
                                        :operario,
                                        :fechacreacion,
                                        :fecharealizacion,
                                        :anotacionesanteriores,
                                        :anotacionesposteriores,
                                        :ficheroresumen,
                                        :fotostrabajo
                                    )";
                                    $formato = 'Y-m-d';
                                    $fechaActual = date($formato);
        $params = [
            ':nif' => $datos['NIF'],
            ':nombre' => $datos['nombre'],
            ':apellidos' => $datos['apellidos'],
            ':telefono' => $datos['telefono'],
            ':descripcion' => $datos['descripcion'],
            ':email' => $datos['email'],
            ':direccion' => $datos['direccion'],
            ':poblacion' => $datos['poblacion'],
            ':codigopostal' => $datos['codigoPostal'],
            ':provincia' => $datos['provincia'],
            ':estado' => $datos['estado'],
            ':operario' => $datos['operario'],
            ':fechacreacion' => $fechaActual,
            ':fecharealizacion' => $datos['fechaRealizacion'],
            ':anotacionesanteriores' => $datos['anotacionesAnteriores'],
            ':anotacionesposteriores' => $datos['anotacionesPosteriores'],
            ':ficheroresumen' => isset($datos['archivo']) ? $datos['archivo'] : null,
            ':fotostrabajo' => isset($datos['imagenes']) ? $datos['imagenes'] : null,
        ];

        $this->db->ejecutarPrepared($sql, $params);
        return ['success' => true, 'message' => 'Usuario insertado correctamente.'];
    }
    /**
     * @brief Obtiene los detalles de una tarea específica.
     * 
     * @param int $id ID de la tarea a obtener.
     * @return array|null Detalles de la tarea como un arreglo asociativo, o `null` si no existe.
     */
    public function obtenerTarea($id){
        $sql = "SELECT * FROM tareas WHERE id = :id";
        $params = [
            ':id' => $id
        ];
        $stmt = $this->db->ejecutarPrepared($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function obtenerRutas($id){
        $sql = "SELECT ficheroresumen,fotostrabajo FROM tareas WHERE id = :id";
        $params = [
            ':id' => $id
        ];
        $stmt = $this->db->ejecutarPrepared($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * @brief Marca una tarea como completada y actualiza sus detalles.
     * 
     * @param int $id ID de la tarea a completar.
     * @param array $datos Datos actualizados de la tarea.
     * @param string $rutaA Ruta del archivo resumen.
     * @param string $rutaI Ruta de las fotos del trabajo.
     * @return array Resultado del proceso de actualización con un mensaje de éxito.
     */
    public function completarTarea($id,$datos, $rutaA, $rutaI){
        $sql = "UPDATE tareas SET
                    estado = :estado,
                    fecharealizacion = :fecharealizacion,
                    anotacionesposteriores = :anotacionesposteriores,
                    ficheroresumen = :ficheroresumen,
                    fotostrabajo = :fotostrabajo
                WHERE id = :id";
        
        $params = [
            ':id' => $id,
            ':estado' => $datos['estado'],
            ':fecharealizacion' => $datos['fecharealizacion'],
            ':anotacionesposteriores' => $datos['anotacionesposteriores'],
            ':ficheroresumen' => $rutaA,
            ':fotostrabajo' => $rutaI
        ];
    
        $this->db->ejecutarPrepared($sql, $params);
        return ['success' => true, 'message' => 'Tarea actualizada correctamente.'];
    }
    /**
     * @brief Actualiza los detalles de una tarea existente.
     * 
     * @param int $id ID de la tarea a actualizar.
     * @param array $datos Datos actualizados de la tarea.
     * @return array Resultado del proceso de actualización con un mensaje de éxito.
     */
    public function actualizarTarea($id, $datos,$archivo ,$imagen) {
        error_log("ID recibido: " . $id);
        $sql = "UPDATE tareas SET
                    nif = :nif,
                    nombre = :nombre,
                    apellidos = :apellidos,
                    telefono = :telefono,
                    descripcion = :descripcion,
                    email = :email,
                    direccion = :direccion,
                    poblacion = :poblacion,
                    codigopostal = :codigopostal,
                    provincia = :provincia,
                    estado = :estado,
                    operario = :operario,
                    fecharealizacion = :fecharealizacion,
                    anotacionesanteriores = :anotacionesanteriores,
                    anotacionesposteriores = :anotacionesposteriores,
                    ficheroresumen = :ficheroresumen,
                    fotostrabajo = :fotostrabajo
                WHERE id = :id";
        
        $params = [
            ':id' => $id,
            ':nif' => $datos['NIF'],
            ':nombre' => $datos['nombre'],
            ':apellidos' => $datos['apellidos'],
            ':telefono' => $datos['telefono'],
            ':descripcion' => $datos['descripcion'],
            ':email' => $datos['email'],
            ':direccion' => $datos['direccion'],
            ':poblacion' => $datos['poblacion'],
            ':codigopostal' => $datos['codigoPostal'],
            ':provincia' => $datos['provincia'],
            ':estado' => $datos['estado'],
            ':operario' => $datos['operario'],
            ':fecharealizacion' => $datos['fechaRealizacion'],
            ':anotacionesanteriores' => $datos['anotacionesAnteriores'],
            ':anotacionesposteriores' => $datos['anotacionesPosteriores'],
            ':ficheroresumen' => isset($archivo) ? $archivo : null,
            ':fotostrabajo' => isset($imagen) ? $imagen : null,
        ];
    
        $this->db->ejecutarPrepared($sql, $params);
        return ['success' => true, 'message' => 'Tarea actualizada correctamente.'];
    }
    /**
     * @brief Elimina una tarea de la base de datos.
     * 
     * @param int $id ID de la tarea a eliminar.
     * @return array Resultado del proceso de eliminación con un mensaje de éxito.
     */
    public function eliminarTarea($id)
    {

        $sql = "DELETE FROM tareas WHERE id = :id";
        $params = [
            ':id' => $id,
        ];
        $this->db->ejecutarPrepared($sql, $params);
        return ['success' => true, 'message' => 'Categoria eliminada correctamente.'];
    }
    /**
     * @brief Lista todas las tareas almacenadas en la base de datos.
     * 
     * @return array Lista de tareas como un arreglo asociativo.
     */
    public function listarTareas()
    {
        $sql = "SELECT * FROM tareas ORDER BY fecharealizacion DESC;";
        $tareas = $this->db->obtenerRegistros($sql);
        return $tareas;
    }

    public function listarTareasPendientes()
    {
        $sql = "SELECT * FROM tareas WHERE estado = 'P' ORDER BY fecharealizacion DESC;";
        $tareas = $this->db->obtenerRegistros($sql);
        return $tareas;
    }

     /**
     * @brief Filtra tareas en función de un campo, operador y valor especificados.
     * 
     * @param array $datos Datos para filtrar las tareas (campo, operador, valor).
     * @return array Lista de tareas filtradas como un arreglo asociativo.
     */
    public function filtrarTareas($datos)
    {
        $campo = $datos['campo'];
        $operador = $datos['operador'];
        $valor = $datos['valor'];
        $sql = "SELECT * FROM tareas WHERE $campo $operador :valor ORDER BY fecharealizacion DESC;";
        $params = [
            ':valor' => $valor,
        ];
        $tareas = $this->db->ejecutarPrepared($sql, $params);
        return $tareas->fetchAll(PDO::FETCH_ASSOC);
    }
    public function ultimoIdTarea()
    {
        $sql = "SELECT id FROM tareas ORDER BY id DESC LIMIT 1;";
        $tareas = $this->db->obtenerRegistros($sql);
        return $tareas;
    }
    public function modificarRutas($id, $archivo, $imagen)  {
        error_log("ID recibido: " . $id);
        $sql = "UPDATE tareas SET
                    ficheroresumen = :ficheroresumen,
                    fotostrabajo = :fotostrabajo
                WHERE id = :id";
        
        $params = [
            ':id' => $id,
            ':ficheroresumen' => isset($archivo) ? $archivo : null,
            ':fotostrabajo' => isset($archivo) ? $imagen : null,
        ];
    
        $this->db->ejecutarPrepared($sql, $params);
        return ['success' => true, 'message' => 'Tarea actualizada correctamente.'];
        
    }
    
    
}