<?php
require_once(__DIR__ . '/../includes/functions-DB.php');

function getArticles($mysqli, $page, $limite) {
    $offset = ($page - 1) * $limite;

    $sql = "SELECT id_article, article.titre AS titreArticle, article.contenu, article.dateCreation,
                 film.titre AS titreFilm, film.affiche, genre.nomGenre, utilisateurs.login AS auteur

            FROM article INNER JOIN film ON article.id_film = film.id_film
                INNER JOIN genre ON film.id_genre = genre.id_genre
                INNER JOIN utilisateurs ON article.id_utilisateur = utilisateurs.id_utilisateur
                
            ORDER BY article.dateCreation DESC
            LIMIT $limite OFFSET $offset";

    return readDB($mysqli, $sql);
}


function getNbArticles($mysqli) {
    $sql = "SELECT COUNT(*) AS total FROM article";

    $result = readDB($mysqli, $sql);

    return $result[0]['total'];
}


function getGenres($mysqli) {
    $sql = "SELECT id_genre, nomGenre FROM genre
            ORDER BY nomGenre ASC";

    return readDB($mysqli, $sql);
}

function getArticlesByRecherche($mysqli, $search, $genre, $page, $limite) {
    $offset = ($page - 1) * $limite;

    $search = mysqli_real_escape_string($mysqli, $search);

    $sql = "SELECT id_article, article.titre AS titreArticle, article.contenu, article.dateCreation,
                 film.titre AS titreFilm, film.affiche, genre.nomGenre, utilisateurs.login AS auteur
            FROM article
                INNER JOIN film ON article.id_film = film.id_film
                INNER JOIN genre ON film.id_genre = genre.id_genre
                INNER JOIN utilisateurs ON article.id_utilisateur = utilisateurs.id_utilisateur
            WHERE 1=1
                " . ($search ? "AND film.titre LIKE '%$search%'" : "") . "
                " . ($genre > 0 ? "AND genre.id_genre = $genre" : "") . "
            ORDER BY article.dateCreation DESC
            LIMIT $limite OFFSET $offset";

    return readDB($mysqli, $sql);
}



function getNbArticlesByRecherche($mysqli, $search, $genre) {
    $search = mysqli_real_escape_string($mysqli, $search);

    $sql = "SELECT COUNT(*) AS total
            FROM article
                INNER JOIN film ON article.id_film = film.id_film
                INNER JOIN genre ON film.id_genre = genre.id_genre
                INNER JOIN utilisateurs ON article.id_utilisateur = utilisateurs.id_utilisateur
            WHERE 1=1
                " . ($search ? "AND film.titre LIKE '%$search%'" : "") . "
                " . ($genre > 0 ? "AND genre.id_genre = $genre" : "") . ";";

    $result = readDB($mysqli, $sql);
    return $result[0]['total']; 
}


function getArticle($mysqli, $id) {
    $id = (int) $id;

    $sql = "SELECT id_article, article.titre AS titreArticle, article.contenu, article.dateCreation,
                 film.id_film, film.titre AS titreFilm, film.synopsis, film.dateSortie, film.duree, film.paysOrigine, film.langue, film.affiche,
                 genre.nomGenre, utilisateurs.login AS auteur,
                 image.chemin AS imageSecondaire
            FROM article INNER JOIN film ON article.id_film = film.id_film
                INNER JOIN genre ON film.id_genre = genre.id_genre
                INNER JOIN utilisateurs ON article.id_utilisateur = utilisateurs.id_utilisateur
                LEFT JOIN image ON film.id_image = image.id_image
            WHERE article.id_article = $id";

    $result = readDB($mysqli, $sql);
    return $result[0] ?? null;
}

function getAvisByArticle($mysqli, $id_article) {
    $id_article = (int) $id_article;

    $sql = "SELECT avis.id_avis, avis.id_utilisateur, avis.titre, avis.texte, avis.note, avis.dateCreation, utilisateurs.login AS auteur
            FROM avis
                INNER JOIN utilisateurs ON avis.id_utilisateur = utilisateurs.id_utilisateur
            WHERE avis.id_article = $id_article
              AND avis.visible = TRUE
            ORDER BY avis.dateCreation DESC";

    return readDB($mysqli, $sql);
}



