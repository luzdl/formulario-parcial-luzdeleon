# 🚀 Sistema de Inscripción iTECH

Sistema web completo de inscripción para eventos tecnológicos desarrollado con arquitectura MVC en PHP.

## 📋 Características

✅ **Formulario completo** con todos los campos requeridos:
- Nombre y Apellido (capitalizados automáticamente)
- Edad y Sexo
- País de Residencia y Nacionalidad
- Correo y Celular
- Temas Tecnológicos de Interés (checkboxes múltiples)
- Observaciones sobre el evento

✅ **Base de datos relacional** con tablas normalizadas:
- Tabla `inscriptores` para datos personales
- Tabla `paises` para países y nacionalidades
- Tabla `areas_interes` para temas tecnológicos
- Tabla `inscriptor_areas` para relación muchos a muchos

✅ **Validaciones**:
- Validación PHP del lado del servidor
- Capitalización automática de nombres y apellidos
- Verificación de correos duplicados
- Validación de rangos de edad
- Validación de formato de email y teléfono

✅ **Reporte de inscripciones** con visualización completa de datos

✅ **Diseño moderno** con CSS (gradientes, colores vibrantes, responsive)

✅ **Arquitectura MVC** profesional

## 🗄️ Instalación de la Base de Datos

### Paso 1: Crear la base de datos

1. Abre **phpMyAdmin** en tu navegador: `http://127.0.0.1/phpmyadmin/`
2. Haz clic en la pestaña **SQL**
3. Copia y pega el siguiente script completo:

```sql
CREATE DATABASE IF NOT EXISTS formulario_itech_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE formulario_itech_db;

CREATE TABLE IF NOT EXISTS paises (
    id_pais INT AUTO_INCREMENT PRIMARY KEY,
    nombre_pais VARCHAR(100) NOT NULL UNIQUE,
    codigo_iso CHAR(2) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS areas_interes (
    id_area INT AUTO_INCREMENT PRIMARY KEY,
    nombre_area VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE IF NOT EXISTS inscriptor_areas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_inscriptor INT NOT NULL,
    id_area INT NOT NULL,
    fecha_seleccion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_inscriptor) REFERENCES inscriptores(id_inscriptor) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_area) REFERENCES areas_interes(id_area) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE KEY unique_inscriptor_area (id_inscriptor, id_area)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO paises (nombre_pais, codigo_iso) VALUES
('Argentina', 'AR'), ('Bolivia', 'BO'), ('Brasil', 'BR'), ('Chile', 'CL'),
('Colombia', 'CO'), ('Costa Rica', 'CR'), ('Cuba', 'CU'), ('Ecuador', 'EC'),
('El Salvador', 'SV'), ('España', 'ES'), ('Estados Unidos', 'US'),
('Guatemala', 'GT'), ('Honduras', 'HN'), ('México', 'MX'),
('Nicaragua', 'NI'), ('Panamá', 'PA'), ('Paraguay', 'PY'),
('Perú', 'PE'), ('Puerto Rico', 'PR'), ('República Dominicana', 'DO'),
('Uruguay', 'UY'), ('Venezuela', 'VE');

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
```

4. Haz clic en el botón **Continuar** o **Go**
5. ¡La base de datos está lista! ✅

## ⚙️ Configuración

Si necesitas cambiar las credenciales de la base de datos, edita el archivo:
`config/Database.php`

```php
private $host = "localhost";
private $database = "formulario_itech_db";
private $username = "root";
private $password = "";
```

## 🚀 Uso

1. Asegúrate de que XAMPP esté corriendo (Apache y MySQL)
2. Abre tu navegador y ve a: `http://localhost/formulario-parcial-luzdeleon/`
3. Completa el formulario de inscripción
4. Para ver el reporte: `http://localhost/formulario-parcial-luzdeleon/reporte.php`

## 📁 Estructura del Proyecto (Arquitectura MVC)

```
formulario-parcial-luzdeleon/
│
├── app/
│   ├── controllers/
│   │   ├── FormularioController.php    # Controlador del formulario
│   │   └── ReporteController.php       # Controlador del reporte
│   │
│   ├── models/
│   │   ├── Pais.php                    # Modelo de países
│   │   ├── AreaInteres.php             # Modelo de áreas de interés
│   │   └── Inscriptor.php              # Modelo de inscriptores
│   │
│   └── views/
│       ├── formulario.php              # Vista del formulario
│       └── reporte.php                 # Vista del reporte
│
├── config/
│   └── Database.php                    # Clase de conexión (Singleton)
│
├── public/
│   ├── css/
│   │   └── estilos.css                 # Estilos del sistema
│   └── js/
│       └── validacion.js               # Validaciones JavaScript
│
├── index.php                           # Punto de entrada principal
├── procesar.php                        # Procesa el formulario
└── reporte.php                         # Muestra el reporte
```

## ✨ Funcionalidades Destacadas

### 1. Patrón Singleton para Base de Datos
Conexión única y eficiente a la base de datos.

### 2. Validaciones Múltiples
- **PHP**: Validación del lado del servidor para seguridad
- **JavaScript**: Validación en tiempo real para mejor UX

### 3. Capitalización Automática
Los nombres y apellidos se capitalizan automáticamente (primera letra en mayúscula).

### 4. Transacciones SQL
Uso de transacciones para garantizar integridad de datos.

### 5. Diseño Responsive
Funciona perfectamente en móviles, tablets y escritorio.

### 6. Footer Completo
Incluye información de contacto y año actual (© 2025 iTECH. All rights reserved.)

## 🎨 Estilos

El diseño utiliza:
- Gradientes modernos (morado/azul)
- Animaciones suaves
- Diseño responsive
- Colores vibrantes (NO blanco y negro)
- Sombras y efectos visuales

## 📊 Cumplimiento de Criterios

✅ Todos los campos del formulario (10 criterios)
✅ Base de datos en phpMyAdmin
✅ Clase de conexión con funciones de BD
✅ Tablas normalizadas (inscriptores, países, áreas de interés)
✅ Reporte completo de inscripciones
✅ Validaciones PHP del lado del servidor
✅ Capitalización automática de nombres y apellidos
✅ CSS con diseño atractivo (no blanco y negro)
✅ Footer con año actual e información de contacto

## 👨‍💻 Desarrollador

Sistema desarrollado con arquitectura MVC profesional para iTECH Events 2025.

## 📝 Licencia

© 2025 iTECH. All rights reserved.
