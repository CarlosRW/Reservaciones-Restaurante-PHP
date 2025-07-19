document.addEventListener('DOMContentLoaded', function() {
    const formReservacion = document.getElementById('formReservacion');
    
    formReservacion.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validar campos
        const nombre = document.getElementById('nombre_cliente').value.trim();
        const fecha = document.getElementById('fecha').value;
        const numPersonas = document.getElementById('num_personas').value;
        const clave = document.getElementById('clave').value;
        
        let errores = [];
        
        if (nombre === '') {
            errores.push('El nombre del cliente es obligatorio.');
        }
        
        if (fecha === '') {
            errores.push('La fecha es obligatoria.');
        } else {
            const fechaReserva = new Date(fecha);
            const ahora = new Date();
            
            if (fechaReserva < ahora) {
                errores.push('La fecha no puede ser en el pasado.');
            }
        }
        
        if (numPersonas < 1 || numPersonas > 20) {
            errores.push('El número de personas debe ser entre 1 y 20.');
        }
        
        if (clave === '') {
            errores.push('La clave de verificación es obligatoria.');
        } else if (clave.length < 4) {
            errores.push('La clave debe tener al menos 4 caracteres.');
        }
        
        if (errores.length > 0) {
            alert('Por favor corrija los siguientes errores:\n\n' + errores.join('\n'));
        } else {
            // Si no hay errores, enviar el formulario
            this.submit();
        }
    });
    
    // Validar el número de personas 
    document.getElementById('num_personas').addEventListener('change', function() {
        if (this.value < 1) {
            this.value = 1;
        } else if (this.value > 20) {
            this.value = 20;
        }
    });
});