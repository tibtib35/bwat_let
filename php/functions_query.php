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
?>
