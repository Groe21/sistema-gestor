<?php
session_start();
include_once(__DIR__ . '/../../config/conexion.php');

class Autenticacion {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function autenticarUsuario($username, $password) {
        $sql = "SELECT * FROM escuela.usuarios WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['password'])) {
            return $usuario;
        } else {
            return false;
        }
    }

    public function obtenerRolUsuario($username) {
        $sql = "SELECT r.nombre AS rol
                FROM escuela.usuarios u
                JOIN escuela.roles r ON u.id_rol = r.id_rol
                WHERE u.username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        $rol = $stmt->fetch(PDO::FETCH_ASSOC);
        return $rol ? $rol['rol'] : null;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['usuario'];
    $password = $_POST['contrasena'];

    $pdo = conectarBaseDeDatos();
    $autenticacion = new Autenticacion($pdo);
    $usuario = $autenticacion->autenticarUsuario($username, $password);

    if ($usuario) {
        // Obtener el rol del usuario
        $rol = $autenticacion->obtenerRolUsuario($username);

        // Almacena la cédula, nombres y rol en la sesión
        $_SESSION['usuario'] = [
            'cedula' => $usuario['username'], // Asumiendo que 'username' es la cédula
            'nombres' => $usuario['nombres'], // Asegúrate de que 'nombres' esté presente en la base de datos
            'rol' => $rol // Almacena el rol del usuario
        ];
        header('Location: ../../principal.php'); // Redirigir a la página principal o dashboard
        exit();
    } else {
        $_SESSION['error'] = 'Nombre de usuario o contraseña incorrectos';
        header('Location: ../../login.php'); // Redirigir de vuelta al login
        exit();
    }
}
?>