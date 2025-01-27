<div class="container d-flex justify-content-center">
    <form action="" method="POST" enctype="multipart/form-data" class="col-md-8 p-4" style="border: 1px solid #ccc; background-color: #f9f9f9; border-radius: 8px;">
        
        <!-- Sección de Datos del Estudiante -->
        <div id="seccion-estudiante">
            <h3>Datos del Estudiante</h3>
            <div class="form-group">
                <label for="cedula_estudiante">Cédula</label>
                <input type="text" class="form-control" id="cedula_estudiante" name="cedula_estudiante" required>
            </div>
            <div class="form-group">
                <label for="apellidos_estudiante">Apellidos</label>
                <input type="text" class="form-control" id="apellidos_estudiante" name="apellidos_estudiante" required>
            </div>
            <div class="form-group">
                <label for="nombres_estudiante">Nombres</label>
                <input type="text" class="form-control" id="nombres_estudiante" name="nombres_estudiante" required>
            </div>
            <div class="form-group">
                <label for="lugar_nacimiento_estudiante">Lugar de Nacimiento</label>
                <input type="text" class="form-control" id="lugar_nacimiento_estudiante" name="lugar_nacimiento_estudiante" required>
            </div>
            <div class="form-group">
                <label for="residencia_estudiante">Residencia</label>
                <input type="text" class="form-control" id="residencia_estudiante" name="residencia_estudiante" required>
            </div>
            <div class="form-group">
                <label for="direccion_estudiante">Dirección</label>
                <input type="text" class="form-control" id="direccion_estudiante" name="direccion_estudiante" required>
            </div>
            <div class="form-group">
                <label for="sector_estudiante">Sector</label>
                <input type="text" class="form-control" id="sector_estudiante" name="sector_estudiante" required>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento_estudiante">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento_estudiante" name="fecha_nacimiento_estudiante" required>
            </div>
            <div class="form-group">
                <label for="grado">Grado del Estudiante</label>
                <select class="form-control" id="grado" name="grado" required>
                    <option value="" selected disabled>Seleccione un grado</option>
                </select>
            </div>
            <div class="form-group">
                <label for="id_paralelo_estudiante">Paralelo</label>
                <select class="form-control" id="id_paralelo_estudiante" name="id_paralelo_estudiante" required>
                    <option value="" selected disabled>Seleccione un paralelo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="codigo_unico_estudiante">Código Único</label>
                <input type="text" class="form-control" id="codigo_unico_estudiante" name="codigo_unico_estudiante" required>
            </div>
            <div class="form-group">
                <label for="condicion_estudiante">Condición</label>
                <select class="form-control" id="condicion_estudiante" name="condicion_estudiante" required>
                    <option value="" selected disabled>Seleccionar</option>
                    <option value="1">Con Discapacidad</option>
                    <option value="0">Sin Discapacidad</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tipo_discapacidad">Tipo de Discapacidad</label>
                <input type="text" class="form-control" id="tipo_discapacidad" name="tipo_discapacidad" required disabled>
            </div>
            <div class="form-group">
                <label for="porcentaje_discapacidad">Porcentaje de Discapacidad</label>
                <input type="text" class="form-control" id="porcentaje_discapacidad" name="porcentaje_discapacidad" required disabled>
            </div>
            <div class="form-group">
                <label for="carnet_discapacidad">N° Carnet de Discapacidad</label>
                <input type="text" class="form-control" id="carnet_discapacidad" name="carnet_discapacidad" required disabled>
            </div>
            <div class="form-group">
                <label for="imagen">Foto</label>
                <input type="file" class="form-control" id="imagen" name="imagen" required>
            </div>
            <button type="button" class="btn btn-primary" onclick="mostrarSeccion('seccion-mama')">Siguiente</button>
        </div>

        <!-- Sección de Datos de la Madre -->
        <div id="seccion-mama" style="display:none;">
            <h3>Datos de la Madre</h3>
            <div class="form-group">
                <label for="cedula_mama">Cédula de la Madre</label>
                <input type="text" class="form-control" id="cedula_mama" name="cedula_mama" required>
            </div>
            <div class="form-group">
                <label for="apellidos_nombres_mama">Apellidos y Nombres de la Madre</label>
                <input type="text" class="form-control" id="apellidos_nombres_mama" name="apellidos_nombres_mama" required>
            </div>
            <div class="form-group">
                <label for="direccion_mama">Dirección de la Madre</label>
                <input type="text" class="form-control" id="direccion_mama" name="direccion_mama" required>
            </div>
            <div class="form-group">
                <label for="ocupacion_mama">Ocupación de la Madre</label>
                <input type="text" class="form-control" id="ocupacion_mama" name="ocupacion_mama" required>
            </div>
            <div class="form-group">
                <label for="telefono_mama">Teléfono de la Madre</label>
                <input type="text" class="form-control" id="telefono_mama" name="telefono_mama" required>
            </div>
            <div class="form-group">
                <label for="correo_mama">Correo de la Madre</label>
                <input type="email" class="form-control" id="correo_mama" name="correo_mama" required>
            </div>
            <button type="button" class="btn btn-primary" onclick="mostrarSeccion('seccion-papa')">Siguiente</button>
            <button type="button" class="btn btn-success" onclick="mostrarSeccion('seccion-estudiante')">Retroceder</button>
        </div>

        <!-- Sección de Datos del Padre -->
        <div id="seccion-papa" style="display:none;">
            <h3>Datos del Padre</h3>
            <div class="form-group">
                <label for="cedula_papa">Cédula del Padre</label>
                <input type="text" class="form-control" id="cedula_papa" name="cedula_papa" required>
            </div>
            <div class="form-group">
                <label for="apellidos_nombres_papa">Apellidos y Nombres del Padre</label>
                <input type="text" class="form-control" id="apellidos_nombres_papa" name="apellidos_nombres_papa" required>
            </div>
            <div class="form-group">
                <label for="direccion_papa">Dirección del Padre</label>
                <input type="text" class="form-control" id="direccion_papa" name="direccion_papa" required>
            </div>
            <div class="form-group">
                <label for="ocupacion_papa">Ocupación del Padre</label>
                <input type="text" class="form-control" id="ocupacion_papa" name="ocupacion_papa" required>
            </div>
            <div class="form-group">
                <label for="telefono_papa">Teléfono del Padre</label>
                <input type="text" class="form-control" id="telefono_papa" name="telefono_papa" required>
            </div>
            <div class="form-group">
                <label for="correo_papa">Correo del Padre</label>
                <input type="email" class="form-control" id="correo_papa" name="correo_papa" required>
            </div>
            <button type="button" class="btn btn-primary" onclick="mostrarSeccion('seccion-representante')">Siguiente</button>
            <button type="button" class="btn btn-success" onclick="mostrarSeccion('seccion-mama')">Retroceder</button>
        </div>

        <!-- Sección de Datos del Representante -->
        <div id="seccion-representante" style="display:none;">
            <h3>Datos del Representante</h3>
            <div class="form-group">
                <label for="cedula_representante">Cédula del Representante</label>
                <input type="text" class="form-control" id="cedula_representante" name="cedula_representante" required>
            </div>
            <div class="form-group">
                <label for="apellidos_nombres_representante">Apellidos y Nombres del Representante</label>
                <input type="text" class="form-control" id="apellidos_nombres_representante" name="apellidos_nombres_representante" required>
            </div>
            <div class="form-group">
                <label for="direccion_representante">Dirección del Representante</label>
                <input type="text" class="form-control" id="direccion_representante" name="direccion_representante" required>
            </div>
            <div class="form-group">
                <label for="ocupacion_representante">Ocupación del Representante</label>
                <input type="text" class="form-control" id="ocupacion_representante" name="ocupacion_representante" required>
            </div>
            <div class="form-group">
                <label for="telefono_representante">Teléfono del Representante</label>
                <input type="text" class="form-control" id="telefono_representante" name="telefono_representante" required>
            </div>
            <div class="form-group">
                <label for="correo_representante">Correo del Representante</label>
                <input type="email" class="form-control" id="correo_representante" name="correo_representante" required>
            </div>
            <div class="form-group">
                <label for="imagen_representante">Foto del Representante</label>
                <input type="file" class="form-control" id="imagen_representante" name="imagen_representante" required>
            </div>
            <button type="submit" class="btn btn-primary">Matricular Estudiante</button>
            <button type="button" class="btn btn-success" onclick="mostrarSeccion('seccion-papa')">Retroceder</button>
        </div>
    </form>
</div>