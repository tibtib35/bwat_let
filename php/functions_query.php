<?php
require_once(__DIR__ . '/../includes/functions-DB.php');

// Retourne un tableau d'articles avec le titre du film et le login de l'auteur
// Triés par dateCreation, limités pour la pagination
// $page    : numéro de page courante (commence à 1)
// $limite  : nombre d'articles par page
function getArticles($conn, $page, $limite) {
    $offset = ($page - 1) * $limite;

    $sql = "SELECT id_article, article.titre AS titreArticle, article.contenu, article.dateCreation,
                 film.titre AS titreFilm, film.affiche, genre.nomGenre, utilisateurs.login AS auteur

            FROM article INNER JOIN film ON article.id_film = film.id_film
                INNER JOIN genre ON film.id_genre = genre.id_genre
                INNER JOIN utilisateurs ON article.id_utilisateur = utilisateurs.id_utilisateur
                
            ORDER BY article.dateCreation DESC
            LIMIT $limite OFFSET $offset";

    return readDB($conn, $sql);
}


function getNbArticles($conn) {
    $sql = "SELECT COUNT(*) AS total FROM article";

    $result = readDB($conn, $sql);

    return $result[0]['total'];
}


function getGenres($conn) {
    $sql = "SELECT id_genre, nomGenre FROM genre
            ORDER BY nomGenre ASC";

    return readDB($conn, $sql);
}

function getArticlesByRecherche($conn, $search, $genre, $page, $limite) {
    $offset = ($page - 1) * $limite;

    $search = mysqli_real_escape_string($conn, $search);

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

    return readDB($conn, $sql);
}



function getNbArticlesByRecherche($conn, $search, $genre) {
    $search = mysqli_real_escape_string($conn, $search);

    $sql = "SELECT COUNT(*) AS total
            FROM article
                INNER JOIN film ON article.id_film = film.id_film
                INNER JOIN genre ON film.id_genre = genre.id_genre
                INNER JOIN utilisateurs ON article.id_utilisateur = utilisateurs.id_utilisateur
            WHERE 1=1
                " . ($search ? "AND film.titre LIKE '%$search%'" : "") . "
                " . ($genre > 0 ? "AND genre.id_genre = $genre" : "") . ";";

    $result = readDB($conn, $sql);
    return $result[0]['total']; 
}

// ============================================================
// V3 — Fonctions pour la page détail d'un article
// ============================================================

// Retourne un article complet avec les infos du film, du genre et de l'auteur
// Retourne null si l'article n'existe pas
// $id : id_article récupéré depuis l'URL
function getArticle($conn, $id) {
    $id = (int) $id;

    $sql = "SELECT id_article, article.titre AS titreArticle, article.contenu, article.dateCreation,
                 film.id_film, film.titre AS titreFilm, film.synopsis, film.dateSortie, film.duree, film.paysOrigine, film.langue, film.affiche,
                 genre.nomGenre, utilisateurs.login AS auteur
            FROM article InNER JOIN film ON article.id_film = film.id_film
                INNER JOIN genre ON film.id_genre = genre.id_genre
                INNER JOIN utilisateurs ON article.id_utilisateur = utilisateurs.id_utilisateur
            WHERE article.id_article = $id";

    $result = readDB($conn, $sql);

    // readDB retourne un tableau : on veut juste le premier (et unique) résultat
    // Si le tableau est vide, l'article n'existe pas → on retourne null
    return $result[0] ?? null;
}

function getAvisByArticle($conn, $id_article) {
    $id_article = (int) $id_article;

    $sql = "SELECT avis.id_avis, avis.titre, avis.texte, avis.note, avis.dateCreation, utilisateurs.login AS auteur
            FROM avis
                INNER JOIN utilisateurs ON avis.id_utilisateur = utilisateurs.id_utilisateur
            WHERE avis.id_article = $id_article
              AND avis.visible = TRUE
            ORDER BY avis.dateCreation DESC";
        
            

    return readDB($conn, $sql);
}



function getMoyenneAvis($conn, $id_article) {
    $id_article = (int) $id_article;

    $sql = "SELECT AVG(note) AS moyenne, COUNT(*) AS nbAvis
            FROM avis
            WHERE id_article = $id_article
              AND visible = TRUE";

    $result = readDB($conn, $sql);

    return [
        'moyenne' => $result[0]['moyenne'] ?? 0,
        'nbAvis'  => $result[0]['nbAvis'] ?? 0,
    ];
}

function getRealisateursByFilm($conn, $id_film) {
    $id_film = (int) $id_film;

    $sql = "SELECT realisateurs.nom, realisateurs.prenom
            FROM realisateurs
                INNER JOIN realise ON realisateurs.id_real = realise.id_real
            WHERE realise.id_film = $id_film";

    return readDB($conn, $sql);
}


function getActeursByFilm($conn, $id_film) {
    $id_film = (int) $id_film;

    $sql = "SELECT acteurs.nom, acteurs.prenom
            FROM acteurs
                INNER JOIN joueDans ON acteurs.id_acteur = joueDans.id_acteur
            WHERE joueDans.id_film = $id_film";

    return readDB($conn, $sql);
}

function getFilmsSansArticle($conn) {
    $sql = "SELECT film.id_film, film.titre
            FROM film
            WHERE film.id_film NOT IN (
                SELECT id_film FROM article
            )
            ORDER BY film.titre ASC";

    return readDB($conn, $sql);
}



function creerArticle($conn, $titre, $contenu, $id_utilisateur, $id_film) {
    $titre          = mysqli_real_escape_string($conn, $titre);
    $contenu        = mysqli_real_escape_string($conn, $contenu);
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

    return writeDB($conn, $sql);
}


function modifierArticle($conn, $id_article, $titre, $contenu) {
    $titre      = mysqli_real_escape_string($conn, $titre);
    $contenu    = mysqli_real_escape_string($conn, $contenu);
    $id_article = (int) $id_article;

    $sql = "UPDATE article
            SET titre             = '$titre',
                contenu           = '$contenu',
                dateModification  = NOW()
            WHERE id_article = $id_article";

    return writeDB($conn, $sql);
}


function supprimerArticle($conn, $id_article) {
    $id_article = (int) $id_article;

    $sql = "DELETE FROM article WHERE id_article = $id_article";

    return writeDB($conn, $sql);
}



function estAuteur($conn, $id_article, $id_utilisateur) {
    $id_article     = (int) $id_article;
    $id_utilisateur = (int) $id_utilisateur;

    $sql = "SELECT id_article FROM article
            WHERE id_article     = $id_article
              AND id_utilisateur = $id_utilisateur";

    $result = readDB($conn, $sql);

    return !empty($result);
}
?>
