-- ============================================================
-- Correctif : notes sur 5 + suppression rôle Visiteur
-- À importer dans PHPMyAdmin sur la base bwat_let
-- ============================================================

USE bwat_let;

-- 1. Mise à l'échelle des notes (0-10 → 0-5)
UPDATE avis SET note = ROUND(note / 2.0);

-- 2. Suppression du rôle Visiteur (redondant avec Membre)
DELETE FROM role WHERE nomRole = 'Visiteur';
