-- ============================================================
-- Correctif : notes sur 5 + suppression rôle Visiteur
-- Importable sans erreur même si déjà partiellement appliqué
-- ============================================================

USE bwat_let;

-- 1. Mise à l'échelle des notes (0-10 → 0-5)
--    Le WHERE note > 5 évite de diviser une seconde fois si déjà appliqué
UPDATE avis SET note = ROUND(note / 2.0) WHERE note > 5;

-- 2. Suppression du rôle Visiteur (sans erreur s'il n'existe plus)
DELETE FROM role WHERE nomRole = 'Visiteur';
