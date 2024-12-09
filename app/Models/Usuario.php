<?php

namespace App\Models;

use App\Models\Db;
use PDO;

/**
 * @file Usuario.php
 * 
 * @author José Díaz Bourre
 * @date 2024-12-08
 * @version 1.0
 * 
 * 
 * @class Usuario
 * @brief Clase para gestionar operaciones relacionadas con los usuarios.
 * 
 * Esta clase permite realizar operaciones como autenticación, creación, actualización,
 * eliminación y validación de usuarios, además de gestionar tokens de inicio de sesión.
 */
class Usuario
{
    /**
     * @var Db $db Instancia de la clase Db para manejar las consultas a la base de datos.
     */
    private $db;

    /**
     * @brief Constructor de la clase Usuario.
     * 
     * Inicializa la conexión a la base de datos utilizando la clase `Db`.
     */
    public function __construct()
    {
        $this->db = Db::getInstance();
    }
    /**
     * @brief Obtiene una lista de todos los usuarios.
     * 
     * @return array Lista de usuarios como un arreglo asociativo.
     */
    public function obtenerUsuarios()
    {
        $sql = "SELECT id, nombre, contrasena, rol FROM usuario";
        $stmt = $this->db->obtenerRegistros($sql);
        return $stmt;
    }
    /**
     * @brief Obtiene los detalles de un usuario específico.
     * 
     * @param int $id ID del usuario.
     * @return array|null Detalles del usuario como un arreglo asociativo o `null` si no se encuentra.
     */
    public function obtenerUsuario($id)
    {
        $sql = "SELECT * FROM usuario WHERE id = :id";
        $params = [
            ':id' => $id
        ];
        $stmt = $this->db->ejecutarPrepared($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * @brief Comprueba las credenciales de un usuario.
     * 
     * @param string $nombre Nombre del usuario.
     * @param string $contraseña Contraseña del usuario.
     * @return array Resultado de la autenticación con un mensaje de éxito o error.
     */
    public function comprobar($nombre, $contraseña)
    {
        $sql = "SELECT contrasena FROM usuario WHERE nombre = :nombre";

        $params = [':nombre' => $nombre];
        $stmt = $this->db->ejecutarPrepared($sql, $params);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario && $contraseña === $usuario['contrasena']) {
            $sql1 = "SELECT id, nombre,contrasena,rol FROM usuario WHERE nombre = :nombre";
            $params = [':nombre' => $nombre];
            $stmt = $this->db->ejecutarPrepared($sql1, $params);
            return ['success' => true, 'message' => 'Usuario autenticado correctamente.', 'datos' => $stmt->fetch(PDO::FETCH_ASSOC)];
        }
        return ['success' => false, 'message' => 'Nombre o contraseña incorrectos.'];
    }
    /**
     * @brief Añade un nuevo usuario a la base de datos.
     * 
     * @param string $nombreU Nombre del usuario.
     * @param string $contrasena Contraseña del usuario.
     * @param string $rol Rol del usuario.
     * @return array Resultado del proceso de inserción con un mensaje de éxito.
     */
    public function añadirU($nombreU, $contrasena, $rol)
    {
        $sql = "INSERT INTO usuario (nombre, contrasena, rol) VALUES (:nombre, :contrasena, :rol)";
        $params = [
            ':nombre' => $nombreU,
            ':contrasena' => $contrasena,
            ':rol' => $rol
        ];
        $this->db->ejecutarPrepared($sql, $params);
        return ['success' => true, 'message' => 'Usuario insertado correctamente.'];
    }
    /**
     * @brief Comprueba si un usuario ya existe en la base de datos.
     * 
     * @param string $nombre Nombre del usuario.
     * @return bool `true` si el usuario existe, `false` en caso contrario.
     */
    public function comprobarP($nombre)
    {
        $sql = "SELECT nombre FROM usuario WHERE nombre = :nombre";

        $params = [':nombre' => $nombre];
        $stmt = $this->db->ejecutarPrepared($sql, $params);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si se encuentra el usuario, devuelve true; de lo contrario, false.
        return $usuario ? true : false;
    }
    /**
     * @brief Elimina un usuario de la base de datos.
     * 
     * @param int $id ID del usuario a eliminar.
     * @return array Resultado del proceso de eliminación con un mensaje de éxito.
     */
    public function eliminarUsuario($id)
    {

        $sql = "DELETE FROM usuario WHERE id = :id";
        $params = [
            ':id' => $id,
        ];
        $this->db->ejecutarPrepared($sql, $params);
        return ['success' => true, 'message' => 'Categoria eliminada correctamente.'];
    }
    /**
     * @brief Actualiza los datos de un usuario.
     * 
     * @param int $id ID del usuario a actualizar.
     * @param array $datos Datos actualizados del usuario.
     */
    public function actualizarUsuario($id, $datos)
    {
        error_log("ID recibido: " . $id);
        $sql = "UPDATE usuario SET
                    nombre = :nombre,
                    contrasena = :contrasena
                    
                WHERE id = :id";

        $params = [
            ':id' => $id,
            ':nombre' => $datos['nombre'],
            ':contrasena' => $datos['contraseña'],
        ];

        $this->db->ejecutarPrepared($sql, $params);
        // return ['success' => true, 'message' => 'Tarea actualizada correctamente.'];
    }
    /**
     * @brief Crea un token de inicio de sesión para un usuario.
     * 
     * @param int $id ID del usuario.
     * @param string $token Token generado para el inicio de sesión.
     */
    public function crearTokenInicio($id, $token)
    {
        $sql = "INSERT INTO usuarioTokens (usuario_id, token) VALUES (:usuario_id, :token)";
        $params = [
            ':usuario_id' => $id,
            ':token' => $token,
        ];
        $this->db->ejecutarPrepared($sql, $params);
    }
    /**
     * @brief Verifica un token de inicio de sesión.
     * 
     * @param string $token Token a verificar.
     * @return int|bool ID del usuario asociado al token si es válido, `false` en caso contrario.
     */
    public function verificarToken($token)
    {
        $sql = "SELECT usuario_id FROM usuarioTokens WHERE token = :token";
        $params = [
            ':token' => $token,
        ];
        $stmt = $this->db->ejecutarPrepared($sql, $params);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verificar si se encontró el token
        if ($resultado && count($resultado) > 0) {
            return $resultado['usuario_id']; // Retornar solo el ID del usuario
        }

        return false; // Token inválido o no encontrado
    }
    /**
     * @brief Elimina un token de inicio de sesión.
     * 
     * @param string $token Token a eliminar.
     */
    public function eliminarToken($token)
    {
        $sql = "DELETE FROM usuarioTokens WHERE token = :token";
        $params = [
            ':token' => $token,
        ];
        $this->db->ejecutarPrepared($sql, $params);
    }
}
