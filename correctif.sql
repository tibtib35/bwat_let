UPDATE utilisateurs
SET id_role = 2
WHERE id_role IN (3, 4);

UPDATE utilisateurs
SET id_role = 1
WHERE id_role = 2;

DELETE FROM role
WHERE id_role = 4;

UPDATE role
SET nomRole  = 'membre'
WHERE id_role = 1;

UPDATE role
SET nomRole = 'rédacteur'
WHERE id_role = 2;

UPDATE role
SET nomRole = 'administrateur'
WHERE id_role = 3;




