<?php
namespace App\Models;
/**
 * @file Provincia.php
 * 
 * @author José Díaz Bourre
 * @date 2024-12-08
 * @version 1.0
 * 
 * @class Provincia
 * @brief Clase para gestionar las operaciones relacionadas con las provincias.
 * 
 * Esta clase interactúa con la base de datos para obtener información sobre las provincias.
 */
class Provincia{
    /**
     * @var Db $db Instancia de la clase Db para manejar la conexión y consultas a la base de datos.
     */
    private $db;

    /**
     * @brief Constructor de la clase Provincia.
     * 
     * Inicializa una conexión a la base de datos utilizando la clase `Db`.
     */
    public function __construct()
    {
        $this->db = Db::getInstance();
    }
    /**
     * @brief Obtiene las provincias desde la base de datos.
     * 
     * Realiza una consulta a la tabla `tbl_provincias` para obtener los códigos,
     * nombres y el ID de la comunidad asociada a cada provincia.
     * 
     * @return array Arreglo con los datos de las provincias.
     */
    public function obtenerProvincia(){
        $sql = "SELECT cod,nombre,comunidad_id FROM tbl_provincias";
        $stmt = $this->db->obtenerRegistros($sql);
        return $stmt;
    }
}