function getMoyenneAvis($mysqli, $id_article) {
    $id_article = (int) $id_article;

    $sql = "SELECT AVG(note) AS moyenne, COUNT(*) AS nbAvis
            FROM avis
            WHERE id_article = $id_article
              AND visible = TRUE";

    $result = readDB($mysqli, $sql);

    return [
        'moyenne' => $result[0]['moyenne'] ?? 0,
        'nbAvis'  => $result[0]['nbAvis'] ?? 0,
    ];
}

function getRealisateursByFilm($mysqli, $id_film) {
    $id_film = (int) $id_film;

    $sql = "SELECT realisateurs.nom, realisateurs.prenom
            FROM realisateurs
                INNER JOIN realise ON realisateurs.id_real = realise.id_real
            WHERE realise.id_film = $id_film";

    return readDB($mysqli, $sql);
}


function getActeursByFilm($mysqli, $id_film) {
    $id_film = (int) $id_film;

    $sql = "SELECT acteurs.nom, acteurs.prenom
            FROM acteurs
                INNER JOIN joueDans ON acteurs.id_acteur = joueDans.id_acteur
            WHERE joueDans.id_film = $id_film";

    return readDB($mysqli, $sql);
}

function getFilmsSansArticle($mysqli) {
    $sql = "SELECT film.id_film, film.titre
            FROM film
            WHERE film.id_film NOT IN (
                SELECT id_film FROM article
            )
            ORDER BY film.titre ASC";

    return readDB($mysqli, $sql);
}



function creerArticle($mysqli, $titre, $contenu, $id_utilisateur, $id_film) {
    $titre          = mysqli_real_escape_string($mysqli, $titre);
    $contenu        = mysqli_real_escape_string($mysqli, $contenu);
    $id_utilisateur = (int) $id_utilisateur;
    $id_film        = (int) $id_film;

    $sql = "INSERT INTO article (titre, contenu, dateCreation, dateModification, id_utilisateur, id_film)
            VALUES (
                '$titre',
                '$contenu',
                NOW(),
                NOW(),
                $id_utilisateur,
                $id_film
            )";

    return writeDB($mysqli, $sql);
}


function modifierArticle($mysqli, $id_article, $titre, $contenu) {
    $titre      = mysqli_real_escape_string($mysqli, $titre);
    $contenu    = mysqli_real_escape_string($mysqli, $contenu);
    $id_article = (int) $id_article;

    $sql = "UPDATE article
            SET titre             = '$titre',
                contenu           = '$contenu',
                dateModification  = NOW()
            WHERE id_article = $id_article";

    return writeDB($mysqli, $sql);
}


function supprimerArticle($mysqli, $id_article) {
    $id_article = (int) $id_article;

    $sql = "DELETE FROM article WHERE id_article = $id_article";

    return writeDB($mysqli, $sql);
}



function creerAvis($mysqli, $id_article, $id_utilisateur, $titre, $texte, $note) {
    $id_article     = (int) $id_article;
    $id_utilisateur = (int) $id_utilisateur;
    $note           = (int) $note;
    $titre          = mysqli_real_escape_string($mysqli, $titre);
    $texte          = mysqli_real_escape_string($mysqli, $texte);

    if ($note < 1 || $note > 5) return false;

    $sql = "INSERT INTO avis (titre, texte, note, dateCreation, visible, id_article, id_utilisateur)
            VALUES ('$titre', '$texte', $note, NOW(), TRUE, $id_article, $id_utilisateur)";

    return writeDB($mysqli, $sql);
}


function getAvis($mysqli, $id_avis) {
    $id_avis = (int) $id_avis;

    $sql = "SELECT avis.id_avis, avis.id_utilisateur, avis.id_article, avis.titre, avis.texte, avis.note, avis.dateCreation
            FROM avis
            WHERE avis.id_avis = $id_avis";

    $result = readDB($mysqli, $sql);
    return $result[0] ?? null;
}


