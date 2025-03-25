<?php
include_once(__DIR__ . '/../../config/conexion.php');

class EditarUsuario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function actualizarUsuario($id_usuario, $username, $password = null) {
        try {
            if ($password) {
                $sql = "UPDATE escuela.usuarios 
                        SET username = :username, 
                            password = :password 
                        WHERE id_usuario = :id_usuario";
                $params = [
                    ':username' => $username,
                    ':password' => password_hash($password, PASSWORD_BCRYPT),
                    ':id_usuario' => $id_usuario
                ];
            } else {
                $sql = "UPDATE escuela.usuarios 
                        SET username = :username 
                        WHERE id_usuario = :id_usuario";
                $params = [
                    ':username' => $username,
                    ':id_usuario' => $id_usuario
                ];
            }
            
            $stmt = $this->pdo->prepare($sql);
            $resultado = $stmt->execute($params);
            
            return ['success' => $resultado];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}

// Procesar la solicitud AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    try {
        $id_usuario = $_POST['id_usuario'] ?? null;
        $username = $_POST['username'] ?? null;
        $password = !empty($_POST['password']) ? $_POST['password'] : null;

        if (!$id_usuario || !$username) {
            throw new Exception('Datos incompletos');
        }

        $pdo = conectarBaseDeDatos();
        $editor = new EditarUsuario($pdo);
        $resultado = $editor->actualizarUsuario($id_usuario, $username, $password);

        echo json_encode($resultado);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>