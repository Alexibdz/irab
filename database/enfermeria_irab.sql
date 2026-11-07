-- =========================================================
-- BASE DE DATOS: enfermeria_irab
-- =========================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `enfermeria_irab` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `enfermeria_irab`;

-- Desactivar llaves foráneas para reinicialización limpia
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `control_sintomas`;
DROP TABLE IF EXISTS `control_medicaciones`;
DROP TABLE IF EXISTS `controles`;
DROP TABLE IF EXISTS `medicaciones`;
DROP TABLE IF EXISTS `paciente_factores`;
DROP TABLE IF EXISTS `visitas`;
DROP TABLE IF EXISTS `valores_sintomas`;
DROP TABLE IF EXISTS `valores_factores`;
DROP TABLE IF EXISTS `permisos`;
DROP TABLE IF EXISTS `pacientes`;
DROP TABLE IF EXISTS `usuarios`;
DROP TABLE IF EXISTS `sintomas`;
DROP TABLE IF EXISTS `factores`;
DROP TABLE IF EXISTS `tutores`;
DROP TABLE IF EXISTS `establecimientos_salud`;
DROP TABLE IF EXISTS `roles`;

SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------
-- Tablas Padre
-- --------------------------------------------------------

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_edicion` datetime DEFAULT NULL,
  `fecha_borrado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `establecimientos_salud` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `cuartel` enum('Primer Cuartel.','Segundo Cuartel','Tercer Cuartel','Cuarto Cuartel','Quinto Cuartel','Zona Abadía y Barrio Arenal') DEFAULT NULL,
  `tipo` enum('CAPS','Hospital') NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_edicion` datetime DEFAULT NULL,
  `fecha_borrado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tutores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL DEFAULT '',
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_edicion` datetime DEFAULT NULL,
  `fecha_borrado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `factores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(100) NOT NULL,
  `tipo` enum('Riesgo','Proteccion') NOT NULL,
  `tipo_formulario` enum('TAL','WDF','Ambos') NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_edicion` datetime DEFAULT NULL,
  `fecha_borrado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `sintomas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_sintoma` varchar(100) NOT NULL,
  `tipo_formulario` enum('TAL','WDF') NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_edicion` datetime DEFAULT NULL,
  `fecha_borrado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Tablas con dependencias
-- --------------------------------------------------------

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rol` int(11) NOT NULL,
  `modulo` varchar(100) NOT NULL,
  `puede_ver` tinyint(1) NOT NULL DEFAULT 0,
  `puede_crear` tinyint(1) NOT NULL DEFAULT 0,
  `puede_editar` tinyint(1) NOT NULL DEFAULT 0,
  `puede_eliminar` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_edicion` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `fecha_borrado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_id_rol` (`id_rol`),
  KEY `idx_modulo` (`modulo`),
  CONSTRAINT `fk_permisos_roles` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL DEFAULT '',
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_establecimiento_asignado` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_edicion` datetime DEFAULT NULL,
  `fecha_borrado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `id_rol` (`id_rol`),
  KEY `id_establecimiento_asignado` (`id_establecimiento_asignado`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`),
  CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`id_establecimiento_asignado`) REFERENCES `establecimientos_salud` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(20) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL DEFAULT '',
  `fecha_nacimiento` date NOT NULL,
  `domicilio` varchar(150) DEFAULT NULL,
  `barrio` varchar(100) DEFAULT NULL,
  `id_tutor` int(11) NOT NULL,
  `id_area_programatica` int(11) DEFAULT NULL,
  `id_establecimiento_habitual` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_edicion` datetime DEFAULT NULL,
  `fecha_borrado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dni` (`dni`),
  KEY `id_tutor` (`id_tutor`),
  KEY `id_establecimiento_habitual` (`id_establecimiento_habitual`),
  KEY `pacientes_ibfk_3` (`id_area_programatica`),
  CONSTRAINT `pacientes_ibfk_1` FOREIGN KEY (`id_tutor`) REFERENCES `tutores` (`id`),
  CONSTRAINT `pacientes_ibfk_2` FOREIGN KEY (`id_establecimiento_habitual`) REFERENCES `establecimientos_salud` (`id`),
  CONSTRAINT `pacientes_ibfk_3` FOREIGN KEY (`id_area_programatica`) REFERENCES `establecimientos_salud` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `valores_factores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_factor` int(11) NOT NULL,
  `valor` varchar(100) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_edicion` datetime DEFAULT NULL,
  `fecha_borrado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_factor` (`id_factor`),
  CONSTRAINT `valores_factores_ibfk_1` FOREIGN KEY (`id_factor`) REFERENCES `factores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `valores_sintomas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_sintoma` int(11) NOT NULL,
  `valor_min` decimal(10,2) DEFAULT NULL,
  `valor_max` decimal(10,2) DEFAULT NULL,
  `valor_texto` varchar(255) DEFAULT NULL,
  `puntos` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_edicion` datetime DEFAULT NULL,
  `fecha_borrado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_sintoma` (`id_sintoma`),
  CONSTRAINT `valores_sintomas_ibfk_1` FOREIGN KEY (`id_sintoma`) REFERENCES `sintomas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `visitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_establecimiento` int(11) NOT NULL,
  `fecha_ingreso` datetime NOT NULL,
  `diagnostico` varchar(100) DEFAULT NULL,
  `estado_derivacion` enum('Internacion','Derivacion','Domicilio') DEFAULT NULL,
  `id_turno_protegido_lugar` int(11) DEFAULT NULL,
  `turno_protegido_fecha` date DEFAULT NULL,
  `medicacion_egreso` varchar(255) DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  `observaciones_finales` text DEFAULT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_edicion` datetime DEFAULT NULL,
  `fecha_borrado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_paciente` (`id_paciente`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_establecimiento` (`id_establecimiento`),
  KEY `id_turno_protegido_lugar` (`id_turno_protegido_lugar`),
  CONSTRAINT `visitas_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id`),
  CONSTRAINT `visitas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `visitas_ibfk_3` FOREIGN KEY (`id_establecimiento`) REFERENCES `establecimientos_salud` (`id`),
  CONSTRAINT `visitas_ibfk_4` FOREIGN KEY (`id_turno_protegido_lugar`) REFERENCES `establecimientos_salud` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `paciente_factores` (
  `id_visita` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_factor` int(11) NOT NULL,
  `valor_registrado` varchar(100) DEFAULT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_edicion` datetime DEFAULT NULL,
  `fecha_borrado` datetime DEFAULT NULL,
  PRIMARY KEY (`id_visita`,`id_paciente`,`id_factor`),
  KEY `id_paciente` (`id_paciente`),
  KEY `id_factor` (`id_factor`),
  CONSTRAINT `paciente_factores_ibfk_1` FOREIGN KEY (`id_visita`) REFERENCES `visitas` (`id`),
  CONSTRAINT `paciente_factores_ibfk_2` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id`),
  CONSTRAINT `paciente_factores_ibfk_3` FOREIGN KEY (`id_factor`) REFERENCES `factores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `controles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_visita` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `score_total` int(11) DEFAULT NULL,
  `estado_gravedad` enum('Leve','Moderada','Grave') DEFAULT NULL,
  `medicacion` varchar(255) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_edicion` datetime DEFAULT NULL,
  `fecha_borrado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_visita` (`id_visita`),
  CONSTRAINT `controles_ibfk_1` FOREIGN KEY (`id_visita`) REFERENCES `visitas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `medicaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_edicion` datetime DEFAULT NULL,
  `fecha_borrado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_medicaciones_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `control_medicaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_control` int(11) NOT NULL,
  `id_medicacion` int(11) NOT NULL,
  `dosis` varchar(100) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_edicion` datetime DEFAULT NULL,
  `fecha_borrado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_control` (`id_control`),
  KEY `id_medicacion` (`id_medicacion`),
  CONSTRAINT `control_medicaciones_ibfk_1` FOREIGN KEY (`id_control`) REFERENCES `controles` (`id`),
  CONSTRAINT `control_medicaciones_ibfk_2` FOREIGN KEY (`id_medicacion`) REFERENCES `medicaciones` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `control_sintomas` (
  `id_control` int(11) NOT NULL,
  `id_sintoma` int(11) NOT NULL,
  `valor_registrado` varchar(255) DEFAULT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_edicion` datetime DEFAULT NULL,
  `fecha_borrado` datetime DEFAULT NULL,
  PRIMARY KEY (`id_control`,`id_sintoma`),
  KEY `id_sintoma` (`id_sintoma`),
  CONSTRAINT `control_sintomas_ibfk_1` FOREIGN KEY (`id_control`) REFERENCES `controles` (`id`),
  CONSTRAINT `control_sintomas_ibfk_2` FOREIGN KEY (`id_sintoma`) REFERENCES `sintomas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Carga de Datos Base
-- --------------------------------------------------------

-- 1. Rol Administrador Único
INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'Administrador');

-- 2. Establecimientos de Salud Oficiales (Victoria, Entre Ríos)
INSERT INTO `establecimientos_salud` (`id`, `nombre`, `cuartel`, `tipo`) VALUES
(1, 'HOSPITAL FERMIN SALABERRY', 'Segundo Cuartel', 'Hospital'),
(2, 'BICENTENARIO', 'Quinto Cuartel', 'CAPS'),
(3, 'SAN ROQUE', 'Primer Cuartel.', 'CAPS'),
(4, 'LUJAN', 'Primer Cuartel.', 'CAPS'),
(5, 'ISIDRO REGGIARDO', 'Tercer Cuartel', 'CAPS'),
(6, 'CIC (CENTRO INTEGRADOR COMUNITARIO)', 'Cuarto Cuartel', 'CAPS'),
(7, 'BENITO IBARROLABURU', 'Zona Abadía y Barrio Arenal', 'CAPS');

-- 3. Usuario Administrador Inicial, debe cambiarse luego de entrar por primera vez,
-- Usuario: admin
-- Contraseña: admin123
INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `username`, `password`, `id_rol`, `id_establecimiento_asignado`) VALUES
(1, 'Administrador General', '', 'admin', '$2y$10$4pnE43JANqCIfxwopFFw/.cSIKjDSMesgzyA6GxGH3VJ//iqObMyK', 1, 1);

-- 4. Permisos del Rol Administrador (Rol ID 1)
INSERT INTO `permisos` (`id`, `id_rol`, `modulo`, `puede_ver`, `puede_crear`, `puede_editar`, `puede_eliminar`) VALUES
(1, 1, 'visitas', 1, 1, 1, 1),
(2, 1, 'pacientes', 1, 1, 1, 1),
(3, 1, 'tutores', 1, 1, 1, 1),
(4, 1, 'usuarios', 1, 1, 1, 1),
(5, 1, 'establecimientos', 1, 1, 1, 1),
(6, 1, 'permisos', 1, 1, 1, 1),
(7, 1, 'factores', 1, 1, 1, 1),
(8, 1, 'sintomas', 1, 1, 1, 1),
(9, 1, 'copia-seguridad', 1, 1, 1, 1),
(10, 1, 'medicaciones', 1, 1, 1, 1);

-- 5. Factores de Riesgo y Protección
INSERT INTO `factores` (`id`, `denominacion`, `tipo`, `tipo_formulario`) VALUES
(1, 'RNPT < 37 semanas', 'Riesgo', 'TAL'),
(2, 'BPN < 2500 gr', 'Riesgo', 'TAL'),
(3, 'Patología de base', 'Riesgo', 'Ambos'),
(4, 'Hacinamiento', 'Riesgo', 'Ambos'),
(5, 'Humo ambiental de tabaco', 'Riesgo', 'Ambos'),
(6, 'Analfabetismo', 'Riesgo', 'Ambos'),
(7, 'Antecedente de crisis grave', 'Riesgo', 'WDF'),
(8, 'Gravedad al ingreso', 'Riesgo', 'WDF'),
(9, 'Calendario de vacunación completo', 'Proteccion', 'Ambos'),
(10, 'Lactancia materna', 'Proteccion', 'Ambos'),
(11, 'Embarazo con vacunación VRS', 'Proteccion', 'Ambos');

INSERT INTO `valores_factores` (`id`, `id_factor`, `valor`) VALUES
(1, 1, 'Sí'), (2, 1, 'No'),
(3, 2, 'Sí'), (4, 2, 'No'),
(5, 3, 'Sí'), (6, 3, 'No'),
(7, 4, 'Sí'), (8, 4, 'No'),
(9, 5, 'Sí'), (10, 5, 'No'),
(11, 6, 'Sí'), (12, 6, 'No'),
(13, 7, 'Sí'), (14, 7, 'No'),
(15, 8, 'Leve'), (16, 8, 'Moderado'), (17, 8, 'Grave'),
(18, 9, 'Sí'), (19, 9, 'No'),
(20, 10, 'Sí'), (21, 10, 'No'),
(22, 11, 'Sí'), (23, 11, 'No');

-- 6. Síntomas Oficiales
INSERT INTO `sintomas` (`id`, `nombre_sintoma`, `tipo_formulario`) VALUES
(1, 'Frecuencia cardiaca', 'TAL'),
(2, 'Frecuencia respiratoria (<=6 meses)', 'TAL'),
(3, 'Frecuencia respiratoria (>6 meses)', 'TAL'),
(4, 'Sibilancias', 'TAL'),
(5, 'Retraccion / uso de musculos accesorios', 'TAL'),
(6, 'Saturacion de oxigeno', 'TAL'),
(7, 'Temperatura', 'TAL'),
(8, 'Frecuencia cardiaca', 'WDF'),
(9, 'Frecuencia respiratoria', 'WDF'),
(10, 'Sibilancias', 'WDF'),
(11, 'Tiraje', 'WDF'),
(12, 'Ventilacion', 'WDF'),
(13, 'Cianosis', 'WDF'),
(14, 'Saturacion de oxigeno', 'WDF'),
(15, 'Temperatura', 'WDF');

-- 7. Valores y Puntajes de los Síntomas (Textos 100% calibrados al HTML)
INSERT INTO `valores_sintomas` (`id`, `id_sintoma`, `valor_min`, `valor_max`, `valor_texto`, `puntos`) VALUES
-- TAL: FC (ID 1)
(1, 1, 0.00, 120.00, NULL, 0),
(2, 1, 121.00, 140.00, NULL, 1),
(3, 1, 141.00, 160.00, NULL, 2),
(4, 1, 161.00, 999.00, NULL, 3),

-- TAL: FR <= 6m (ID 2)
(5, 2, 0.00, 40.00, NULL, 0),
(6, 2, 41.00, 55.00, NULL, 1),
(7, 2, 56.00, 70.00, NULL, 2),
(8, 2, 71.00, 999.00, NULL, 3),

-- TAL: FR > 6m (ID 3)
(9, 3, 0.00, 30.00, NULL, 0),
(10, 3, 31.00, 45.00, NULL, 1),
(11, 3, 46.00, 60.00, NULL, 2),
(12, 3, 61.00, 999.00, NULL, 3),

-- TAL: Sibilancias (ID 4)
(13, 4, NULL, NULL, 'No', 0),
(14, 4, NULL, NULL, 'Fin espiración con estetoscopio', 1),
(15, 4, NULL, NULL, 'Inspiración y espiración con estetoscopio', 2),
(16, 4, NULL, NULL, 'Audible sin estetoscopio', 3),

-- TAL: Accesorios (ID 5)
(17, 5, NULL, NULL, 'No', 0),
(18, 5, NULL, NULL, 'Subcostal', 1),
(19, 5, NULL, NULL, 'Subcostal e intercostal', 2),
(20, 5, NULL, NULL, 'Generalizado', 3),

-- WDF: FR (ID 9)
(21, 9, 0.00, 30.00, NULL, 0),
(22, 9, 31.00, 45.00, NULL, 1),
(23, 9, 46.00, 60.00, NULL, 2),
(24, 9, 61.00, 999.00, NULL, 3),

-- WDF: FC (ID 8)
(25, 8, 0.00, 120.00, NULL, 0),
(26, 8, 121.00, 999.00, NULL, 1),

-- WDF: Sibilancias (ID 10)
(28, 10, NULL, NULL, 'No', 0),
(29, 10, NULL, NULL, 'Final espiración', 1),
(30, 10, NULL, NULL, 'Todo espiración', 2),
(31, 10, NULL, NULL, '+ Inspiración', 3),

-- WDF: Tiraje (ID 11)
(32, 11, NULL, NULL, 'No', 0),
(33, 11, NULL, NULL, 'Subcostal. Intercostal.', 1),
(34, 11, NULL, NULL, '+ Supraclavicular + Aleteo nasal', 2),
(35, 11, NULL, NULL, '+ Todo lo anterior + Supraesternal', 3),

-- WDF: Ventilación (ID 12)
(36, 12, NULL, NULL, 'Buena, Simétrica', 0),
(37, 12, NULL, NULL, 'Regular. Simétrica', 1),
(38, 12, NULL, NULL, 'Muy disminuida', 2),
(39, 12, NULL, NULL, 'Tórax silente', 3),

-- WDF: Cianosis (ID 13)
(40, 13, NULL, NULL, 'No', 0),
(41, 13, NULL, NULL, 'Si', 1);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;