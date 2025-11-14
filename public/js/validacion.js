/**
 * Validación del formulario con JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.getElementById('formularioInscripcion');
    
    if (formulario) {
        // Validación en tiempo real
        formulario.addEventListener('submit', function(e) {
            if (!validarFormulario()) {
                e.preventDefault();
                mostrarAlerta('Por favor, completa todos los campos requeridos correctamente.', 'error');
            }
        });
        
        // Capitalizar nombre y apellido en tiempo real
        const nombreInput = document.getElementById('nombre');
        const apellidoInput = document.getElementById('apellido');
        
        if (nombreInput) {
            nombreInput.addEventListener('blur', function() {
                this.value = capitalizarTexto(this.value);
            });
        }
        
        if (apellidoInput) {
            apellidoInput.addEventListener('blur', function() {
                this.value = capitalizarTexto(this.value);
            });
        }
        
        // Validación de edad
        const edadInput = document.getElementById('edad');
        if (edadInput) {
            edadInput.addEventListener('input', function() {
                if (this.value < 15 || this.value > 100) {
                    this.setCustomValidity('La edad debe estar entre 15 y 100 años');
                } else {
                    this.setCustomValidity('');
                }
            });
        }
        
        // Contador de caracteres para observaciones
        const observacionesTextarea = document.getElementById('observaciones');
        if (observacionesTextarea) {
            const maxLength = observacionesTextarea.getAttribute('maxlength');
            const counter = document.createElement('div');
            counter.className = 'field-hint';
            counter.style.textAlign = 'right';
            observacionesTextarea.parentNode.appendChild(counter);
            
            observacionesTextarea.addEventListener('input', function() {
                const remaining = maxLength - this.value.length;
                counter.textContent = `${this.value.length} / ${maxLength} caracteres`;
            });
            
            // Inicializar contador
            counter.textContent = `0 / ${maxLength} caracteres`;
        }
    }
});

/**
 * Valida todos los campos del formulario
 */
function validarFormulario() {
    let esValido = true;
    
    // Validar nombre
    const nombre = document.getElementById('nombre');
    if (nombre && nombre.value.trim().length < 2) {
        marcarError(nombre, 'El nombre debe tener al menos 2 caracteres');
        esValido = false;
    } else if (nombre) {
        quitarError(nombre);
    }
    
    // Validar apellido
    const apellido = document.getElementById('apellido');
    if (apellido && apellido.value.trim().length < 2) {
        marcarError(apellido, 'El apellido debe tener al menos 2 caracteres');
        esValido = false;
    } else if (apellido) {
        quitarError(apellido);
    }
    
    // Validar edad
    const edad = document.getElementById('edad');
    if (edad && (edad.value < 15 || edad.value > 100)) {
        marcarError(edad, 'La edad debe estar entre 15 y 100 años');
        esValido = false;
    } else if (edad) {
        quitarError(edad);
    }
    
    // Validar correo
    const correo = document.getElementById('correo');
    if (correo && !validarEmail(correo.value)) {
        marcarError(correo, 'Ingresa un correo electrónico válido');
        esValido = false;
    } else if (correo) {
        quitarError(correo);
    }
    
    // Validar celular
    const celular = document.getElementById('celular');
    if (celular && !validarTelefono(celular.value)) {
        marcarError(celular, 'Ingresa un número de celular válido');
        esValido = false;
    } else if (celular) {
        quitarError(celular);
    }
    
    // Validar que al menos un checkbox esté seleccionado
    const checkboxes = document.querySelectorAll('input[name="areas_interes[]"]');
    const algunoSeleccionado = Array.from(checkboxes).some(cb => cb.checked);
    
    if (!algunoSeleccionado) {
        mostrarAlerta('Debes seleccionar al menos un tema tecnológico de interés', 'error');
        esValido = false;
    }
    
    return esValido;
}

/**
 * Capitaliza la primera letra de cada palabra
 */
function capitalizarTexto(texto) {
    return texto
        .toLowerCase()
        .split(' ')
        .map(palabra => palabra.charAt(0).toUpperCase() + palabra.slice(1))
        .join(' ');
}

/**
 * Valida formato de email
 */
function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

/**
 * Valida formato de teléfono
 */
function validarTelefono(telefono) {
    const regex = /^[\d\s\+\-\(\)]{8,20}$/;
    return regex.test(telefono);
}

/**
 * Marca un campo con error
 */
function marcarError(input, mensaje) {
    input.style.borderColor = '#f44336';
    input.setCustomValidity(mensaje);
}

/**
 * Quita la marca de error de un campo
 */
function quitarError(input) {
    input.style.borderColor = '';
    input.setCustomValidity('');
}

/**
 * Muestra una alerta temporal
 */
function mostrarAlerta(mensaje, tipo = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${tipo}`;
    alertDiv.innerHTML = `
        <span class="alert-icon">${tipo === 'error' ? '⚠️' : 'ℹ️'}</span>
        <span>${mensaje}</span>
    `;
    
    const formWrapper = document.querySelector('.form-wrapper');
    if (formWrapper) {
        formWrapper.insertBefore(alertDiv, formWrapper.firstChild);
        
        // Auto-eliminar después de 5 segundos
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
}

/**
 * Función para limpiar alertas existentes
 */
function limpiarAlertas() {
    const alertas = document.querySelectorAll('.alert');
    alertas.forEach(alerta => alerta.remove());
}
