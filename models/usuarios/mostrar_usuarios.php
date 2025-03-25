<?php
include_once(__DIR__ . '/../../config/conexion.php');

class Usuario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerUsuarios() {
        $sql = "SELECT id_usuario, username, password FROM escuela.usuarios";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function mostrarTablaUsuarios() {
        $usuarios = $this->obtenerUsuarios();
        echo '<div class="container-fluid mt-5"> <!-- Cambiado a container-fluid -->
                <div class="row justify-content-center">
                    <div class="col-12"> <!-- Ajusta el ancho de la columna -->
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">Lista de Usuarios</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tablaUsuarios" class="table table-bordered table-striped w-100">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Usuario</th>
                                                <th>Contraseña</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
        foreach ($usuarios as $usuario) {
            $passwordMasked = str_repeat('👻', ceil(strlen($usuario['password']) / 2));
            echo '<tr>
                    <td>' . htmlspecialchars($usuario['username']) . '</td>
                    <td>' . htmlspecialchars($passwordMasked) . '</td>
                    <td>
                        <button class="btn btn-warning btn-sm btn-edit me-2" title="Editar" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editarUsuarioModal" 
                                data-user-id="' . $usuario['id_usuario'] . '" 
                                data-username="' . htmlspecialchars($usuario['username']) . '">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm btn-delete" title="Eliminar" data-user-id="' . $usuario['id_usuario'] . '">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                  </tr>';
        }
        echo '              </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>';
    }
}
?>