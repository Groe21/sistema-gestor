<?php
session_start();
include_once(__DIR__ . '/../../config/conexion.php');

class Autenticacion {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function autenticarUsuario($username, $password) {
        // Prevenir timeout de conexión
        set_time_limit(30);

        // Limpiar espacios en blanco
        $username = trim($username);
        $password = trim($password);

        // Validación básica
        if (empty($username) || empty($password)) {
            throw new Exception("Usuario y contraseña son requeridos");
        }

        // Consulta segura con prepared statement
        $sql = "SELECT username, password, id_rol FROM escuela.usuarios WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificación segura de contraseña
        if ($usuario && password_verify($password, $usuario['password'])) {
            // Regenerar ID de sesión para prevenir fixation
            session_regenerate_id(true);
            
            return [
                'username' => $usuario['username'],
                'rol' => $this->obtenerRolUsuario($usuario['id_rol'])
            ];
        }

        // Retraso artificial para mitigar timing attacks (500ms)
        usleep(500000);
        return false;
    }

    private function obtenerRolUsuario($id_rol) {
        $sql = "SELECT nombre FROM escuela.roles WHERE id_rol = :id_rol";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_rol' => $id_rol]);
        $rol = $stmt->fetch(PDO::FETCH_ASSOC);
        return $rol ? $rol['nombre'] : 'invitado'; // Valor por defecto seguro
    }
}

// --- Procesamiento del formulario ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $username = $_POST['usuario'] ?? '';
        $password = $_POST['contrasena'] ?? '';

        $pdo = conectarBaseDeDatos();
        $autenticacion = new Autenticacion($pdo);
        $usuario = $autenticacion->autenticarUsuario($username, $password);

        if ($usuario) {
            $_SESSION['usuario'] = [
                'username' => $usuario['username'],
                'rol' => $usuario['rol']
            ];
            
            // Redirección segura con ruta absoluta
            header('Location: ../../principal.php');
            exit();
        } else {
            $_SESSION['error'] = 'Credenciales inválidas';
            header('Location: ../../login.php');
            exit();
        }
    } catch (Exception $e) {
        error_log("Error de autenticación: " . $e->getMessage());
        $_SESSION['error'] = 'Error en el proceso de autenticación';
        header('Location: ../../login.php');
        exit();
    }
}
?>