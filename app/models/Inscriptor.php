<?php
require_once __DIR__ . '/../../config/Database.php';

/**
 * Modelo Inscriptor - Gestión de datos de inscriptores
 */
class Inscriptor {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Crea un nuevo inscriptor
     */
    public function crear($datos) {
        try {
            $this->db->beginTransaction();
            
            // Capitalizar nombre y apellido
            $nombre = $this->capitalizarNombre($datos['nombre']);
            $apellido = $this->capitalizarNombre($datos['apellido']);
            
            // Insertar inscriptor
            $sql = "INSERT INTO inscriptores 
                    (nombre, apellido, edad, sexo, id_pais_residencia, 
                     id_nacionalidad, correo, celular, observaciones) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $this->db->query($sql, [
                $nombre,
                $apellido,
                $datos['edad'],
                $datos['sexo'],
                $datos['pais_residencia'],
                $datos['nacionalidad'],
                $datos['correo'],
                $datos['celular'],
                $datos['observaciones']
            ]);
            
            $idInscriptor = $this->db->lastInsertId();
            
            // Insertar áreas de interés
            if (!empty($datos['areas_interes'])) {
                $this->asociarAreasInteres($idInscriptor, $datos['areas_interes']);
            }
            
            $this->db->commit();
            return $idInscriptor;
            
        } catch (Exception $e) {
            $this->db->rollback();
            throw new Exception("Error al crear inscriptor: " . $e->getMessage());
        }
    }
    
    /**
     * Asocia áreas de interés a un inscriptor
     */
    private function asociarAreasInteres($idInscriptor, $areasInteres) {
        $sql = "INSERT INTO inscriptor_areas (id_inscriptor, id_area) VALUES (?, ?)";
        
        foreach ($areasInteres as $idArea) {
            $this->db->query($sql, [$idInscriptor, $idArea]);
        }
    }
    
    /**
     * Capitaliza la primera letra de cada palabra
     */
    private function capitalizarNombre($texto) {
        return mb_convert_case(trim($texto), MB_CASE_TITLE, "UTF-8");
    }
    
    /**
     * Obtiene todos los inscriptores con información relacionada
     */
    public function obtenerTodos() {
        $sql = "SELECT 
                    i.id_inscriptor,
                    i.nombre,
                    i.apellido,
                    i.edad,
                    i.sexo,
                    i.correo,
                    i.celular,
                    i.observaciones,
                    i.fecha_inscripcion,
                    pr.nombre_pais as pais_residencia,
                    pn.nombre_pais as nacionalidad
                FROM inscriptores i
                INNER JOIN paises pr ON i.id_pais_residencia = pr.id_pais
                INNER JOIN paises pn ON i.id_nacionalidad = pn.id_pais
                ORDER BY i.fecha_inscripcion DESC";
        
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Obtiene un inscriptor por ID
     */
    public function obtenerPorId($id) {
        $sql = "SELECT 
                    i.*,
                    pr.nombre_pais as pais_residencia,
                    pn.nombre_pais as nacionalidad
                FROM inscriptores i
                INNER JOIN paises pr ON i.id_pais_residencia = pr.id_pais
                INNER JOIN paises pn ON i.id_nacionalidad = pn.id_pais
                WHERE i.id_inscriptor = ?";
        
        return $this->db->fetchOne($sql, [$id]);
    }
    
    /**
     * Valida que el correo no esté duplicado
     */
    public function existeCorreo($correo, $idExcluir = null) {
        $sql = "SELECT COUNT(*) as total FROM inscriptores WHERE correo = ?";
        $params = [$correo];
        
        if ($idExcluir) {
            $sql .= " AND id_inscriptor != ?";
            $params[] = $idExcluir;
        }
        
        $resultado = $this->db->fetchOne($sql, $params);
        return $resultado['total'] > 0;
    }
    
    /**
     * Obtiene el total de inscriptores
     */
    public function obtenerTotal() {
        $sql = "SELECT COUNT(*) as total FROM inscriptores";
        $resultado = $this->db->fetchOne($sql);
        return $resultado['total'];
    }
}
