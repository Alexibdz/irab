-- Datos de prueba para ver el modulo Auditoria. Todos los IDs >= 9001.
-- Cargar con: mysql -u root --default-character-set=utf8mb4 enfermeria_irab < auditoria_demo.sql
-- Para quitarlos: auditoria_demo_borrar.sql
START TRANSACTION;

INSERT INTO usuarios (id, nombre, apellido, username, password, id_rol, id_establecimiento_asignado) VALUES
(9001, 'Laura', 'Gómez', 'demo.lgomez', '!sin-acceso', 1, 1),
(9002, 'Martín', 'Ríos', 'demo.mrios', '!sin-acceso', 1, 2);

INSERT INTO tutores (id, dni, nombre, apellido, telefono) VALUES
(9001, '99000101', 'Carolina', 'Fernández', '3815551001'),
(9002, '99000102', 'Diego', 'Medina', '3815551002'),
(9003, '99000103', 'Sofía', 'Herrera', '3815551003');

INSERT INTO pacientes (id, dni, nombre, apellido, fecha_nacimiento, domicilio, barrio, id_tutor, id_establecimiento_habitual) VALUES
(9001, '99000001', 'Tomás', 'Fernández', '2025-03-10', 'San Martín 123', 'Centro', 9001, 1),
(9002, '99000002', 'Valentina', 'Medina', '2023-07-22', 'Belgrano 456', 'Norte', 9002, 2),
(9003, '99000003', 'Benjamín', 'Herrera', '2026-01-05', 'Mitre 789', 'Sur', 9003, 3),
(9004, '99000004', 'Emma', 'Fernández', '2022-11-30', 'San Martín 123', 'Centro', 9001, 1);

INSERT INTO visitas (id, id_paciente, id_usuario, id_establecimiento, fecha_ingreso, diagnostico, estado_derivacion, fecha_alta, fecha_alta_definitiva, fecha_borrado) VALUES
(9001, 9001, 9001, 1, '2026-11-10 08:30:00', 'Bronquiolitis', 'Domicilio', '2026-11-12', '2026-11-14 10:00:00', NULL),
(9002, 9002, 9002, 2, '2026-11-12 14:15:00', 'Neumonía', 'Internacion', NULL, NULL, NULL),
(9003, 9003, 1,    3, '2026-11-14 09:00:00', 'Bronquiolitis', 'Derivacion', '2026-11-15', NULL, NULL),
(9004, 9004, 9001, 1, '2026-11-15 16:40:00', 'Error de carga', NULL, NULL, NULL, '2026-11-15 17:00:00');

INSERT INTO controles (id, id_visita, fecha_hora, score_total, estado_gravedad, observaciones) VALUES
(9001, 9001, '2026-11-10 12:30:00', 7, 'Moderada', 'Mejora parcial'),
(9002, 9001, '2026-11-11 09:00:00', 3, 'Leve', 'Buena evolución'),
(9003, 9002, '2026-11-12 18:00:00', 10, 'Grave', 'Requiere oxígeno'),
(9004, 9002, '2026-11-13 10:00:00', 8, 'Moderada', NULL),
(9005, 9003, '2026-11-14 13:00:00', 5, 'Moderada', NULL);

INSERT INTO auditoria (id, tabla_auditada, id_registro, id_paciente, id_usuario, accion, detalle, fecha) VALUES
(9001, 'visitas',   9001, 9001, 9001, 'ALTA',            'Ingreso de visita', '2026-11-10 08:30:00'),
(9002, 'controles', 9001, 9001, 9001, 'ALTA',            'Score: 7', '2026-11-10 12:30:00'),
(9003, 'visitas',   9001, 9001, 9001, 'MODIFICACION',    'Modificación de datos de ingreso de la visita.', '2026-11-10 12:45:00'),
(9004, 'controles', 9002, 9001, 9002, 'ALTA',            'Score: 3', '2026-11-11 09:00:00'),
(9005, 'visitas',   9001, 9001, 9002, 'CIERRE',          'Cierre temporal de visita.', '2026-11-12 11:00:00'),
(9006, 'visitas',   9002, 9002, 9002, 'ALTA',            'Ingreso de visita', '2026-11-12 14:15:00'),
(9007, 'controles', 9003, 9002, 9002, 'ALTA',            'Score: 10', '2026-11-12 18:00:00'),
(9008, 'visitas',   9001, 9001, 1,    'REAPERTURA',      'Reapertura para continuar controles.', '2026-11-13 08:00:00'),
(9009, 'controles', 9004, 9002, 9001, 'ALTA',            'Score: 8', '2026-11-13 10:00:00'),
(9010, 'visitas',   9001, 9001, 9001, 'ALTA_DEFINITIVA', 'Alta médica otorgada.', '2026-11-14 10:00:00'),
(9011, 'visitas',   9003, 9003, 1,    'ALTA',            'Ingreso de visita', '2026-11-14 09:00:00'),
(9012, 'controles', 9005, 9003, 1,    'ALTA',            'Score: 5', '2026-11-14 13:00:00'),
(9013, 'visitas',   9003, 9003, 9002, 'MODIFICACION',    'Modificación de datos de ingreso de la visita.', '2026-11-14 15:20:00'),
(9014, 'visitas',   9003, 9003, 9002, 'CIERRE',          'Cierre temporal de visita.', '2026-11-15 09:30:00'),
(9015, 'visitas',   9004, 9004, 9001, 'ALTA',            'Ingreso de visita', '2026-11-15 16:40:00'),
(9016, 'visitas',   9004, 9004, 9001, 'BAJA',            'Softdelete de la visita', '2026-11-15 17:00:00'),
(9017, 'visitas',   9004, 9004, 1,    'RECUPERACION',    'Restauración de visita eliminada.', '2026-11-16 08:10:00'),
(9018, 'visitas',   9004, 9004, 1,    'BAJA',            'Softdelete de la visita', '2026-11-16 08:15:00');

COMMIT;
