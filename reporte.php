<?php
/**
 * Muestra el reporte de inscripciones
 */
session_start();

require_once __DIR__ . '/app/controllers/ReporteController.php';

$controller = new ReporteController();
$controller->mostrarReporte();
