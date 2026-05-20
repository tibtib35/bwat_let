-- ============================================================
-- Correctif : réorganisation des rôles + mise à jour utilisateurs
-- Importable sans erreur même si déjà partiellement appliqué
-- ============================================================

USE bwat_let;

-- 1. Notes sur 5 (sans effet si déjà appliqué)
UPDATE avis SET note = ROUND(note / 2.0) WHERE note > 5;

-- 2. Supprimer le rôle Visiteur si encore présent
DELETE FROM role WHERE nomRole = 'Visiteur';

-- 3. Ajouter le rôle Membre en id=1 (INSERT IGNORE : sans erreur si déjà fait)
INSERT IGNORE INTO role (id_role, nomRole) VALUES (1, 'Membre');

-- 4. Passer tous les utilisateurs au rôle Membre (id=1), sauf clara_l et bob_m
--    DOIT être fait AVANT de supprimer id=4 (alice_d avait id_role=4)
UPDATE utilisateurs
SET id_role = 1
WHERE login NOT IN ('clara_l', 'bob_m');

-- 5. Renommer les rôles restants
UPDATE role SET nomRole = 'Rédacteur'      WHERE id_role = 2;
UPDATE role SET nomRole = 'Administrateur' WHERE id_role = 3;

-- 6. Supprimer id=4 (aucun utilisateur ne l'a plus après l'étape 4)
DELETE FROM role WHERE id_role = 4;
