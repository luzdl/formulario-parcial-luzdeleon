<?php
require_once __DIR__ . '/../models/Pais.php';
require_once __DIR__ . '/../models/AreaInteres.php';
require_once __DIR__ . '/../models/Inscriptor.php';

/**
 * Controlador del formulario de inscripción
 */
class FormularioController {
    private $paisModel;
    private $areaInteresModel;
    private $inscriptorModel;
    
    public function __construct() {
        $this->paisModel = new Pais();
        $this->areaInteresModel = new AreaInteres();
        $this->inscriptorModel = new Inscriptor();
    }
    
    /**
     * Muestra el formulario de inscripción
     */
    public function mostrarFormulario() {
        $paises = $this->paisModel->obtenerTodos();
        $areasInteres = $this->areaInteresModel->obtenerTodas();
        
        require_once __DIR__ . '/../views/formulario.php';
    }
    
    /**
     * Procesa el envío del formulario
     */
    public function procesarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }
        
        // Validar datos
        $errores = $this->validarDatos($_POST);
        
        if (!empty($errores)) {
            $_SESSION['errores'] = $errores;
            $_SESSION['datos_formulario'] = $_POST;
            header('Location: index.php');
            exit;
        }
        
        try {
            // Preparar datos
            $datos = [
                'nombre' => trim($_POST['nombre']),
                'apellido' => trim($_POST['apellido']),
                'edad' => intval($_POST['edad']),
                'sexo' => $_POST['sexo'],
                'pais_residencia' => intval($_POST['pais_residencia']),
                'nacionalidad' => intval($_POST['nacionalidad']),
                'correo' => trim($_POST['correo']),
                'celular' => trim($_POST['celular']),
                'observaciones' => trim($_POST['observaciones'] ?? ''),
                'areas_interes' => $_POST['areas_interes'] ?? []
            ];
            
            // Crear inscriptor
            $idInscriptor = $this->inscriptorModel->crear($datos);
            
            $_SESSION['mensaje_exito'] = "¡Inscripción exitosa! Tu registro ha sido guardado correctamente.";
            header('Location: index.php?exito=1');
            exit;
            
        } catch (Exception $e) {
            $_SESSION['errores'] = ['Error al procesar la inscripción: ' . $e->getMessage()];
            $_SESSION['datos_formulario'] = $_POST;
            header('Location: index.php');
            exit;
        }
    }
    
    /**
     * Valida los datos del formulario
     */
    private function validarDatos($datos) {
        $errores = [];
        
        // Validar nombre
        if (empty($datos['nombre']) || strlen(trim($datos['nombre'])) < 2) {
            $errores[] = "El nombre es requerido y debe tener al menos 2 caracteres.";
        }
        
        // Validar apellido
        if (empty($datos['apellido']) || strlen(trim($datos['apellido'])) < 2) {
            $errores[] = "El apellido es requerido y debe tener al menos 2 caracteres.";
        }
        
        // Validar edad
        if (empty($datos['edad']) || !is_numeric($datos['edad']) || $datos['edad'] < 15 || $datos['edad'] > 100) {
            $errores[] = "La edad debe estar entre 15 y 100 años.";
        }
        
        // Validar sexo
        $sexosValidos = ['Masculino', 'Femenino', 'Otro', 'Prefiero no decir'];
        if (empty($datos['sexo']) || !in_array($datos['sexo'], $sexosValidos)) {
            $errores[] = "Debe seleccionar un sexo válido.";
        }
        
        // Validar país de residencia
        if (empty($datos['pais_residencia']) || !is_numeric($datos['pais_residencia'])) {
            $errores[] = "Debe seleccionar un país de residencia.";
        }
        
        // Validar nacionalidad
        if (empty($datos['nacionalidad']) || !is_numeric($datos['nacionalidad'])) {
            $errores[] = "Debe seleccionar una nacionalidad.";
        }
        
        // Validar correo
        if (empty($datos['correo']) || !filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = "Debe ingresar un correo electrónico válido.";
        } else {
            // Verificar si el correo ya existe
            if ($this->inscriptorModel->existeCorreo($datos['correo'])) {
                $errores[] = "Este correo electrónico ya está registrado.";
            }
        }
        
        // Validar celular
        if (empty($datos['celular']) || !preg_match('/^[\d\s\+\-\(\)]{8,20}$/', $datos['celular'])) {
            $errores[] = "Debe ingresar un número de celular válido.";
        }
        
        // Validar áreas de interés (al menos una)
        if (empty($datos['areas_interes']) || !is_array($datos['areas_interes'])) {
            $errores[] = "Debe seleccionar al menos un tema tecnológico de interés.";
        }
        
        return $errores;
    }
}
