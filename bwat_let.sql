-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 20 mai 2026 à 07:39
-- Version du serveur : 5.7.24
-- Version de PHP : 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bwat_let`
--

-- --------------------------------------------------------

--
-- Structure de la table `acteurs`
--

CREATE TABLE `acteurs` (
  `id_acteur` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `acteurs`
--

INSERT INTO `acteurs` (`id_acteur`, `nom`, `prenom`) VALUES
(1, 'DiCaprio', 'Leonardo'),
(2, 'Gordon-Levitt', 'Joseph'),
(3, 'Cotillard', 'Marion'),
(4, 'Cluzet', 'François'),
(5, 'Sy', 'Omar'),
(6, 'Choi', 'Woo-shik'),
(7, 'Bale', 'Christian'),
(8, 'Ledger', 'Heath'),
(9, 'McConaughey', 'Matthew'),
(10, 'Hathaway', 'Anne'),
(11, 'Tautou', 'Audrey'),
(12, 'Kassovitz', 'Mathieu'),
(13, 'Foster', 'Jodie'),
(14, 'Hopkins', 'Anthony'),
(15, 'Travolta', 'John'),
(16, 'Jackson', 'Samuel L.');

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id_article` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateModification` datetime NOT NULL,
  `id_utilisateur` bigint(20) UNSIGNED NOT NULL,
  `id_film` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id_article`, `titre`, `contenu`, `dateCreation`, `dateModification`, `id_utilisateur`, `id_film`) VALUES
(1, 'Inception : voyage au cœur des rêves', 'Inception est un chef-d\'œuvre de la science-fiction qui repousse les limites de l\'imaginaire. Christopher Nolan nous plonge dans un univers vertigineux où les rêves s\'emboîtent comme des poupées russes. La photographie est somptueuse, la bande-son de Hans Zimmer est envoûtante, et le casting cinq étoiles livre des performances mémorables.', '2025-01-20 10:00:00', '2025-01-20 10:00:00', 2, 1),
(2, 'Les Intouchables : une amitié qui transcende tout', 'Rarement un film aura autant ému et fait rire en même temps. Nakache et Toledano signent un hymne à l\'amitié et à l\'humanité. Le duo Cluzet-Sy fonctionne à la perfection, chacun tirant le meilleur de l\'autre. Un film qui rappelle que le cinéma peut encore changer les regards sur le handicap et les inégalités sociales.', '2025-01-25 14:30:00', '2025-01-25 14:30:00', 3, 2),
(3, 'Parasite : la lutte des classes vue par Bong', 'Palme d\'Or à Cannes et Oscar du meilleur film, Parasite est une œuvre majuscule du cinéma contemporain. Bong Joon-ho signe un thriller social d\'une précision chirurgicale, qui bascule du registre de la comédie à celui du drame avec une fluidité stupéfiante. Un film qui se regarde et se pense.', '2025-02-05 09:15:00', '2025-02-05 09:15:00', 2, 3),
(4, 'The Dark Knight : le Joker au sommet de son art', 'Heath Ledger livre ici une performance légendaire et posthume dans la peau du Joker. Christopher Nolan signe le meilleur film de super-héros jamais réalisé, qui dépasse largement le cadre du genre pour s\'imposer comme un grand film de cinéma. Sombre, complexe et haletant de bout en bout.', '2025-02-15 16:00:00', '2025-02-15 16:00:00', 3, 4),
(5, 'Interstellar : aux confins de l\'univers', 'Interstellar est une expérience cinématographique unique qui mêle hard science et émotion brute. La bande-son d\'Hans Zimmer transcende les images déjà somptueuses de Nolan. La scène des messages vidéo reste l\'une des plus bouleversantes de l\'histoire du cinéma moderne.', '2025-03-01 11:45:00', '2025-03-01 11:45:00', 2, 5),
(6, 'Amélie Poulain : la poésie du quotidien', 'Jeunet nous offre avec Amélie Poulain un conte moderne d\'une beauté visuelle époustouflante. Audrey Tautou est parfaite dans ce rôle iconique. Paris n\'a jamais été aussi coloré, aussi vivant, aussi magique. Un film qui redonne foi en la bonté humaine.', '2025-03-10 08:30:00', '2025-03-10 08:30:00', 3, 6),
(7, 'Le Silence des Agneaux : le frisson parfait', 'Un des rares films à avoir remporté les cinq Oscars majeurs. L\'alchimie entre Jodie Foster et Anthony Hopkins est absolument glaçante. Chaque scène entre Clarice et Hannibal Lecter est un duel psychologique d\'une intensité rare. Un thriller qui a défini le genre.', '2025-03-20 15:00:00', '2025-03-20 15:00:00', 2, 7),
(8, 'Pulp Fiction : l\'œuvre totale de Tarantino', 'Pulp Fiction a révolutionné le cinéma des années 90. Une narration éclatée, des dialogues ciselés au scalpel et un casting de légende pour un film culte absolu. Tarantino prouve ici qu\'il est possible de parler de violence et d\'humanité avec le même souffle. Un film inépuisable.', '2025-04-01 10:30:00', '2025-04-01 10:30:00', 3, 8);

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id_avis` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `texte` text NOT NULL,
  `note` tinyint(3) UNSIGNED NOT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `id_article` bigint(20) UNSIGNED NOT NULL,
  `id_utilisateur` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id_avis`, `titre`, `texte`, `note`, `dateCreation`, `visible`, `id_article`, `id_utilisateur`) VALUES
