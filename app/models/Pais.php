<?php
require_once __DIR__ . '/../../config/Database.php';

/**
 * Modelo Pais - Gestión de países
 */
class Pais {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Obtiene todos los países ordenados alfabéticamente
     */
    public function obtenerTodos() {
        $sql = "SELECT id_pais, nombre_pais, codigo_iso 
                FROM paises 
                ORDER BY nombre_pais ASC";
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Obtiene un país por ID
     */
    public function obtenerPorId($id) {
        $sql = "SELECT id_pais, nombre_pais, codigo_iso 
                FROM paises 
                WHERE id_pais = ?";
        return $this->db->fetchOne($sql, [$id]);
    }
    
    /**
     * Busca un país por nombre
     */
    public function buscarPorNombre($nombre) {
        $sql = "SELECT id_pais, nombre_pais, codigo_iso 
                FROM paises 
                WHERE nombre_pais LIKE ?";
        return $this->db->fetchAll($sql, ["%{$nombre}%"]);
    }
}
