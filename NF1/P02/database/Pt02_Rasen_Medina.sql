
-- ============================================================
-- PRÀCTICA 02 - CONNEXIONS PDO
-- Projecte RAS Football
-- Alumne: Rasen Medina
--
-- Creació de la base de dades i les quatre taules.
-- ============================================================

-- Creem la base de dades si encara no existeix.
CREATE DATABASE IF NOT EXISTS `Pt02_Rasen_Medina`
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Seleccionem la base de dades amb què treballarem.
USE `Pt02_Rasen_Medina`;

-- ------------------------------------------------------------
-- TAULA 1: EQUIPS
-- Guardem els equips de futbol.
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS equips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    ciutat VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- TAULA 2: JUGADORS
-- Cada jugador pot pertànyer a un equip.
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS jugadors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    cognoms VARCHAR(150) NOT NULL,
    dni VARCHAR(20) NOT NULL UNIQUE,
    dorsal INT DEFAULT NULL,
    posicio VARCHAR(50) NOT NULL,
    equip_id INT DEFAULT NULL,

    -- La clau forana relaciona cada jugador amb un equip.
    -- ON DELETE SET NULL conserva el jugador si s'esborra
    -- l'equip al qual pertanyia.
    CONSTRAINT fk_jugadors_equips
        FOREIGN KEY (equip_id)
        REFERENCES equips(id)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- TAULA 3: ENTRENADORS
-- Cada entrenador pot estar vinculat a un equip.
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS entrenadors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    cognoms VARCHAR(150) NOT NULL,
    dni VARCHAR(20) NOT NULL UNIQUE,
    equip_id INT DEFAULT NULL,

    CONSTRAINT fk_entrenadors_equips
        FOREIGN KEY (equip_id)
        REFERENCES equips(id)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- TAULA 4: USERS
-- Estructura basada en els camps indicats pel professor.
-- Encara no implementarem el registre ni l'inici de sessió.
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nickname VARCHAR(100) NOT NULL,
    fullname TEXT NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(60) NOT NULL,
    image_profile MEDIUMBLOB NULL,
    reset_token TEXT DEFAULT NULL,
    remember_me_token TEXT DEFAULT NULL,
    social_provider ENUM(
        '', 'GitHub', 'Google', 'Amazon',
        'Telegram', 'Twitter', 'Reddit', 'Linkedin'
    ) NOT NULL DEFAULT '',
    admin TINYINT(1) NOT NULL DEFAULT 0,
    reset_token_expiry DATETIME DEFAULT NULL,

    UNIQUE KEY uq_users_nickname (nickname),
    UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