(1, 'Un chef-d\'œuvre absolu', 'Je suis ressorti de la salle complètement abasourdi. Un film qui se mérite, à voir absolument plusieurs fois.', 3, '2025-01-21 12:00:00', 1, 1, 4),
(2, 'Trop complexe pour moi', 'Visuellement époustouflant mais je me suis perdu dans les niveaux de rêves. Difficile à suivre.', 2, '2025-01-22 09:30:00', 1, 1, 5),
(3, 'Nolan au sommet de son art', 'Une maîtrise technique et narrative sans faille. DiCaprio est excellent. La fin reste ouverte à l\'interprétation.', 3, '2025-01-23 14:00:00', 1, 1, 6),
(4, 'Touchant et drôle à la fois', 'L\'un des films français les plus touchants que j\'ai vus. Omar Sy est extraordinaire, naturel et attachant.', 3, '2025-01-26 10:00:00', 1, 2, 4),
(5, 'Un feel-good movie parfait', 'Je l\'ai regardé en famille, on a tous pleuré et ri. Une histoire vraie qui rend le film encore plus fort.', 3, '2025-01-27 16:00:00', 1, 2, 5),
(6, 'Émotion garantie', 'Difficile de rester insensible. La relation entre les deux personnages est d\'une justesse rare.', 2, '2025-01-28 11:00:00', 1, 2, 6),
(7, 'Un choc cinématographique', 'Bong Joon-ho nous prend par surprise à chaque tournant. Une œuvre magistrale qui méritait tous ses prix.', 3, '2025-02-06 11:00:00', 1, 3, 4),
(8, 'Bien mais un peu surestimé', 'Très bon film mais je ne comprends pas tout l\'engouement. La fin m\'a laissé perplexe.', 2, '2025-02-07 14:30:00', 1, 3, 6),
(9, 'Heath Ledger, une légende', 'La performance de Heath Ledger restera dans l\'histoire. Un Joker iconique pour un film iconique. Frissons garantis.', 3, '2025-02-16 09:00:00', 1, 4, 5),
(10, 'Le meilleur film de super-héros', 'Bien loin des blockbusters classiques, The Dark Knight est un vrai film de cinéma. Intelligent et intense.', 3, '2025-02-17 11:00:00', 1, 4, 6),
(11, 'Magistral', 'Nolan redéfinit le genre. On oublie qu\'on regarde un film de super-héros tellement c\'est prenant.', 3, '2025-02-18 15:00:00', 1, 4, 4),
(12, 'Émotionnellement dévastateur', 'La scène des messages vidéo m\'a arraché des larmes. Un film d\'une beauté et d\'une profondeur rares.', 3, '2025-03-02 10:00:00', 1, 5, 4),
(13, 'Un peu trop long', 'Des longueurs dans le dernier acte mais globalement un film impressionnant et ambitieux.', 2, '2025-03-03 15:00:00', 1, 5, 5),
(14, 'La France comme on l\'aime', 'Un film plein de poésie et de couleurs. On ressort avec le sourire. Jeunet est un vrai magicien de l\'image.', 3, '2025-03-11 09:00:00', 1, 6, 4),
(15, 'Un classique intemporel', 'Audrey Tautou est inoubliable dans ce rôle. Paris n\'a jamais été aussi beau et vivant.', 2, '2025-03-12 14:00:00', 1, 6, 6),
(16, 'Glaçant de bout en bout', 'Hopkins et Foster forment un duo inoubliable. Un thriller psychologique d\'exception qui ne vieillit pas.', 4, '2025-03-21 10:00:00', 1, 7, 5),
(17, 'Pas pour les âmes sensibles', 'Brillant mais vraiment angoissant. À ne pas regarder seul la nuit. Une maîtrise absolue du suspense.', 2, '2025-03-22 16:00:00', 1, 7, 6),
(18, 'Révolutionnaire', 'Tarantino a changé le cinéma à jamais avec ce film. Chaque scène est culte, chaque dialogue est ciselé.', 3, '2025-04-02 11:00:00', 1, 8, 4),
(19, 'Un film culte pleinement justifié', 'Les dialogues sont d\'une richesse incroyable. Une expérience unique que tout cinéphile se doit de vivre.', 3, '2025-04-03 14:00:00', 1, 8, 5);

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

