<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Inscripciones - iTECH</title>
    <link rel="stylesheet" href="public/css/estilos.css">
    <style>
        .table-container {
            overflow-x: auto;
            margin: 2rem 0;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .data-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .data-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .data-table td {
            padding: 1rem;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .data-table tbody tr:hover {
            background-color: #f5f5f5;
        }
        
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: #e3f2fd;
            color: #1976d2;
            border-radius: 12px;
            font-size: 0.85rem;
            margin: 0.2rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #667eea;
            margin: 0.5rem 0;
        }
        
        .stat-label {
            color: #666;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <h1 class="logo">🚀 iTECH</h1>
                <p class="tagline">Reporte de Inscripciones</p>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <div class="form-wrapper">
                <div class="form-header">
                    <h2>📊 Dashboard de Inscripciones</h2>
                    <p>Registro completo de participantes en eventos tecnológicos</p>
                </div>

                <!-- Estadísticas -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $totalInscriptores; ?></div>
                        <div class="stat-label">Total de Inscripciones</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo date('Y'); ?></div>
                        <div class="stat-label">Año Actual</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo count($inscriptores); ?></div>
                        <div class="stat-label">Registros Mostrados</div>
                    </div>
                </div>

                <!-- Tabla de inscripciones -->
                <?php if (empty($inscriptores)): ?>
                    <div class="alert alert-info">
                        <span class="alert-icon">ℹ️</span>
                        <span>No hay inscripciones registradas todavía.</span>
                    </div>
                <?php else: ?>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre Completo</th>
                                    <th>Edad</th>
                                    <th>Sexo</th>
                                    <th>País / Nacionalidad</th>
                                    <th>Contacto</th>
                                    <th>Temas de Interés</th>
                                    <th>Observaciones</th>
                                    <th>Fecha Inscripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($inscriptores as $inscriptor): ?>
                                    <tr>
                                        <td><?php echo $inscriptor['id_inscriptor']; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($inscriptor['nombre'] . ' ' . $inscriptor['apellido']); ?></strong>
                                        </td>
                                        <td><?php echo $inscriptor['edad']; ?> años</td>
                                        <td><?php echo htmlspecialchars($inscriptor['sexo']); ?></td>
                                        <td>
                                            <div><?php echo htmlspecialchars($inscriptor['pais_residencia']); ?></div>
                                            <small style="color: #666;">Nacionalidad: <?php echo htmlspecialchars($inscriptor['nacionalidad']); ?></small>
                                        </td>
                                        <td>
                                            <div>📧 <?php echo htmlspecialchars($inscriptor['correo']); ?></div>
                                            <div>📱 <?php echo htmlspecialchars($inscriptor['celular']); ?></div>
                                        </td>
                                        <td>
                                            <?php foreach ($inscriptor['areas'] as $area): ?>
                                                <span class="badge"><?php echo htmlspecialchars($area['nombre_area']); ?></span>
                                            <?php endforeach; ?>
                                        </td>
                                        <td>
                                            <?php 
                                            $obs = htmlspecialchars($inscriptor['observaciones']);
                                            echo $obs ? (strlen($obs) > 50 ? substr($obs, 0, 50) . '...' : $obs) : '-';
                                            ?>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($inscriptor['fecha_inscripcion'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <!-- Botones de acción -->
                <div class="form-actions">
                    <a href="index.php" class="btn btn-primary">
                        <span>👈</span> Volver al Formulario
                    </a>
                    <button onclick="window.print()" class="btn btn-secondary">
                        <span>🖨️</span> Imprimir Reporte
                    </button>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>📍 Contacto</h3>
                    <p>Email: info@itech.com</p>
                    <p>Teléfono: +507 380-1234</p>
                </div>
                
                <div class="footer-section">
                    <h3>🔗 Redes Sociales</h3>
                    <p>Instagram: @iTECH_Panama</p>
                    <p>Twitter: @iTECH_Events</p>
                </div>
                
                <div class="footer-section">
                    <h3>📈 Estadísticas</h3>
                    <p>Usuarios registrados: <?php echo $totalInscriptores; ?></p>
                    <p>Última actualización: <?php echo date('d/m/Y'); ?></p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 iTECH. All rights reserved.</p>
                <p>Sistema de gestión de inscripciones v1.0</p>
            </div>
        </footer>
    </div>
</body>
</html>
