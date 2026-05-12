
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
    `note` TINYINT UNSIGNED NOT NULL CHECK (`note` BETWEEN 0 AND 10),
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