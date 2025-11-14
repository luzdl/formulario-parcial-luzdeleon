<?php
// La sesión ya está iniciada en index.php
$errores = $_SESSION['errores'] ?? [];
$datosAnteriores = $_SESSION['datos_formulario'] ?? [];
$mensajeExito = $_SESSION['mensaje_exito'] ?? '';

// Limpiar mensajes de sesión
unset($_SESSION['errores']);
unset($_SESSION['datos_formulario']);
unset($_SESSION['mensaje_exito']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripción iTECH - Eventos Tecnológicos 2025</title>
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <h1 class="logo">🚀 iTECH</h1>
                <p class="tagline">Innovación y Tecnología al Alcance de Todos</p>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <div class="form-wrapper">
                <div class="form-header">
                    <h2>Formulario de Inscripción</h2>
                    <p>Únete a nuestros eventos tecnológicos y amplía tus conocimientos</p>
                </div>

                <?php if ($mensajeExito): ?>
                <div class="alert alert-success">
                    <span class="alert-icon">✅</span>
                    <span><?php echo htmlspecialchars($mensajeExito); ?></span>
                </div>
                <?php endif; ?>

                <?php if (!empty($errores)): ?>
                <div class="alert alert-error">
                    <span class="alert-icon">⚠️</span>
                    <div>
                        <strong>Por favor corrige los siguientes errores:</strong>
                        <ul>
                            <?php foreach ($errores as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>

                <form action="procesar.php" method="POST" class="formulario" id="formularioInscripcion">
                    
                    <!-- Sección: Datos Personales -->
                    <fieldset class="form-section">
                        <legend>📋 Datos Personales</legend>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nombre">Nombre <span class="required">*</span></label>
                                <input type="text" 
                                       id="nombre" 
                                       name="nombre" 
                                       required 
                                       maxlength="100"
                                       value="<?php echo htmlspecialchars($datosAnteriores['nombre'] ?? ''); ?>"
                                       placeholder="Ingresa tu nombre">
                            </div>

                            <div class="form-group">
                                <label for="apellido">Apellido <span class="required">*</span></label>
                                <input type="text" 
                                       id="apellido" 
                                       name="apellido" 
                                       required 
                                       maxlength="100"
                                       value="<?php echo htmlspecialchars($datosAnteriores['apellido'] ?? ''); ?>"
                                       placeholder="Ingresa tu apellido">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="edad">Edad <span class="required">*</span></label>
                                <input type="number" 
                                       id="edad" 
                                       name="edad" 
                                       required 
                                       min="15" 
                                       max="100"
                                       value="<?php echo htmlspecialchars($datosAnteriores['edad'] ?? ''); ?>"
                                       placeholder="Ej: 25">
                            </div>

                            <div class="form-group">
                                <label for="sexo">Sexo <span class="required">*</span></label>
                                <select id="sexo" name="sexo" required>
                                    <option value="">Selecciona una opción</option>
                                    <?php
                                    $opciones = ['Masculino', 'Femenino', 'Otro', 'Prefiero no decir'];
                                    foreach ($opciones as $opcion) {
                                        $selected = ($datosAnteriores['sexo'] ?? '') === $opcion ? 'selected' : '';
                                        echo "<option value=\"$opcion\" $selected>$opcion</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Sección: Ubicación -->
                    <fieldset class="form-section">
                        <legend>🌎 Ubicación</legend>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="pais_residencia">País de Residencia <span class="required">*</span></label>
                                <select id="pais_residencia" name="pais_residencia" required>
                                    <option value="">Selecciona tu país de residencia</option>
                                    <?php foreach ($paises as $pais): ?>
                                        <option value="<?php echo $pais['id_pais']; ?>"
                                                <?php echo ($datosAnteriores['pais_residencia'] ?? '') == $pais['id_pais'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($pais['nombre_pais']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="nacionalidad">Nacionalidad <span class="required">*</span></label>
                                <select id="nacionalidad" name="nacionalidad" required>
                                    <option value="">Selecciona tu nacionalidad</option>
                                    <?php foreach ($paises as $pais): ?>
                                        <option value="<?php echo $pais['id_pais']; ?>"
                                                <?php echo ($datosAnteriores['nacionalidad'] ?? '') == $pais['id_pais'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($pais['nombre_pais']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Sección: Contacto -->
                    <fieldset class="form-section">
                        <legend>📱 Información de Contacto</legend>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="correo">Correo Electrónico <span class="required">*</span></label>
                                <input type="email" 
                                       id="correo" 
                                       name="correo" 
                                       required 
                                       maxlength="150"
                                       value="<?php echo htmlspecialchars($datosAnteriores['correo'] ?? ''); ?>"
                                       placeholder="ejemplo@correo.com">
                            </div>

                            <div class="form-group">
                                <label for="celular">Número de Celular <span class="required">*</span></label>
                                <input type="tel" 
                                       id="celular" 
                                       name="celular" 
                                       required 
                                       maxlength="20"
                                       value="<?php echo htmlspecialchars($datosAnteriores['celular'] ?? ''); ?>"
                                       placeholder="+507 6123-4567">
                            </div>
                        </div>
                    </fieldset>

                    <!-- Sección: Temas Tecnológicos -->
                    <fieldset class="form-section">
                        <legend>💻 Temas Tecnológicos de Interés</legend>
                        <p class="field-description">Selecciona los temas que te gustaría aprender (puedes elegir varios)</p>
                        
                        <div class="checkbox-grid">
                            <?php 
                            $areasSeleccionadas = $datosAnteriores['areas_interes'] ?? [];
                            foreach ($areasInteres as $area): 
                                $checked = in_array($area['id_area'], $areasSeleccionadas) ? 'checked' : '';
                            ?>
                                <label class="checkbox-item">
                                    <input type="checkbox" 
                                           name="areas_interes[]" 
                                           value="<?php echo $area['id_area']; ?>"
                                           <?php echo $checked; ?>>
                                    <span class="checkbox-label">
                                        <strong><?php echo htmlspecialchars($area['nombre_area']); ?></strong>
                                        <small><?php echo htmlspecialchars($area['descripcion']); ?></small>
                                    </span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </fieldset>

                    <!-- Sección: Observaciones -->
                    <fieldset class="form-section">
                        <legend>💬 Observaciones o Consultas</legend>
                        
                        <div class="form-group">
                            <label for="observaciones">¿Tienes alguna pregunta o comentario sobre el evento?</label>
                            <textarea id="observaciones" 
                                      name="observaciones" 
                                      rows="4" 
                                      maxlength="500"
                                      placeholder="Escribe aquí tus preguntas, comentarios o necesidades especiales..."><?php echo htmlspecialchars($datosAnteriores['observaciones'] ?? ''); ?></textarea>
                            <small class="field-hint">Máximo 500 caracteres</small>
                        </div>
                    </fieldset>

                    <!-- Botones de acción -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <span>📤</span> Enviar Inscripción
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <span>🔄</span> Limpiar Formulario
                        </button>
                        <a href="reporte.php" class="btn btn-tertiary">
                            <span>📊</span> Ver Inscripciones
                        </a>
                    </div>
                </form>
            </div>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>📍 Contacto</h3>
                    <p>Email: info@itech.com</p>
                    <p>Teléfono: +507 380-1234</p>
                    <p>WhatsApp: +507 6000-5555</p>
                </div>
                
                <div class="footer-section">
                    <h3>🔗 Síguenos</h3>
                    <p>Instagram: @iTECH_Panama</p>
                    <p>Twitter: @iTECH_Events</p>
                    <p>LinkedIn: iTECH Panama</p>
                </div>
                
                <div class="footer-section">
                    <h3>📅 Próximos Eventos</h3>
                    <p>Conferencia IA - Marzo 2025</p>
                    <p>Workshop DevOps - Abril 2025</p>
                    <p>Hackathon - Mayo 2025</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 iTECH. All rights reserved.</p>
                <p>Desarrollado con ❤️ para la comunidad tecnológica</p>
            </div>
        </footer>
    </div>

    <script src="public/js/validacion.js"></script>
</body>
</html>
