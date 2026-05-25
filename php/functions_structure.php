<?php

function afficherCarteArticle($article) {
    $dateFormatee = date('d M Y', strtotime($article['dateCreation']));
    $extrait      = substr($article['contenu'], 0, 150) . '...';
    $id           = (int) $article['id_article'];
    $titre        = htmlspecialchars($article['titreArticle']);
    $genre        = htmlspecialchars($article['nomGenre']);
    $auteur       = htmlspecialchars($article['auteur']);
    $affiche      = htmlspecialchars($article['affiche']);

    echo "
    <a href=\"article.php?id={$id}\" class=\"article-card\">
        <img src=\"{$affiche}\" alt=\"Affiche de {$titre}\" class=\"article-card-img\">
        <div class=\"article-card-overlay\">
            <span class=\"article-category\">{$genre}</span>
            <h3 class=\"article-card-title\">{$titre}</h3>
            <p class=\"article-card-meta\">
                <i class=\"fas fa-user\"></i> {$auteur}
                &nbsp;&bull;&nbsp;
                <i class=\"fas fa-calendar\"></i> {$dateFormatee}
            </p>
        </div>
    </a>";
}


function afficherPagination($page, $nbPages, $params = []) {
    if ($nbPages <= 1) return;

    unset($params['page']);
    $queryString = http_build_query($params);
    if ($queryString) $queryString = '&' . $queryString;

    echo '<div class="pagination">';

    if ($page > 1) {
        echo '<a href="index.php?page=' . ($page - 1) . $queryString . '" class="pagination-link">← Précédent</a>';
    }

    for ($i = 1; $i <= $nbPages; $i++) {
        $classeActive = ($i === $page) ? 'active' : '';
        echo '<a href="index.php?page=' . $i . $queryString . '" class="pagination-link ' . $classeActive . '">' . $i . '</a>';
    }

    if ($page < $nbPages) {
        echo '<a href="index.php?page=' . ($page + 1) . $queryString . '" class="pagination-link">Suivant →</a>';
    }

    echo '</div>';
}
?>
