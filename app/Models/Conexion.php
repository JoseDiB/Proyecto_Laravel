<?php
namespace App\Models;

use PDO;
use PDOException;

/**
 * 
 * @file Conexion.php
 * 
 * @author José Díaz Bourre
 * @date 2024-12-08
 * @version 1.0
 * 
 * @class Conexion
 * @brief Clase para gestionar la conexión a la base de datos.
 * 
 * Esta clase maneja la configuración y creación de una conexión a una base de datos MySQL 
 * utilizando PDO. Carga la configuración desde un archivo externo y establece una conexión segura.
 */
class Conexion
{
    /**
     * @var string $servidor Nombre del host o dirección del servidor de la base de datos.
     * @var string $usuario Nombre de usuario para conectar a la base de datos.
     * @var string $password Contraseña para conectar a la base de datos.
     * @var string $base_datos Nombre de la base de datos a la que se conectará.
     * @var PDO $link Instancia de la conexión PDO.
     */
    private $servidor;
    private $usuario;
    private $password;
    private $base_datos;
    private $link;

    /**
     * @brief Constructor de la clase Conexion.
     * 
     * Inicializa la conexión a la base de datos cargando la configuración y conectando.
     */
    public function __construct()
    {
        $this->cargarConfiguracion();
        $this->conectar();
    }

    /**
     * @brief Carga la configuración de la conexión desde un archivo externo.
     * 
     * @details Lee el archivo de configuración ubicado en la carpeta `config.php` 
     * para establecer los valores del servidor, usuario, contraseña y nombre de la base de datos.
     */
    private function cargarConfiguracion()
    {
        // Carga la configuración desde el archivo
        $config = include __DIR__ . '/../config.php';

        $this->servidor = $config['db_host'] ?? 'localhost';
        $this->usuario = $config['db_user'] ?? 'root';
        $this->password = $config['db_password'] ?? '';
        $this->base_datos = $config['db_name'] ?? 'proyectoLaravel';
    }

    /**
     * @brief Establece la conexión con la base de datos.
     * 
     * @details Utiliza los valores configurados previamente para crear una conexión PDO. 
     * Si ocurre un error durante la conexión, el programa termina mostrando un mensaje de error.
     * 
     * @throws PDOException Si ocurre un error al intentar conectarse.
     */
    private function conectar()
    {
        try {
            $dsn = "mysql:host={$this->servidor};dbname={$this->base_datos};charset=utf8";
            $this->link = new PDO($dsn, $this->usuario, $this->password);
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    /**
     * @brief Devuelve la conexión PDO actual.
     * 
     * @return PDO Instancia de la conexión PDO.
     */
    public function getConexion()
    {
        return $this->link;
    }

}