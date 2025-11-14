<?php
/**
 * Punto de entrada principal - Formulario de inscripción
 */
session_start();

require_once __DIR__ . '/app/controllers/FormularioController.php';

$controller = new FormularioController();
$controller->mostrarFormulario();