CREATE TABLE `favoris` (
  `id_utilisateur` bigint(20) UNSIGNED NOT NULL,
  `id_film` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `favoris`
--

INSERT INTO `favoris` (`id_utilisateur`, `id_film`) VALUES
(4, 1),
(6, 1),
(5, 2),
(4, 3),
(5, 4),
(6, 4),
(6, 5),
(5, 6),
(6, 7),
(4, 8);

-- --------------------------------------------------------

--
-- Structure de la table `film`
--

CREATE TABLE `film` (
  `id_film` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `synopsis` text NOT NULL,
  `dateSortie` date NOT NULL,
  `duree` int(10) UNSIGNED NOT NULL,
  `paysOrigine` varchar(255) NOT NULL,
  `langue` varchar(255) NOT NULL,
  `affiche` varchar(255) NOT NULL,
  `id_genre` bigint(20) UNSIGNED NOT NULL,
  `id_plateforme` bigint(20) UNSIGNED NOT NULL,
  `id_image` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `film`
--

INSERT INTO `film` (`id_film`, `titre`, `synopsis`, `dateSortie`, `duree`, `paysOrigine`, `langue`, `affiche`, `id_genre`, `id_plateforme`, `id_image`) VALUES
(1, 'Inception', 'Un voleur capable de s\'infiltrer dans les rêves se voit offrir une chance de retrouver sa vie passée en échange d\'une mission impossible.', '2010-07-21', 148, 'États-Unis', 'Anglais', 'img/affiche_inception.jpg', 5, 1, 1),
(2, 'Les Intouchables', 'L\'amitié improbable entre Philippe, milliardaire tétraplégique, et Driss, son aide-soignant issu des banlieues.', '2011-11-02', 112, 'France', 'Français', 'img/affiche_intouchables.jpg', 3, 2, 2),
(3, 'Parasite', 'La famille Kim, pauvre, s\'infiltre progressivement dans la vie de la riche famille Park grâce à un stratagème ingénieux.', '2019-05-30', 132, 'Corée du Sud', 'Coréen', 'img/affiche_parasite.jpg', 6, 3, 3),
(4, 'The Dark Knight', 'Batman affronte le Joker, un criminel anarchiste qui sème le chaos à Gotham City en défiant toute logique.', '2008-07-18', 152, 'États-Unis', 'Anglais', 'img/affiche_dark_knight.jpg', 1, 1, 4),
(5, 'Interstellar', 'Un groupe d\'astronautes voyage à travers un trou de ver pour trouver une nouvelle planète habitable avant que la Terre ne soit condamnée.', '2014-11-05', 169, 'États-Unis', 'Anglais', 'img/affiche_interstellar.jpg', 5, 2, 5),
(6, 'Le Fabuleux Destin d\'Amélie Poulain', 'Une jeune femme timide décide de changer la vie des gens qui l\'entourent tout en ignorant son propre bonheur.', '2001-04-25', 122, 'France', 'Français', 'img/affiche_amelie.jpg', 2, 5, 6),
(7, 'Le Silence des Agneaux', 'Une jeune agente du FBI doit obtenir l\'aide d\'un tueur en série psychiatrique pour capturer un autre meurtrier surnommé Buffalo Bill.', '1991-02-14', 118, 'États-Unis', 'Anglais', 'img/affiche_silence_agneaux.jpg', 4, 3, 7),
(8, 'Pulp Fiction', 'Plusieurs histoires criminelles s\'entremêlent dans Los Angeles, racontées de façon non linéaire dans un ballet de violence et d\'humour noir.', '1994-10-26', 154, 'États-Unis', 'Anglais', 'img/affiche_pulp_fiction.jpg', 1, 2, 8);

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

CREATE TABLE `genre` (
  `id_genre` bigint(20) UNSIGNED NOT NULL,
  `nomGenre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`id_genre`, `nomGenre`) VALUES
(1, 'Action'),
(2, 'Comédie'),
(3, 'Drame'),
(4, 'Horreur'),
(5, 'Science-Fiction'),
(6, 'Thriller'),
(7, 'Animation'),
(8, 'Romance');

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `id_image` bigint(20) UNSIGNED NOT NULL,
  `chemin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id_image`, `chemin`) VALUES
(1, 'img/inception.jpg'),
(2, 'img/intouchables.jpg'),
(3, 'img/parasite.jpg'),
(4, 'img/dark_knight.jpg'),
(5, 'img/interstellar.jpg'),
(6, 'img/amelie.jpg'),
(7, 'img/silence_agneaux.jpg'),
(8, 'img/pulp_fiction.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `jouedans`
--

CREATE TABLE `jouedans` (
  `id_acteur` bigint(20) UNSIGNED NOT NULL,
  `id_film` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `jouedans`
--

INSERT INTO `jouedans` (`id_acteur`, `id_film`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 2),
(5, 2),
(6, 3),
(7, 4),
(8, 4),
(9, 5),
(10, 5),
(11, 6),
(12, 6),
(13, 7),
(14, 7),
(15, 8),
(16, 8);

-- --------------------------------------------------------

--
-- Structure de la table `plateforme`
--

CREATE TABLE `plateforme` (
  `id_plateforme` bigint(20) UNSIGNED NOT NULL,
  `nomPlateforme` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `plateforme`
--

INSERT INTO `plateforme` (`id_plateforme`, `nomPlateforme`) VALUES
(1, 'Cinéma'),
(2, 'Netflix'),
(3, 'Amazon Prime'),
(4, 'Disney+'),
(5, 'Canal+'),
(6, 'OCS');

-- --------------------------------------------------------

--
-- Structure de la table `realisateurs`
--

CREATE TABLE `realisateurs` (
  `id_real` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `realisateurs`
--

INSERT INTO `realisateurs` (`id_real`, `nom`, `prenom`) VALUES
(1, 'Nolan', 'Christopher'),
(2, 'Nakache', 'Olivier'),
(3, 'Toledano', 'Éric'),
(4, 'Bong', 'Joon-ho'),
(5, 'Jeunet', 'Jean-Pierre'),
(6, 'Demme', 'Jonathan'),
(7, 'Tarantino', 'Quentin');

-- --------------------------------------------------------

--
-- Structure de la table `realise`
--

CREATE TABLE `realise` (
  `id_film` bigint(20) UNSIGNED NOT NULL,
  `id_real` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `realise`
--

INSERT INTO `realise` (`id_film`, `id_real`) VALUES
(1, 1),
(4, 1),
(5, 1),
(2, 2),
(2, 3),
(3, 4),
(6, 5),
(7, 6),
(8, 7);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id_role` tinyint(3) UNSIGNED NOT NULL,
  `nomRole` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id_role`, `nomRole`) VALUES
(1, 'Membre'),
(2, 'Rédacteur'),
(3, 'Administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `dateNaissance` date NOT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `derniereConnexion` datetime NOT NULL,
  `id_role` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `login`, `mdp`, `email`, `adresse`, `dateNaissance`, `dateCreation`, `derniereConnexion`, `id_role`) VALUES
(1, 'Dupont', 'Alice', 'alice_d', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'alice.dupont@email.com', '12 rue des Lilas, Paris', '1995-03-15', '2025-01-10 09:00:00', '2025-05-01 14:22:00', 1),
(2, 'Martin', 'Bob', 'bob_m', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'bob.martin@email.com', '5 avenue Victor Hugo, Lyon', '1990-07-22', '2025-01-15 11:30:00', '2025-05-02 10:15:00', 2),
(3, 'Leroy', 'Clara', 'clara_l', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'clara.leroy@email.com', '8 boulevard Gambetta, Bordeaux', '1998-11-05', '2025-02-01 08:45:00', '2025-05-03 16:40:00', 2),
(4, 'Bernard', 'David', 'david_b', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'david.bernard@email.com', '22 rue de la Paix, Marseille', '1985-04-18', '2025-02-10 14:00:00', '2025-04-30 09:00:00', 1),
(5, 'Petit', 'Emma', 'emma_p', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'emma.petit@email.com', '3 place du Capitole, Toulouse', '2000-09-12', '2025-03-05 17:20:00', '2025-05-04 11:30:00', 1),
(6, 'Moreau', 'Félix', 'felix_m', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'felix.moreau@email.com', '15 rue Saint-Denis, Nantes', '1993-06-30', '2025-03-20 10:10:00', '2025-05-01 08:55:00', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `acteurs`
--
ALTER TABLE `acteurs`
  ADD PRIMARY KEY (`id_acteur`);

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id_article`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `id_film` (`id_film`);

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id_avis`),
  ADD UNIQUE KEY `uq_avis_user_article` (`id_utilisateur`,`id_article`),
  ADD KEY `id_article` (`id_article`);

--
-- Index pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD PRIMARY KEY (`id_utilisateur`,`id_film`),
  ADD KEY `id_film` (`id_film`);

--
-- Index pour la table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id_film`),
  ADD KEY `id_genre` (`id_genre`),
  ADD KEY `id_plateforme` (`id_plateforme`),
  ADD KEY `id_image` (`id_image`);

--
-- Index pour la table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id_genre`);

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id_image`);

--
-- Index pour la table `jouedans`
--
ALTER TABLE `jouedans`
  ADD PRIMARY KEY (`id_acteur`,`id_film`),
  ADD KEY `id_film` (`id_film`);

--
-- Index pour la table `plateforme`
--
ALTER TABLE `plateforme`
  ADD PRIMARY KEY (`id_plateforme`);

--
-- Index pour la table `realisateurs`
--
ALTER TABLE `realisateurs`
  ADD PRIMARY KEY (`id_real`);

--
-- Index pour la table `realise`
--
ALTER TABLE `realise`
  ADD PRIMARY KEY (`id_film`,`id_real`),
  ADD KEY `id_real` (`id_real`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `acteurs`
--
ALTER TABLE `acteurs`
  MODIFY `id_acteur` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id_article` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id_avis` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `film`
--
ALTER TABLE `film`
  MODIFY `id_film` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `genre`
--
ALTER TABLE `genre`
  MODIFY `id_genre` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `id_image` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `plateforme`
--
ALTER TABLE `plateforme`
  MODIFY `id_plateforme` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `realisateurs`
--
ALTER TABLE `realisateurs`
  MODIFY `id_real` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`),
  ADD CONSTRAINT `article_ibfk_2` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`);

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`),
  ADD CONSTRAINT `avis_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Contraintes pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD CONSTRAINT `favoris_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`),
  ADD CONSTRAINT `favoris_ibfk_2` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`);

--
-- Contraintes pour la table `film`
--
ALTER TABLE `film`
  ADD CONSTRAINT `film_ibfk_1` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`),
  ADD CONSTRAINT `film_ibfk_2` FOREIGN KEY (`id_plateforme`) REFERENCES `plateforme` (`id_plateforme`),
  ADD CONSTRAINT `film_ibfk_3` FOREIGN KEY (`id_image`) REFERENCES `image` (`id_image`);

--
-- Contraintes pour la table `jouedans`
--
ALTER TABLE `jouedans`
  ADD CONSTRAINT `jouedans_ibfk_1` FOREIGN KEY (`id_acteur`) REFERENCES `acteurs` (`id_acteur`),
  ADD CONSTRAINT `jouedans_ibfk_2` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`);

--
-- Contraintes pour la table `realise`
--
ALTER TABLE `realise`
  ADD CONSTRAINT `realise_ibfk_1` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  ADD CONSTRAINT `realise_ibfk_2` FOREIGN KEY (`id_real`) REFERENCES `realisateurs` (`id_real`);

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