function modifierAvis($mysqli, $id_avis, $titre, $texte, $note) {
    $id_avis = (int) $id_avis;
    $note    = (int) $note;
    $titre   = mysqli_real_escape_string($mysqli, $titre);
    $texte   = mysqli_real_escape_string($mysqli, $texte);

    if ($note < 1 || $note > 5) return false;

    $sql = "UPDATE avis
            SET titre = '$titre',
                texte = '$texte',
                note  = $note
            WHERE id_avis = $id_avis";

    return writeDB($mysqli, $sql);
}


function supprimerAvis($mysqli, $id_avis) {
    $id_avis = (int) $id_avis;

    $sql = "DELETE FROM avis WHERE id_avis = $id_avis";

    return writeDB($mysqli, $sql);
}


function estAuteurAvis($mysqli, $id_avis, $id_utilisateur) {
    $id_avis        = (int) $id_avis;
    $id_utilisateur = (int) $id_utilisateur;

    $sql = "SELECT id_avis FROM avis
            WHERE id_avis       = $id_avis
              AND id_utilisateur = $id_utilisateur";

    $result = readDB($mysqli, $sql);
    return !empty($result);
}


function estAuteur($mysqli, $id_article, $id_utilisateur) {
    $id_article     = (int) $id_article;
    $id_utilisateur = (int) $id_utilisateur;

    $sql = "SELECT id_article FROM article
            WHERE id_article     = $id_article
              AND id_utilisateur = $id_utilisateur";

    $result = readDB($mysqli, $sql);

    return !empty($result);
}


function login($mysqli, $login, $password)
{
    $login = mysqli_real_escape_string($mysqli, $login);
    
    $sql = "SELECT id_utilisateur, login, nom, prenom, email, mdp, id_role
            FROM utilisateurs
            WHERE login = '" . $login . "'
            LIMIT 1";

    $result = readDB($mysqli, $sql);
    
    if (empty($result)) {
        return null;
    }
    
    $utilisateur = $result[0];
    
    if (password_verify($password, $utilisateur['mdp'])) {
        return $utilisateur;
    }
    
    if ($password === $utilisateur['mdp']) {
        return $utilisateur;
    }
    
    return null;
} 

 function getUserInfo($mysqli, $id_utilisateur) {
    $id_utilisateur = (int) $id_utilisateur;

    $sql = "SELECT utilisateurs.id_utilisateur, utilisateurs.login, utilisateurs.nom, utilisateurs.prenom, utilisateurs.email, utilisateurs.adresse, utilisateurs.mdp, utilisateurs.dateNaissance, utilisateurs.dateCreation, utilisateurs.derniereConnexion, utilisateurs.id_role, role.nomRole
            FROM utilisateurs
            LEFT JOIN role ON utilisateurs.id_role = role.id_role
            WHERE utilisateurs.id_utilisateur = $id_utilisateur
            LIMIT 1";

    $result = readDB($mysqli, $sql);
    return $result[0] ?? null;
}

function updateUserInfo($mysqli, $id_utilisateur, $nom, $prenom, $email, $adresse) {
    $id_utilisateur = (int) $id_utilisateur;
    $nom            = mysqli_real_escape_string($mysqli, $nom);
    $prenom         = mysqli_real_escape_string($mysqli, $prenom);
    $email          = mysqli_real_escape_string($mysqli, $email);
    $adresse        = mysqli_real_escape_string($mysqli, $adresse);

    $sql = "UPDATE utilisateurs
            SET nom             = '$nom',
                prenom          = '$prenom',
                email           = '$email',
                adresse         = '$adresse'
            WHERE id_utilisateur = $id_utilisateur";

    return writeDB($mysqli, $sql);
}

function updateUserPassword($mysqli, $id_utilisateur, $new_password) {
    $id_utilisateur = (int) $id_utilisateur;
    
    $new_mdp = mysqli_real_escape_string($mysqli, $new_password);
    
    $sql = "UPDATE utilisateurs
            SET mdp = '$new_mdp'
            WHERE id_utilisateur = $id_utilisateur";
    
    return writeDB($mysqli, $sql);
}

