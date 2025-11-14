<?php
/**
 * Procesa el formulario de inscripción
 */
session_start();

require_once __DIR__ . '/app/controllers/FormularioController.php';

$controller = new FormularioController();
$controller->procesarFormulario();
