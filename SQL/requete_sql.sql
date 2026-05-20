-- ============================================================
-- Bwat Let — Base de données complète
-- Mot de passe de tous les comptes de test : password123
-- ============================================================

CREATE DATABASE IF NOT EXISTS bwat_let CHARACTER SET utf8 COLLATE utf8_general_ci;
USE bwat_let;

-- ============================================================
-- SUPPRESSION des tables (ordre inverse des dépendances)
-- ============================================================

DROP TABLE IF EXISTS `favoris`;
DROP TABLE IF EXISTS `avis`;
DROP TABLE IF EXISTS `article`;
DROP TABLE IF EXISTS `joueDans`;
DROP TABLE IF EXISTS `acteurs`;
DROP TABLE IF EXISTS `realise`;
DROP TABLE IF EXISTS `realisateurs`;
DROP TABLE IF EXISTS `film`;
DROP TABLE IF EXISTS `image`;
DROP TABLE IF EXISTS `plateforme`;
DROP TABLE IF EXISTS `genre`;
DROP TABLE IF EXISTS `utilisateurs`;
DROP TABLE IF EXISTS `role`;

-- ============================================================
-- CRÉATION des tables
-- ============================================================

CREATE TABLE `role` (
    `id_role` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nomRole` VARCHAR(50) NOT NULL
);

CREATE TABLE `utilisateurs` (
    `id_utilisateur` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(255) NOT NULL,
    `prenom` VARCHAR(255) NOT NULL,
    `login` VARCHAR(255) NOT NULL UNIQUE,
    `mdp` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `adresse` VARCHAR(255) NOT NULL,
    `dateNaissance` DATE NOT NULL,
    `dateCreation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `derniereConnexion` DATETIME NOT NULL,
    `id_role` TINYINT UNSIGNED NOT NULL,
    FOREIGN KEY (`id_role`) REFERENCES `role`(`id_role`)
);

CREATE TABLE `genre` (
    `id_genre` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nomGenre` VARCHAR(255) NOT NULL
);

CREATE TABLE `plateforme` (
    `id_plateforme` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nomPlateforme` VARCHAR(255) NOT NULL
);

CREATE TABLE `image` (
    `id_image` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `chemin` VARCHAR(255) NOT NULL
);

CREATE TABLE `film` (
    `id_film` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `titre` VARCHAR(255) NOT NULL,
    `synopsis` TEXT NOT NULL,
    `dateSortie` DATE NOT NULL,
    `duree` INT UNSIGNED NOT NULL,
    `paysOrigine` VARCHAR(255) NOT NULL,
    `langue` VARCHAR(255) NOT NULL,
    `affiche` VARCHAR(255) NOT NULL,
    `id_genre` BIGINT UNSIGNED NOT NULL,
    `id_plateforme` BIGINT UNSIGNED NOT NULL,
    `id_image` BIGINT UNSIGNED NULL,
    FOREIGN KEY (`id_genre`) REFERENCES `genre`(`id_genre`),
    FOREIGN KEY (`id_plateforme`) REFERENCES `plateforme`(`id_plateforme`),
    FOREIGN KEY (`id_image`) REFERENCES `image`(`id_image`)
);

CREATE TABLE `realisateurs` (
    `id_real` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(255) NOT NULL,
    `prenom` VARCHAR(255) NOT NULL
);

CREATE TABLE `realise` (
    `id_film` BIGINT UNSIGNED NOT NULL,
    `id_real` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (`id_film`, `id_real`),
    FOREIGN KEY (`id_film`) REFERENCES `film`(`id_film`),
    FOREIGN KEY (`id_real`) REFERENCES `realisateurs`(`id_real`)
);

CREATE TABLE `acteurs` (
    `id_acteur` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(255) NOT NULL,
    `prenom` VARCHAR(255) NOT NULL
);

CREATE TABLE `joueDans` (
    `id_acteur` BIGINT UNSIGNED NOT NULL,
    `id_film` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (`id_acteur`, `id_film`),
    FOREIGN KEY (`id_acteur`) REFERENCES `acteurs`(`id_acteur`),
    FOREIGN KEY (`id_film`) REFERENCES `film`(`id_film`)
);

CREATE TABLE `article` (
    `id_article` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `titre` VARCHAR(255) NOT NULL,
    `contenu` TEXT NOT NULL,
    `dateCreation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `dateModification` DATETIME NOT NULL,
    `id_utilisateur` BIGINT UNSIGNED NOT NULL,
    `id_film` BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs`(`id_utilisateur`),
    FOREIGN KEY (`id_film`) REFERENCES `film`(`id_film`)
);

