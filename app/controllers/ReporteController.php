<?php
require_once __DIR__ . '/../models/Inscriptor.php';
require_once __DIR__ . '/../models/AreaInteres.php';

/**
 * Controlador de reportes
 */
class ReporteController {
    private $inscriptorModel;
    private $areaInteresModel;
    
    public function __construct() {
        $this->inscriptorModel = new Inscriptor();
        $this->areaInteresModel = new AreaInteres();
    }
    
    /**
     * Muestra el reporte de inscripciones
     */
    public function mostrarReporte() {
        $inscriptores = $this->inscriptorModel->obtenerTodos();
        
        // Obtener áreas de interés para cada inscriptor
        foreach ($inscriptores as &$inscriptor) {
            $inscriptor['areas'] = $this->areaInteresModel->obtenerPorInscriptor($inscriptor['id_inscriptor']);
        }
        
        $totalInscriptores = $this->inscriptorModel->obtenerTotal();
        
        require_once __DIR__ . '/../views/reporte.php';
    }
}
