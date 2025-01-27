<?php
// Iniciar sesión solo si no está ya activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si la variable de sesión 'rol' está definida
$rol = isset($_SESSION['usuario']['rol']) ? $_SESSION['usuario']['rol'] : null;
?>

<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Barra lateral - Marca -->
    <a class="sidebar-brand d-flex flex-column align-items-center justify-content-center" href="<?php echo BASE_URL; ?>/principal.php" style="margin-bottom: 20px; margin-top: 20px;">
        <div class="sidebar-brand-icon" style="margin-bottom: 10px;">
            <img src="<?php echo BASE_URL; ?>/img/logo23.png" alt="Brand Image" style="width: 50px; height: 50px;">
        </div>
        <div class="sidebar-brand-text mx-3" style="display: block; text-align: center;">
            LAS ÁGUILAS DEL SABER
        </div>
    </a>

    <!-- Divisor -->
    <hr class="sidebar-divider">

    <!-- Elemento de navegación - Inicio -->
    <li class="nav-item">
        <a class="nav-link" href="<?php echo BASE_URL; ?>/principal.php">
            <i class="fas fa-home"></i>
            <span>Inicio</span>
        </a>
    </li>

    <!-- Divisor -->
    <hr class="sidebar-divider">

    <?php if ($rol == 'administrador') : ?>
        <!-- Encabezado -->
        <div class="sidebar-heading">
            Gestión de la Escuela
        </div>

        <!-- Dropdown - Gestión de la Escuela -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEscuela"
                aria-expanded="true" aria-controls="collapseEscuela">
                <i class="fas fa-school"></i>
                <span>Escuela</span>
            </a>
            <div id="collapseEscuela" class="collapse" aria-labelledby="headingEscuela" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Gestión de la Escuela:</h6>
                    <a class="collapse-item" href="<?php echo BASE_URL; ?>/views/escuela/gestionar_cursos.php">Gestión de Cursos</a>
                    <a class="collapse-item" href="<?php echo BASE_URL; ?>/views/escuela/gestionar_profesores.php">Gestión de Profesores</a>
                    <a class="collapse-item" href="<?php echo BASE_URL; ?>/views/asistencia/gestion_asistencia.php">Gestión de Asistencia</a>
                    <h6 class="collapse-header">Gestión de Usuarios:</h6>
                    <a class="collapse-item" href="<?php echo BASE_URL; ?>/views/usuarios/crear_usuario.php">Crear Usuario</a>
                    <a class="collapse-item" href="<?php echo BASE_URL; ?>/views/usuarios/listado_usuarios.php">Listado de Usuarios</a>
                    <h6 class="collapse-header">Gestión de Estudiantes:</h6>
                    <a class="collapse-item" href="<?php echo BASE_URL; ?>/views/estudiantes/matricular_estudiante.php">Matricular Estudiante</a>
                    <a class="collapse-item" href="<?php echo BASE_URL; ?>/views/estudiantes/listado_estudiantes.php">Estudiantes Matriculados</a>
                </div>
            </div>
        </li>

        <!-- Divisor -->
        <hr class="sidebar-divider">

        <!-- Dropdown - Página Administrativa -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdministrativo"
                aria-expanded="true" aria-controls="collapseAdministrativo">
                <i class="fas fa-user-shield"></i>
                <span>Página administrativa</span>
            </a>
            <div id="collapseAdministrativo" class="collapse" aria-labelledby="headingAdministrativo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Gestión Página</h6>
                    <a class="collapse-item" href="<?php echo BASE_URL; ?>/views/administrativo/administrativa.php">Página Adminstrativa</a>            
                    <a class="collapse-item" href="<?php echo BASE_URL; ?>/views/administrativo/blog.php">Blog</a>            
                    <a class="collapse-item" href="<?php echo BASE_URL; ?>/views/administrativo/galeria.php">Galería</a>            
                </div>
            </div>
        </li>

        <!-- Divisor -->
        <hr class="sidebar-divider">
    <?php elseif ($rol == 'profesor') : ?>
        <!-- Encabezado -->
        <div class="sidebar-heading">
            Gestión de la Escuela
        </div>

        <!-- Dropdown - Gestión de la Escuela -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEscuela"
                aria-expanded="true" aria-controls="collapseEscuela">
                <i class="fas fa-school"></i>
                <span>Escuela</span>
            </a>
            <div id="collapseEscuela" class="collapse" aria-labelledby="headingEscuela" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Gestión de la Escuela:</h6>
                    <a class="collapse-item" href="<?php echo BASE_URL; ?>/views/asistencia/gestion_asistencia.php">Gestión de Asistencia</a>
                </div>
            </div>
        </li>

        <!-- Divisor -->
        <hr class="sidebar-divider">
    <?php endif; ?>

</ul>