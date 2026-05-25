-- =============================================
-- Inicialización de la base de datos MySQL
-- Se ejecuta automáticamente al levantar PC4
-- =============================================

-- Crear la BD si no existe (ya lo hace el MYSQL_DATABASE en el compose)
CREATE DATABASE IF NOT EXISTS `scrum_proyecto_db`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `scrum_proyecto_db`;

-- Asegurar que root puede conectarse desde cualquier host de la LAN
-- (Las IPs de PC2 y PC3 necesitan este permiso)
CREATE USER IF NOT EXISTS 'root'@'192.168.1.102' IDENTIFIED BY 'admin';
GRANT ALL PRIVILEGES ON scrum_proyecto_db.* TO 'root'@'192.168.1.102';

CREATE USER IF NOT EXISTS 'root'@'192.168.1.103' IDENTIFIED BY 'admin';
GRANT ALL PRIVILEGES ON scrum_proyecto_db.* TO 'root'@'192.168.1.103';

-- Permisos desde cualquier IP interna (más flexible para laboratorio)
CREATE USER IF NOT EXISTS 'root'@'%' IDENTIFIED BY 'admin';
GRANT ALL PRIVILEGES ON scrum_proyecto_db.* TO 'root'@'%';

FLUSH PRIVILEGES;
