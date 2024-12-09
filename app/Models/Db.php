<?php
namespace App\Models;

use PDO;
use PDOException;
require 'Conexion.php';

/**
 * @file Db.php
 * 
 * @author José Díaz Bourre
 * @date 2024-12-08
 * @version 1.0
 * 
 * @class Db
 * @brief Clase para la gestión de operaciones con la base de datos utilizando el patrón Singleton.
 * 
 * Esta clase permite ejecutar consultas SQL, manejar consultas preparadas, 
 * y realizar operaciones comunes con la base de datos de manera centralizada.
 */
class Db
{
    /**
     * @var Conexion $conexion Instancia de la clase Conexion para manejar la conexión a la base de datos.
     * @var PDOStatement $stmt Última consulta preparada ejecutada.
     * @var array $array Almacena datos procesados en algunas operaciones.
     * @var Db $_instance Instancia única de la clase (Singleton).
     */
    private $conexion;
    private $stmt;
    static $_instance;

     /**
     * @brief Constructor privado para implementar el patrón Singleton.
     * 
     * Crea una instancia de la clase Conexion para manejar las conexiones a la base de datos.
     */
    private function __construct()
    {
        $this->conexion = new Conexion();
    }

    /**
     * @brief Evita la clonación del objeto (Singleton).
     */
    private function __clone() {}

    /**
     * @brief Obtiene la instancia única de la clase.
     * 
     * @return Db Instancia única de la clase Db.
     */
    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @brief Ejecuta una consulta SQL.
     * 
     * @param string $sql Consulta SQL a ejecutar.
     * @return object Resultado de la consulta.
     * @throws PDOException Si ocurre un error al ejecutar la consulta.
     */
    public function ejecutar($sql)
    {
        try {
            $link = $this->conexion->getConexion();
            $this->stmt = $link->query($sql);
            return $this->stmt;
        } catch (PDOException $e) {
            die("Error en la consulta: " . $e->getMessage());
        }
    }

    /**
     * @brief Obtiene una fila de resultados de una consulta.
     * 
     * @param PDOStatement $stmt Objeto de la consulta ejecutada.
     * @return array|null Fila de resultados como un arreglo asociativo o `null` si no hay más filas.
     */
    public function obtener_fila($stmt)
    {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @brief Obtiene todos los registros de una consulta SQL.
     * 
     * @param string $sql Consulta SQL a ejecutar.
     * @return array Arreglo con todos los registros obtenidos.
     */
    public function obtenerRegistros($sql)
    {
        $resultado = $this->ejecutar($sql);
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @brief Ejecuta una consulta preparada con parámetros.
     * 
     * @param string $sql Consulta SQL preparada.
     * @param array $params Arreglo de parámetros para la consulta.
     * @return object Resultado de la consulta.
     * @throws PDOException Si ocurre un error al ejecutar la consulta preparada.
     */
    public function ejecutarPrepared($sql, $params = [])
    {
        try {
            $link = $this->conexion->getConexion();
            $stmt = $link->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die("Error al ejecutar la consulta preparada: " . $e->getMessage());
        }
    }

    // public function execute($params = [])
    // {
    //     try {
    //         return $this->stmt->execute($params);
    //     } catch (PDOException $e) {
    //         die("Error al ejecutar la consulta preparada: " . $e->getMessage());
    //     }
    // }
}
