-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS enfermeria_irab;
USE enfermeria_irab;

-- =========================================================
-- FASE 1: TABLAS PADRE (Sin dependencias)
-- =========================================================

CREATE TABLE roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE establecimientos_salud (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  cuartel VARCHAR(50),
  tipo ENUM('CAPS', 'Hospital') NOT NULL
) ENGINE=InnoDB;

CREATE TABLE tutores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dni VARCHAR(20) UNIQUE NOT NULL,
  nombre VARCHAR(100) NOT NULL,
  telefono VARCHAR(20)
) ENGINE=InnoDB;

CREATE TABLE factores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  denominacion VARCHAR(100) NOT NULL,
  tipo ENUM('Riesgo', 'Proteccion') NOT NULL,
  tipo_formulario ENUM('TAL', 'WDF', 'Ambos') NOT NULL
) ENGINE=InnoDB;

CREATE TABLE sintomas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre_sintoma VARCHAR(100) NOT NULL,
  tipo_formulario ENUM('TAL', 'WDF') NOT NULL
) ENGINE=InnoDB;

-- =========================================================
-- FASE 2: TABLAS CON DEPENDENCIAS DE PRIMER NIVEL
-- =========================================================

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  id_rol INT NOT NULL,
  id_establecimiento_asignado INT NOT NULL,
  FOREIGN KEY (id_rol) REFERENCES roles(id),
  FOREIGN KEY (id_establecimiento_asignado) REFERENCES establecimientos_salud(id)
) ENGINE=InnoDB;

CREATE TABLE pacientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dni VARCHAR(20) UNIQUE,
  nombre VARCHAR(100) NOT NULL,
  fecha_nacimiento DATE NOT NULL,
  id_tutor INT NOT NULL,
  id_establecimiento_habitual INT NOT NULL,
  FOREIGN KEY (id_tutor) REFERENCES tutores(id),
  FOREIGN KEY (id_establecimiento_habitual) REFERENCES establecimientos_salud(id)
) ENGINE=InnoDB;

CREATE TABLE valores_factores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_factor INT NOT NULL,
  valor VARCHAR(100) NOT NULL,
  FOREIGN KEY (id_factor) REFERENCES factores(id)
) ENGINE=InnoDB;

CREATE TABLE valores_sintomas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_sintoma INT NOT NULL,
  valor_min DECIMAL(10,2),
  valor_max DECIMAL(10,2),
  valor_texto VARCHAR(255),
  puntos INT NOT NULL,
  FOREIGN KEY (id_sintoma) REFERENCES sintomas(id)
) ENGINE=InnoDB;

-- =========================================================
-- FASE 3: TRANSACCIONES (Visitas, Factores de la visita y Controles)
-- =========================================================

CREATE TABLE visitas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_paciente INT NOT NULL,
  id_usuario INT NOT NULL,
  id_establecimiento INT NOT NULL,
  fecha_ingreso DATETIME NOT NULL,
  diagnostico ENUM('SBO', 'BQL', 'NMN', 'Otros'),
  estado_derivacion ENUM('Internacion', 'Derivacion', 'Domicilio'),
  id_turno_protegido_lugar INT,
  turno_protegido_fecha DATE,
  medicacion_egreso VARCHAR(255),
  fecha_alta DATE,
  observaciones_finales TEXT,
  FOREIGN KEY (id_paciente) REFERENCES pacientes(id),
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
  FOREIGN KEY (id_establecimiento) REFERENCES establecimientos_salud(id),
  FOREIGN KEY (id_turno_protegido_lugar) REFERENCES establecimientos_salud(id)
) ENGINE=InnoDB;

CREATE TABLE paciente_factores (
  id_visita INT NOT NULL,
  id_paciente INT NOT NULL,
  id_factor INT NOT NULL,
  valor_registrado VARCHAR(100),
  PRIMARY KEY (id_visita, id_paciente, id_factor),
  FOREIGN KEY (id_visita) REFERENCES visitas(id),
  FOREIGN KEY (id_paciente) REFERENCES pacientes(id),
  FOREIGN KEY (id_factor) REFERENCES factores(id)
) ENGINE=InnoDB;

CREATE TABLE controles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_visita INT NOT NULL,
  fecha_hora DATETIME NOT NULL,
  score_total INT,
  estado_gravedad ENUM('Leve', 'Moderada', 'Grave'),
  medicacion VARCHAR(255),
  observaciones TEXT,
  FOREIGN KEY (id_visita) REFERENCES visitas(id)
) ENGINE=InnoDB;

-- =========================================================
-- FASE 4: DETALLE DEL CONTROL
-- =========================================================

CREATE TABLE control_sintomas (
  id_control INT NOT NULL,
  id_sintoma INT NOT NULL,
  valor_registrado VARCHAR(255),
  PRIMARY KEY (id_control, id_sintoma),
  FOREIGN KEY (id_control) REFERENCES controles(id),
  FOREIGN KEY (id_sintoma) REFERENCES sintomas(id)
) ENGINE=InnoDB;
