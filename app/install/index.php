<?php
// Verificar si ya está instalado
if (file_exists('../app/config.php') && include '../app/config.php') {
    echo "La aplicación ya está instalada.";
    exit;
}

// Mostrar el formulario de instalación
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    ?>
    <h1>Instalación de la Aplicación</h1>
    <form method="POST" action="">
        <label for="db_host">Host de la Base de Datos:</label>
        <input type="text" name="db_host"><br>

        <label for="db_name">Nombre de la Base de Datos:</label>
        <input type="text" name="db_name"><br>

        <label for="db_user">Usuario:</label>
        <input type="text" name="db_user"><br>

        <label for="db_password">Contraseña:</label>
        <input type="password" name="db_password"><br>

        <button type="submit">Instalar</button>
    </form>
    <?php
    exit;
}

// Procesar la instalación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_host = $_POST['db_host'];
    $db_name = $_POST['db_name'];
    $db_user = $_POST['db_user'];
    $db_password = $_POST['db_password'];

    // Probar conexión a la base de datos
    try {
        // $pdo = new PDO("mysql:host=$db_host", $db_user, $db_password);
        // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // // Crear la base de datos
        // $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name`");
        // $pdo->exec("USE `$db_name`");

        // // Inicializar tablas
        // $pdo->exec("
        //     CREATE TABLE IF NOT EXISTS users (
        //         id INT AUTO_INCREMENT PRIMARY KEY,
        //         username VARCHAR(50) NOT NULL UNIQUE,
        //         password VARCHAR(255) NOT NULL,
        //         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        //     );
        // ");

        // Guardar configuración
        $configContent = "<?php\nreturn [\n" .
            "'db_host' => '$db_host',\n" .
            "'db_name' => '$db_name',\n" .
            "'db_user' => '$db_user',\n" .
            "'db_password' => '$db_password',\n" .
            "];";

        file_put_contents('../config.php', $configContent);

        echo "¡Instalación completada!";
    } catch (PDOException $e) {
        echo "Error durante la instalación: " . $e->getMessage();
    }
}
?>