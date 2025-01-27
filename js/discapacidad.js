document.addEventListener('DOMContentLoaded', function() {
    const condicionEstudiante = document.getElementById('condicion_estudiante');
    const tipoDiscapacidad = document.getElementById('tipo_discapacidad');
    const porcentajeDiscapacidad = document.getElementById('porcentaje_discapacidad');
    const carnetDiscapacidad = document.getElementById('carnet_discapacidad');

    condicionEstudiante.addEventListener('change', function() {
        if (this.value === '1') { // Con Discapacidad
            tipoDiscapacidad.disabled = false;
            porcentajeDiscapacidad.disabled = false;
            carnetDiscapacidad.disabled = false;
        } else { // Sin Discapacidad
            tipoDiscapacidad.disabled = true;
            porcentajeDiscapacidad.disabled = true;
            carnetDiscapacidad.disabled = true;
            tipoDiscapacidad.value = '';
            porcentajeDiscapacidad.value = '';
            carnetDiscapacidad.value = '';
        }
    });
});