function aDejaUnAvis($mysqli, $id_article, $id_utilisateur) {
    $id_article     = (int) $id_article;
    $id_utilisateur = (int) $id_utilisateur;

    $sql = "SELECT id_avis FROM avis
            WHERE id_article = $id_article
              AND id_utilisateur = $id_utilisateur
            LIMIT 1";

    $result = readDB($mysqli, $sql);
    return !empty($result);
}


function getAvisByUser($mysqli, $id_utilisateur) {
    $id_utilisateur = (int) $id_utilisateur;

    $sql = "SELECT avis.id_avis, avis.titre, avis.note, avis.dateCreation,
                   article.id_article, article.titre AS titreArticle,
                   film.titre AS titreFilm
            FROM avis
                INNER JOIN article ON avis.id_article = article.id_article
                INNER JOIN film ON article.id_film = film.id_film
            WHERE avis.id_utilisateur = $id_utilisateur
              AND avis.visible = TRUE
            ORDER BY avis.dateCreation DESC";

    return readDB($mysqli, $sql);
}


function getArticlesByUser($mysqli, $id_utilisateur) {
    $id_utilisateur = (int) $id_utilisateur;

    $sql = "SELECT article.id_article, article.titre AS titreArticle, article.dateCreation,
                   film.titre AS titreFilm
            FROM article
                INNER JOIN film ON article.id_film = film.id_film
            WHERE article.id_utilisateur = $id_utilisateur
            ORDER BY article.dateCreation DESC";

    return readDB($mysqli, $sql);
}


function getAllUsers($mysqli) {
    $sql = "SELECT utilisateurs.id_utilisateur, utilisateurs.login, utilisateurs.nom, utilisateurs.prenom,
                   utilisateurs.email, utilisateurs.dateCreation, utilisateurs.id_role, role.nomRole
            FROM utilisateurs
                INNER JOIN role ON utilisateurs.id_role = role.id_role
            ORDER BY utilisateurs.dateCreation DESC";

    return readDB($mysqli, $sql);
}


function getAllArticles($mysqli) {
    $sql = "SELECT article.id_article, article.titre AS titreArticle, article.dateCreation,
                   film.titre AS titreFilm, utilisateurs.login AS auteur
            FROM article
                INNER JOIN film ON article.id_film = film.id_film
                INNER JOIN utilisateurs ON article.id_utilisateur = utilisateurs.id_utilisateur
            ORDER BY article.dateCreation DESC";

    return readDB($mysqli, $sql);
}


function getAllAvis($mysqli) {
    $sql = "SELECT avis.id_avis, avis.titre, avis.note, avis.dateCreation,
                   utilisateurs.login AS auteur, article.id_article, article.titre AS titreArticle
            FROM avis
                INNER JOIN utilisateurs ON avis.id_utilisateur = utilisateurs.id_utilisateur
                INNER JOIN article ON avis.id_article = article.id_article
            ORDER BY avis.dateCreation DESC";

    return readDB($mysqli, $sql);
}


function getRoles($mysqli) {
    $sql = "SELECT id_role, nomRole FROM role ORDER BY id_role ASC";
    return readDB($mysqli, $sql);
}


function changerRole($mysqli, $id_utilisateur, $id_role) {
    $id_utilisateur = (int) $id_utilisateur;
    $id_role        = (int) $id_role;

    $sql = "UPDATE utilisateurs SET id_role = $id_role WHERE id_utilisateur = $id_utilisateur";
    return writeDB($mysqli, $sql);
}


function getPlateformes($mysqli) {
    $sql = "SELECT id_plateforme, nomPlateforme FROM plateforme ORDER BY nomPlateforme ASC";
    return readDB($mysqli, $sql);
}


