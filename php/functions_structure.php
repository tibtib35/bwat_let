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
    <article class=\"article-card\">
        <div class=\"article-image\">
            <img src=\"{$affiche}\" alt=\"Affiche de {$titre}\">
            <span class=\"article-category\">{$genre}</span>
        </div>
        <div class=\"article-content\">
            <h3>{$titre}</h3>
            <div class=\"article-meta\">
                <span class=\"article-date\">
                    <i class=\"fas fa-calendar\"></i>
                    {$dateFormatee}
                </span>
                <span class=\"article-author\">
                    <i class=\"fas fa-user\"></i>
                    {$auteur}
                </span>
            </div>
            <p class=\"article-excerpt\">{$extrait}</p>
            <a href=\"article.php?id={$id}\" class=\"read-more\">
                Lire l'article <i class=\"fas fa-arrow-right\"></i>
            </a>
        </div>
    </article>";
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