CREATE TABLE `avis` (
    `id_avis` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `titre` VARCHAR(255) NOT NULL,
    `texte` TEXT NOT NULL,
    `note` TINYINT UNSIGNED NOT NULL CHECK (`note` BETWEEN 0 AND 5),
    `dateCreation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `visible` BOOLEAN NOT NULL DEFAULT TRUE,
    `id_article` BIGINT UNSIGNED NOT NULL,
    `id_utilisateur` BIGINT UNSIGNED NOT NULL,
    UNIQUE KEY `uq_avis_user_article` (`id_utilisateur`, `id_article`),
    FOREIGN KEY (`id_article`) REFERENCES `article`(`id_article`),
    FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs`(`id_utilisateur`)
);

CREATE TABLE `favoris` (
    `id_utilisateur` BIGINT UNSIGNED NOT NULL,
    `id_film` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (`id_utilisateur`, `id_film`),
    FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs`(`id_utilisateur`),
    FOREIGN KEY (`id_film`) REFERENCES `film`(`id_film`)
);

-- ============================================================
-- INSERTION des données
-- ============================================================

-- Rôles (1=Membre, 2=Rédacteur, 3=Administrateur)
INSERT INTO `role` (nomRole) VALUES
('Membre'),
('Rédacteur'),
('Administrateur');

-- Genres
INSERT INTO `genre` (nomGenre) VALUES
('Action'),
('Comédie'),
('Drame'),
('Horreur'),
('Science-Fiction'),
('Thriller'),
('Animation'),
('Romance');

-- Plateformes
INSERT INTO `plateforme` (nomPlateforme) VALUES
('Cinéma'),
('Netflix'),
('Amazon Prime'),
('Disney+'),
('Canal+'),
('OCS');

-- Images
INSERT INTO `image` (chemin) VALUES
('img/inception.jpg'),
('img/intouchables.jpg'),
('img/parasite.jpg'),
('img/dark_knight.jpg'),
('img/interstellar.jpg'),
('img/amelie.jpg'),
('img/silence_agneaux.jpg'),
('img/pulp_fiction.jpg');

-- Films
-- id_genre : 1=Action, 2=Comédie, 3=Drame, 4=Horreur, 5=Sci-Fi, 6=Thriller
-- id_plateforme : 1=Cinéma, 2=Netflix, 3=Amazon Prime, 4=Disney+, 5=Canal+
INSERT INTO `film` (titre, synopsis, dateSortie, duree, paysOrigine, langue, affiche, id_genre, id_plateforme, id_image) VALUES
('Inception',                          'Un voleur capable de s\'infiltrer dans les rêves se voit offrir une chance de retrouver sa vie passée en échange d\'une mission impossible.',                               '2010-07-21', 148, 'États-Unis',   'Anglais',  'img/affiche_inception.jpg',        5, 1, 1),
('Les Intouchables',                   'L\'amitié improbable entre Philippe, milliardaire tétraplégique, et Driss, son aide-soignant issu des banlieues.',                                                        '2011-11-02', 112, 'France',        'Français', 'img/affiche_intouchables.jpg',     3, 2, 2),
('Parasite',                           'La famille Kim, pauvre, s\'infiltre progressivement dans la vie de la riche famille Park grâce à un stratagème ingénieux.',                                               '2019-05-30', 132, 'Corée du Sud', 'Coréen',   'img/affiche_parasite.jpg',         6, 3, 3),
('The Dark Knight',                    'Batman affronte le Joker, un criminel anarchiste qui sème le chaos à Gotham City en défiant toute logique.',                                                              '2008-07-18', 152, 'États-Unis',   'Anglais',  'img/affiche_dark_knight.jpg',      1, 1, 4),
('Interstellar',                       'Un groupe d\'astronautes voyage à travers un trou de ver pour trouver une nouvelle planète habitable avant que la Terre ne soit condamnée.',                              '2014-11-05', 169, 'États-Unis',   'Anglais',  'img/affiche_interstellar.jpg',     5, 2, 5),
('Le Fabuleux Destin d\'Amélie Poulain','Une jeune femme timide décide de changer la vie des gens qui l\'entourent tout en ignorant son propre bonheur.',                                                        '2001-04-25', 122, 'France',        'Français', 'img/affiche_amelie.jpg',           2, 5, 6),
('Le Silence des Agneaux',             'Une jeune agente du FBI doit obtenir l\'aide d\'un tueur en série psychiatrique pour capturer un autre meurtrier surnommé Buffalo Bill.',                                '1991-02-14', 118, 'États-Unis',   'Anglais',  'img/affiche_silence_agneaux.jpg',  4, 3, 7),
('Pulp Fiction',                       'Plusieurs histoires criminelles s\'entremêlent dans Los Angeles, racontées de façon non linéaire dans un ballet de violence et d\'humour noir.',                         '1994-10-26', 154, 'États-Unis',   'Anglais',  'img/affiche_pulp_fiction.jpg',     1, 2, 8);

-- Réalisateurs
INSERT INTO `realisateurs` (nom, prenom) VALUES
('Nolan',    'Christopher'),
('Nakache',  'Olivier'),
('Toledano', 'Éric'),
('Bong',     'Joon-ho'),
('Jeunet',   'Jean-Pierre'),
('Demme',    'Jonathan'),
('Tarantino','Quentin');

-- Réalise (film → réalisateur)
-- Inception(1)→Nolan(1) | Intouchables(2)→Nakache(2)+Toledano(3) | Parasite(3)→Bong(4)
-- Dark Knight(4)→Nolan(1) | Interstellar(5)→Nolan(1) | Amélie(6)→Jeunet(5)
-- Silence(7)→Demme(6) | Pulp Fiction(8)→Tarantino(7)
INSERT INTO `realise` (id_film, id_real) VALUES
(1, 1), (2, 2), (2, 3), (3, 4), (4, 1), (5, 1), (6, 5), (7, 6), (8, 7);

-- Acteurs
INSERT INTO `acteurs` (nom, prenom) VALUES
('DiCaprio',       'Leonardo'),
('Gordon-Levitt',  'Joseph'),
('Cotillard',      'Marion'),
('Cluzet',         'François'),
('Sy',             'Omar'),
('Choi',           'Woo-shik'),
('Bale',           'Christian'),
('Ledger',         'Heath'),
('McConaughey',    'Matthew'),
('Hathaway',       'Anne'),
('Tautou',         'Audrey'),
('Kassovitz',      'Mathieu'),
('Foster',         'Jodie'),
('Hopkins',        'Anthony'),
('Travolta',       'John'),
('Jackson',        'Samuel L.');

-- JoueDans (acteur → film)
INSERT INTO `joueDans` (id_acteur, id_film) VALUES
(1, 1), (2, 1), (3, 1),
(4, 2), (5, 2),
(6, 3),
(7, 4), (8, 4),
(9, 5), (10, 5),
(11, 6), (12, 6),
(13, 7), (14, 7),
(15, 8), (16, 8);

-- Utilisateurs (mdp = hash bcrypt de 'password123')
-- 1=Membre | 2=Rédacteur | 3=Administrateur
INSERT INTO `utilisateurs` (nom, prenom, login, mdp, email, adresse, dateNaissance, dateCreation, derniereConnexion, id_role) VALUES
('Dupont',  'Alice',  'alice_d',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'alice.dupont@email.com',  '12 rue des Lilas, Paris',           '1995-03-15', '2025-01-10 09:00:00', '2025-05-01 14:22:00', 3),
('Martin',  'Bob',    'bob_m',    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'bob.martin@email.com',    '5 avenue Victor Hugo, Lyon',        '1990-07-22', '2025-01-15 11:30:00', '2025-05-02 10:15:00', 2),
('Leroy',   'Clara',  'clara_l',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'clara.leroy@email.com',   '8 boulevard Gambetta, Bordeaux',    '1998-11-05', '2025-02-01 08:45:00', '2025-05-03 16:40:00', 2),
('Bernard', 'David',  'david_b',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'david.bernard@email.com', '22 rue de la Paix, Marseille',      '1985-04-18', '2025-02-10 14:00:00', '2025-04-30 09:00:00', 1),
('Petit',   'Emma',   'emma_p',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'emma.petit@email.com',    '3 place du Capitole, Toulouse',     '2000-09-12', '2025-03-05 17:20:00', '2025-05-04 11:30:00', 1),
('Moreau',  'Félix',  'felix_m',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'felix.moreau@email.com',  '15 rue Saint-Denis, Nantes',        '1993-06-30', '2025-03-20 10:10:00', '2025-05-01 08:55:00', 1);

-- Articles (rédigés par bob_m=2 et clara_l=3, un seul par film)
INSERT INTO `article` (titre, contenu, dateCreation, dateModification, id_utilisateur, id_film) VALUES
('Inception : voyage au cœur des rêves',            'Inception est un chef-d\'œuvre de la science-fiction qui repousse les limites de l\'imaginaire. Christopher Nolan nous plonge dans un univers vertigineux où les rêves s\'emboîtent comme des poupées russes. La photographie est somptueuse, la bande-son de Hans Zimmer est envoûtante, et le casting cinq étoiles livre des performances mémorables.',                                          '2025-01-20 10:00:00', '2025-01-20 10:00:00', 2, 1),
('Les Intouchables : une amitié qui transcende tout','Rarement un film aura autant ému et fait rire en même temps. Nakache et Toledano signent un hymne à l\'amitié et à l\'humanité. Le duo Cluzet-Sy fonctionne à la perfection, chacun tirant le meilleur de l\'autre. Un film qui rappelle que le cinéma peut encore changer les regards sur le handicap et les inégalités sociales.',                                                         '2025-01-25 14:30:00', '2025-01-25 14:30:00', 3, 2),
('Parasite : la lutte des classes vue par Bong',     'Palme d\'Or à Cannes et Oscar du meilleur film, Parasite est une œuvre majuscule du cinéma contemporain. Bong Joon-ho signe un thriller social d\'une précision chirurgicale, qui bascule du registre de la comédie à celui du drame avec une fluidité stupéfiante. Un film qui se regarde et se pense.',                                                                                       '2025-02-05 09:15:00', '2025-02-05 09:15:00', 2, 3),
('The Dark Knight : le Joker au sommet de son art', 'Heath Ledger livre ici une performance légendaire et posthume dans la peau du Joker. Christopher Nolan signe le meilleur film de super-héros jamais réalisé, qui dépasse largement le cadre du genre pour s\'imposer comme un grand film de cinéma. Sombre, complexe et haletant de bout en bout.',                                                                                              '2025-02-15 16:00:00', '2025-02-15 16:00:00', 3, 4),
('Interstellar : aux confins de l\'univers',         'Interstellar est une expérience cinématographique unique qui mêle hard science et émotion brute. La bande-son d\'Hans Zimmer transcende les images déjà somptueuses de Nolan. La scène des messages vidéo reste l\'une des plus bouleversantes de l\'histoire du cinéma moderne.',                                                                                                             '2025-03-01 11:45:00', '2025-03-01 11:45:00', 2, 5),
('Amélie Poulain : la poésie du quotidien',          'Jeunet nous offre avec Amélie Poulain un conte moderne d\'une beauté visuelle époustouflante. Audrey Tautou est parfaite dans ce rôle iconique. Paris n\'a jamais été aussi coloré, aussi vivant, aussi magique. Un film qui redonne foi en la bonté humaine.',                                                                                                                               '2025-03-10 08:30:00', '2025-03-10 08:30:00', 3, 6),
('Le Silence des Agneaux : le frisson parfait',      'Un des rares films à avoir remporté les cinq Oscars majeurs. L\'alchimie entre Jodie Foster et Anthony Hopkins est absolument glaçante. Chaque scène entre Clarice et Hannibal Lecter est un duel psychologique d\'une intensité rare. Un thriller qui a défini le genre.',                                                                                                                     '2025-03-20 15:00:00', '2025-03-20 15:00:00', 2, 7),
('Pulp Fiction : l\'œuvre totale de Tarantino',      'Pulp Fiction a révolutionné le cinéma des années 90. Une narration éclatée, des dialogues ciselés au scalpel et un casting de légende pour un film culte absolu. Tarantino prouve ici qu\'il est possible de parler de violence et d\'humanité avec le même souffle. Un film inépuisable.',                                                                                                   '2025-04-01 10:30:00', '2025-04-01 10:30:00', 3, 8);

-- Avis (note entre 0 et 5, un seul avis par utilisateur par article)
-- Membres : david_b=4, emma_p=5, felix_m=6
INSERT INTO `avis` (titre, texte, note, dateCreation, visible, id_article, id_utilisateur) VALUES
-- Article 1 — Inception
('Un chef-d\'œuvre absolu',        'Je suis ressorti de la salle complètement abasourdi. Un film qui se mérite, à voir absolument plusieurs fois.',            5, '2025-01-21 12:00:00', TRUE, 1, 4),
('Trop complexe pour moi',         'Visuellement époustouflant mais je me suis perdu dans les niveaux de rêves. Difficile à suivre.',                          3, '2025-01-22 09:30:00', TRUE, 1, 5),
('Nolan au sommet de son art',     'Une maîtrise technique et narrative sans faille. DiCaprio est excellent. La fin reste ouverte à l\'interprétation.',       5, '2025-01-23 14:00:00', TRUE, 1, 6),
-- Article 2 — Intouchables
('Touchant et drôle à la fois',    'L\'un des films français les plus touchants que j\'ai vus. Omar Sy est extraordinaire, naturel et attachant.',             5, '2025-01-26 10:00:00', TRUE, 2, 4),
('Un feel-good movie parfait',     'Je l\'ai regardé en famille, on a tous pleuré et ri. Une histoire vraie qui rend le film encore plus fort.',               5, '2025-01-27 16:00:00', TRUE, 2, 5),
('Émotion garantie',               'Difficile de rester insensible. La relation entre les deux personnages est d\'une justesse rare.',                         4, '2025-01-28 11:00:00', TRUE, 2, 6),
-- Article 3 — Parasite
('Un choc cinématographique',      'Bong Joon-ho nous prend par surprise à chaque tournant. Une œuvre magistrale qui méritait tous ses prix.',                5, '2025-02-06 11:00:00', TRUE, 3, 4),
('Bien mais un peu surestimé',     'Très bon film mais je ne comprends pas tout l\'engouement. La fin m\'a laissé perplexe.',                                  4, '2025-02-07 14:30:00', TRUE, 3, 6),
-- Article 4 — The Dark Knight
('Heath Ledger, une légende',      'La performance de Heath Ledger restera dans l\'histoire. Un Joker iconique pour un film iconique. Frissons garantis.',     5, '2025-02-16 09:00:00', TRUE, 4, 5),
('Le meilleur film de super-héros','Bien loin des blockbusters classiques, The Dark Knight est un vrai film de cinéma. Intelligent et intense.',               5, '2025-02-17 11:00:00', TRUE, 4, 6),
('Magistral',                      'Nolan redéfinit le genre. On oublie qu\'on regarde un film de super-héros tellement c\'est prenant.',                     5, '2025-02-18 15:00:00', TRUE, 4, 4),
-- Article 5 — Interstellar
('Émotionnellement dévastateur',   'La scène des messages vidéo m\'a arraché des larmes. Un film d\'une beauté et d\'une profondeur rares.',                  5, '2025-03-02 10:00:00', TRUE, 5, 4),
('Un peu trop long',               'Des longueurs dans le dernier acte mais globalement un film impressionnant et ambitieux.',                                  4, '2025-03-03 15:00:00', TRUE, 5, 5),
-- Article 6 — Amélie Poulain
('La France comme on l\'aime',     'Un film plein de poésie et de couleurs. On ressort avec le sourire. Jeunet est un vrai magicien de l\'image.',            5, '2025-03-11 09:00:00', TRUE, 6, 4),
('Un classique intemporel',        'Audrey Tautou est inoubliable dans ce rôle. Paris n\'a jamais été aussi beau et vivant.',                                  4, '2025-03-12 14:00:00', TRUE, 6, 6),
-- Article 7 — Le Silence des Agneaux
('Glaçant de bout en bout',        'Hopkins et Foster forment un duo inoubliable. Un thriller psychologique d\'exception qui ne vieillit pas.',                5, '2025-03-21 10:00:00', TRUE, 7, 5),
('Pas pour les âmes sensibles',    'Brillant mais vraiment angoissant. À ne pas regarder seul la nuit. Une maîtrise absolue du suspense.',                    4, '2025-03-22 16:00:00', TRUE, 7, 6),
-- Article 8 — Pulp Fiction
('Révolutionnaire',                'Tarantino a changé le cinéma à jamais avec ce film. Chaque scène est culte, chaque dialogue est ciselé.',                 5, '2025-04-02 11:00:00', TRUE, 8, 4),
('Un film culte pleinement justifié','Les dialogues sont d\'une richesse incroyable. Une expérience unique que tout cinéphile se doit de vivre.',              5, '2025-04-03 14:00:00', TRUE, 8, 5);

-- Favoris
INSERT INTO `favoris` (id_utilisateur, id_film) VALUES
(4, 1), (4, 3), (4, 8),
(5, 2), (5, 4), (5, 6),
(6, 1), (6, 4), (6, 5), (6, 7);
