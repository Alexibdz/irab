-- Quita los datos de prueba de auditoria_demo.sql
START TRANSACTION;
DELETE FROM auditoria WHERE id >= 9001;
DELETE FROM controles WHERE id >= 9001;
DELETE FROM visitas   WHERE id >= 9001;
DELETE FROM pacientes WHERE id >= 9001;
DELETE FROM tutores   WHERE id >= 9001;
DELETE FROM usuarios  WHERE id >= 9001;
COMMIT;

-- Vuelve la numeracion al siguiente ID libre (MariaDB usa max(id)+1 si el valor es menor)
ALTER TABLE auditoria AUTO_INCREMENT = 1;
ALTER TABLE controles AUTO_INCREMENT = 1;
ALTER TABLE visitas   AUTO_INCREMENT = 1;
ALTER TABLE pacientes AUTO_INCREMENT = 1;
ALTER TABLE tutores   AUTO_INCREMENT = 1;
ALTER TABLE usuarios  AUTO_INCREMENT = 1;
