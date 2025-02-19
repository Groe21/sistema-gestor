<?php
function conectarBaseDeDatos()
{
    $host = 'localhost';
    $port = '5432'; 
    $dbname = 'aguilas_del_saber'; // Nombre de la base de datos PostgreSQL
    $user = 'emilio'; // Nombre de usuario de PostgreSQL
    $password = 'tkmch2005'; // Contraseña de PostgreSQL

    
    try {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
        // Configuración para manejar errores y excepciones de PDO
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        exit(); 
    }
    return $pdo;
}


$conexion = conectarBaseDeDatos();
?>
