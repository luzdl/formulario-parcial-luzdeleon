-- =====================================================
-- SCRIPT DE CREACIÓN DE BASE DE DATOS
-- Sistema de Inscripción iTECH
-- =====================================================

-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS formulario_itech_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE formulario_itech_db;

-- Tabla de países
CREATE TABLE IF NOT EXISTS paises (
    id_pais INT AUTO_INCREMENT PRIMARY KEY,
    nombre_pais VARCHAR(100) NOT NULL UNIQUE,
    codigo_iso CHAR(2) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de áreas de interés tecnológico
CREATE TABLE IF NOT EXISTS areas_interes (
    id_area INT AUTO_INCREMENT PRIMARY KEY,
    nombre_area VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla principal de inscriptores
CREATE TABLE IF NOT EXISTS inscriptores (
    id_inscriptor INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    edad INT NOT NULL,
    sexo ENUM('Masculino', 'Femenino', 'Otro', 'Prefiero no decir') NOT NULL,
    id_pais_residencia INT NOT NULL,
    id_nacionalidad INT NOT NULL,
    correo VARCHAR(150) NOT NULL,
    celular VARCHAR(20) NOT NULL,
    observaciones TEXT,
    fecha_inscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pais_residencia) REFERENCES paises(id_pais) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_nacionalidad) REFERENCES paises(id_pais) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX idx_nombre_apellido (nombre, apellido),
    INDEX idx_fecha_inscripcion (fecha_inscripcion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla relacional para áreas de interés seleccionadas (muchos a muchos)
CREATE TABLE IF NOT EXISTS inscriptor_areas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_inscriptor INT NOT NULL,
    id_area INT NOT NULL,
    fecha_seleccion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_inscriptor) REFERENCES inscriptores(id_inscriptor) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_area) REFERENCES areas_interes(id_area) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE KEY unique_inscriptor_area (id_inscriptor, id_area)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- DATOS INICIALES
-- =====================================================

-- Insertar países de ejemplo
INSERT INTO paises (nombre_pais, codigo_iso) VALUES
('Argentina', 'AR'),
('Bolivia', 'BO'),
('Brasil', 'BR'),
('Chile', 'CL'),
('Colombia', 'CO'),
('Costa Rica', 'CR'),
('Cuba', 'CU'),
('Ecuador', 'EC'),
('El Salvador', 'SV'),
('España', 'ES'),
('Estados Unidos', 'US'),
('Guatemala', 'GT'),
('Honduras', 'HN'),
('México', 'MX'),
('Nicaragua', 'NI'),
('Panamá', 'PA'),
('Paraguay', 'PY'),
('Perú', 'PE'),
('Puerto Rico', 'PR'),
('República Dominicana', 'DO'),
('Uruguay', 'UY'),
('Venezuela', 'VE');

-- Insertar áreas de interés tecnológico
INSERT INTO areas_interes (nombre_area, descripcion) VALUES
('Inteligencia Artificial', 'Machine Learning, Deep Learning, Redes Neuronales'),
('Desarrollo Web', 'Frontend, Backend, Full Stack'),
('Ciberseguridad', 'Seguridad informática, Ethical Hacking, Pentesting'),
('Cloud Computing', 'AWS, Azure, Google Cloud Platform'),
('DevOps', 'CI/CD, Automatización, Contenedores'),
('Desarrollo Móvil', 'Android, iOS, React Native, Flutter'),
('Data Science', 'Análisis de datos, Big Data, Visualización'),
('Blockchain', 'Criptomonedas, Smart Contracts, DeFi'),
('IoT (Internet de las Cosas)', 'Dispositivos conectados, Automatización'),
('Realidad Virtual/Aumentada', 'VR, AR, Metaverso');

-- =====================================================
-- FIN DEL SCRIPT
-- =====================================================