function creerFilm($mysqli, $titre, $synopsis, $dateSortie, $duree, $paysOrigine, $langue, $affiche, $id_genre, $id_plateforme) {
    $titre         = mysqli_real_escape_string($mysqli, $titre);
    $synopsis      = mysqli_real_escape_string($mysqli, $synopsis);
    $dateSortie    = mysqli_real_escape_string($mysqli, $dateSortie);
    $duree         = (int) $duree;
    $paysOrigine   = mysqli_real_escape_string($mysqli, $paysOrigine);
    $langue        = mysqli_real_escape_string($mysqli, $langue);
    $affiche       = mysqli_real_escape_string($mysqli, $affiche);
    $id_genre      = (int) $id_genre;
    $id_plateforme = (int) $id_plateforme;

    $sql = "INSERT INTO film (titre, synopsis, dateSortie, duree, paysOrigine, langue, affiche, id_genre, id_plateforme)
            VALUES ('$titre', '$synopsis', '$dateSortie', $duree, '$paysOrigine', '$langue', '$affiche', $id_genre, $id_plateforme)";

    if (!mysqli_query($mysqli, $sql)) return 0;
    return (int) mysqli_insert_id($mysqli);
}


function lierRealisateur($mysqli, $id_film, $nom, $prenom) {
    $id_film = (int) $id_film;
    $nom     = mysqli_real_escape_string($mysqli, $nom);
    $prenom  = mysqli_real_escape_string($mysqli, $prenom);

    $existing = readDB($mysqli, "SELECT id_real FROM realisateurs WHERE nom = '$nom' AND prenom = '$prenom' LIMIT 1");

    if (!empty($existing)) {
        $id_real = (int) $existing[0]['id_real'];
    } else {
        mysqli_query($mysqli, "INSERT INTO realisateurs (nom, prenom) VALUES ('$nom', '$prenom')");
        $id_real = (int) mysqli_insert_id($mysqli);
    }

    if ($id_real <= 0) return false;
    return writeDB($mysqli, "INSERT IGNORE INTO realise (id_film, id_real) VALUES ($id_film, $id_real)");
}


function lierActeur($mysqli, $id_film, $nom, $prenom) {
    $id_film = (int) $id_film;
    $nom     = mysqli_real_escape_string($mysqli, $nom);
    $prenom  = mysqli_real_escape_string($mysqli, $prenom);

    $existing = readDB($mysqli, "SELECT id_acteur FROM acteurs WHERE nom = '$nom' AND prenom = '$prenom' LIMIT 1");

    if (!empty($existing)) {
        $id_acteur = (int) $existing[0]['id_acteur'];
    } else {
        mysqli_query($mysqli, "INSERT INTO acteurs (nom, prenom) VALUES ('$nom', '$prenom')");
        $id_acteur = (int) mysqli_insert_id($mysqli);
    }

    if ($id_acteur <= 0) return false;
    return writeDB($mysqli, "INSERT IGNORE INTO joueDans (id_acteur, id_film) VALUES ($id_acteur, $id_film)");
}


function addProfile($mysqli, $login, $nom, $prenom, $address, $email, $dateNaissance, $mdp) {
    $login          = mysqli_real_escape_string($mysqli, $login);
    $nom            = mysqli_real_escape_string($mysqli, $nom);
    $prenom         = mysqli_real_escape_string($mysqli, $prenom);
    $address        = mysqli_real_escape_string($mysqli, $address);
    $dateNaissance  = mysqli_real_escape_string($mysqli, $dateNaissance);
    $email          = mysqli_real_escape_string($mysqli, $email);
    $mdp            = mysqli_real_escape_string($mysqli, $mdp);
    $dateCreation   = date('Y-m-d H:i:s');
    $derniereConnexion = date('Y-m-d H:i:s');
    $id_role        = 1;

    $sql = "INSERT INTO utilisateurs (nom, prenom, login, mdp, email, adresse, dateNaissance, dateCreation, derniereConnexion, id_role)
            VALUES ('$nom', '$prenom', '$login', '$mdp', '$email', '$address', '$dateNaissance', '$dateCreation', '$derniereConnexion', $id_role)";

    return writeDB($mysqli, $sql);
}