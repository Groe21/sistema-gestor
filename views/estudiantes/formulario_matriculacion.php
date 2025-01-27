<form id="matricularEstudianteForm" action="<?php echo BASE_URL; ?>/models/estudiantes/matricular_estudiante.php" method="POST" enctype="multipart/form-data">
    <!-- Datos del Estudiante -->
    <div class="card mb-4">
        <div class="card-header">Datos del Estudiante</div>
        <div class="card-body">
            <div class="form-group">
                <label for="id_periodo">Periodo:</label>
                <?php echo $obtenerPeriodos->generarSelect(); ?>
            </div>
            <div class="form-group">
                <label for="cedula_estudiante">Cédula:</label>
                <input type="text" class="form-control" id="cedula_estudiante" name="cedula_estudiante" required>
            </div>
            <div class="form-group">
                <label for="apellidos_estudiante">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos_estudiante" name="apellidos_estudiante" required>
            </div>
            <div class="form-group">
                <label for="nombres_estudiante">Nombres:</label>
                <input type="text" class="form-control" id="nombres_estudiante" name="nombres_estudiante" required>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento_estudiante">Fecha de Nacimiento:</label>
                <input type="date" class="form-control" id="fecha_nacimiento_estudiante" name="fecha_nacimiento_estudiante" required>
            </div>
            <div class="form-group">
                <label for="lugar_nacimiento_estudiante">Lugar de Nacimiento:</label>
                <input type="text" class="form-control" id="lugar_nacimiento_estudiante" name="lugar_nacimiento_estudiante" required>
            </div>
            <div class="form-group">
                <label for="residencia_estudiante">Residencia:</label>
                <input type="text" class="form-control" id="residencia_estudiante" name="residencia_estudiante" required>
            </div>
            <div class="form-group">
                <label for="direccion_estudiante">Dirección:</label>
                <input type="text" class="form-control" id="direccion_estudiante" name="direccion_estudiante" required>
            </div>
            <div class="form-group">
                <label for="sector_estudiante">Sector:</label>
                <input type="text" class="form-control" id="sector_estudiante" name="sector_estudiante" required>
            </div>
            <div class="form-group">
                <label for="id_paralelo_estudiante">Paralelo:</label>
                <?php echo $obtenerParalelos->generarSelect(); ?>
            </div>
            <div class="form-group">
                <label for="foto_estudiante">Foto:</label>
                <input type="file" class="form-control" id="foto_estudiante" name="foto_estudiante">
            </div>
        </div>
    </div>

    <!-- Datos del Padre -->
    <div class="card mb-4">
        <div class="card-header">Datos del Padre</div>
        <div class="card-body">
            <div class="form-group">
                <label for="cedula_padre">Cédula:</label>
                <input type="text" class="form-control" id="cedula_padre" name="cedula_padre" required>
            </div>
            <div class="form-group">
                <label for="apellidos_padre">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos_padre" name="apellidos_padre" required>
            </div>
            <div class="form-group">
                <label for="nombres_padre">Nombres:</label>
                <input type="text" class="form-control" id="nombres_padre" name="nombres_padre" required>
            </div>
            <div class="form-group">
                <label for="direccion_padre">Dirección:</label>
                <input type="text" class="form-control" id="direccion_padre" name="direccion_padre" required>
            </div>
            <div class="form-group">
                <label for="ocupacion_padre">Ocupación/Profesión:</label>
                <input type="text" class="form-control" id="ocupacion_padre" name="ocupacion_padre" required>
            </div>
            <div class="form-group">
                <label for="telefono_padre">Teléfono/Celular:</label>
                <input type="text" class="form-control" id="telefono_padre" name="telefono_padre" required>
            </div>
            <div class="form-group">
                <label for="correo_padre">Email:</label>
                <input type="email" class="form-control" id="correo_padre" name="correo_padre" required>
            </div>
            <div class="form-group">
                <label for="foto_padre">Foto:</label>
                <input type="file" class="form-control" id="foto_padre" name="foto_padre">
            </div>
        </div>
    </div>

    <!-- Datos de la Madre -->
    <div class="card mb-4">
        <div class="card-header">Datos de la Madre</div>
        <div class="card-body">
            <div class="form-group">
                <label for="cedula_madre">Cédula:</label>
                <input type="text" class="form-control" id="cedula_madre" name="cedula_madre" required>
            </div>
            <div class="form-group">
                <label for="apellidos_madre">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos_madre" name="apellidos_madre" required>
            </div>
            <div class="form-group">
                <label for="nombres_madre">Nombres:</label>
                <input type="text" class="form-control" id="nombres_madre" name="nombres_madre" required>
            </div>
            <div class="form-group">
                <label for="direccion_madre">Dirección:</label>
                <input type="text" class="form-control" id="direccion_madre" name="direccion_madre" required>
            </div>
            <div class="form-group">
                <label for="ocupacion_madre">Ocupación/Profesión:</label>
                <input type="text" class="form-control" id="ocupacion_madre" name="ocupacion_madre" required>
            </div>
            <div class="form-group">
                <label for="telefono_madre">Teléfono/Celular:</label>
                <input type="text" class="form-control" id="telefono_madre" name="telefono_madre" required>
            </div>
            <div class="form-group">
                <label for="correo_madre">Email:</label>
                <input type="email" class="form-control" id="correo_madre" name="correo_madre" required>
            </div>
            <div class="form-group">
                <label for="foto_madre">Foto:</label>
                <input type="file" class="form-control" id="foto_madre" name="foto_madre">
            </div>
        </div>
    </div>

    <!-- Datos del Representante -->
    <div class="card mb-4">
        <div class="card-header">Datos del Representante</div>
        <div class="card-body">
            <div class="form-group">
                <label for="cedula_representante">Cédula:</label>
                <input type="text" class="form-control" id="cedula_representante" name="cedula_representante" required>
            </div>
            <div class="form-group">
                <label for="apellidos_representante">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos_representante" name="apellidos_representante" required>
            </div>
            <div class="form-group">
                <label for="nombres_representante">Nombres:</label>
                <input type="text" class="form-control" id="nombres_representante" name="nombres_representante" required>
            </div>
            <div class="form-group">
                <label for="direccion_representante">Dirección:</label>
                <input type="text" class="form-control" id="direccion_representante" name="direccion_representante" required>
            </div>
            <div class="form-group">
                <label for="ocupacion_representante">Ocupación/Profesión:</label>
                <input type="text" class="form-control" id="ocupacion_representante" name="ocupacion_representante" required>
            </div>
            <div class="form-group">
                <label for="telefono_representante">Teléfono/Celular:</label>
                <input type="text" class="form-control" id="telefono_representante" name="telefono_representante" required>
            </div>
            <div class="form-group">
                <label for="correo_representante">Email:</label>
                <input type="email" class="form-control" id="correo_representante" name="correo_representante" required>
            </div>
            <div class="form-group">
                <label for="tipo_representante">Parentesco:</label>
                <select class="form-control" id="tipo_representante" name="tipo_representante" required>
                    <option value="mama">Mamá</option>
                    <option value="papa">Papá</option>
                    <option value="tio/a">Tío/a</option>
                    <option value="abuelo/a">Abuelo/a</option>
                    <option value="hermano/a">Hermano/a</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="foto_representante">Foto:</label>
                <input type="file" class="form-control" id="foto_representante" name="foto_representante">
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Matricular Estudiante</button>
</form>