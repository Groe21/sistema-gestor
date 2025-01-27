<?php
include_once(__DIR__ . '/../../config/conexion.php');

class Usuario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function insertarUsuario($username, $password, $rol) {
        $sql = "INSERT INTO escuela.usuarios (username, password, id_rol) 
                VALUES (:username, :password, :rol)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':password' => password_hash($password, PASSWORD_BCRYPT), // Hash de la contraseña
            ':rol' => $rol
        ]);
    }
}

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $rol = $_POST['rol'];

        $pdo = conectarBaseDeDatos();
        $usuario = new Usuario($pdo);
        $usuario->insertarUsuario($username, $password, $rol);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>