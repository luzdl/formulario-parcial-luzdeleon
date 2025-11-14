<?php
require_once __DIR__ . '/../../config/Database.php';

/**
 * Modelo AreaInteres - Gestión de áreas tecnológicas de interés
 */
class AreaInteres {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Obtiene todas las áreas de interés activas
     */
    public function obtenerTodas() {
        $sql = "SELECT id_area, nombre_area, descripcion 
                FROM areas_interes 
                WHERE activo = 1 
                ORDER BY nombre_area ASC";
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Obtiene un área por ID
     */
    public function obtenerPorId($id) {
        $sql = "SELECT id_area, nombre_area, descripcion 
                FROM areas_interes 
                WHERE id_area = ? AND activo = 1";
        return $this->db->fetchOne($sql, [$id]);
    }
    
    /**
     * Obtiene las áreas de un inscriptor
     */
    public function obtenerPorInscriptor($idInscriptor) {
        $sql = "SELECT a.id_area, a.nombre_area, a.descripcion 
                FROM areas_interes a
                INNER JOIN inscriptor_areas ia ON a.id_area = ia.id_area
                WHERE ia.id_inscriptor = ? AND a.activo = 1
                ORDER BY a.nombre_area ASC";
        return $this->db->fetchAll($sql, [$idInscriptor]);
    }
}
