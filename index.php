<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once("includes/constantes.php");
require_once("includes/functions-DB.php");
require_once("php/functions_query.php");
require_once("php/functions_structure.php");


$limite = 6; 
$page   = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$genre  = isset($_GET['genre']) ? (int) $_GET['genre'] : 0;


$conn = connectionDB();

// --- Récupération des articles ---
// Si une recherche est active, on filtre — sinon on prend tout
if ($search !== '' || $genre > 0) {
    $articles   = getArticlesByRecherche($conn, $search, $genre, $page, $limite);
    $nbArticles = getNbArticlesByRecherche($conn, $search, $genre);
} else {
    $articles   = getArticles($conn, $page, $limite);
    $nbArticles = getNbArticles($conn);
}


$nbPages = ceil($nbArticles / $limite);


$genres = getGenres($conn);


closeDB($conn);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bwat Let - Cataloguez vos films préférés</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <?php include("static/header.php"); ?>
    <?php include("static/nav.php"); ?>

    <main>

        <?php if (!isset($_SESSION['id_utilisateur'])): ?>
        <section class="accueil">
            <div class="accueil-content">
                <h1>Cataloguez vos films préférés</h1>
                <p>Bienvenue sur Bwat Let</p>
                <a href="inscription.php" class="btn-primary">S'inscrire</a>
            </div>
            <div class="accueil-background">
                <div class="accueil-overlay"></div>
            </div>
        </section>
        <?php endif; ?>


        <section class="recent-articles" id="films">
            <div class="container">
                <h2>Articles Récents</h2>

                
                <form method="GET" action="index.php" class="search-form">

                    <input type="text"
                           name="search"
                           placeholder="Rechercher un film..."
                           value="<?php echo htmlspecialchars($search); ?>">

                    <select name="genre">
                        <option value="0">Tous les genres</option>
                        <?php foreach ($genres as $g): ?>
                            <option value="<?php echo $g['id_genre']; ?>"
                                <?php if ($g['id_genre'] == $genre): ?>
                                    selected
                                <?php endif; ?>>
                                <?php echo htmlspecialchars($g['nomGenre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit">Rechercher</button>

                </form>

                <div class="articles-grid">
                    <?php if (empty($articles)): ?>
                        <p>Aucun article trouvé.</p>
                    <?php else: ?>
                        <?php foreach ($articles as $article): ?>
                            <?php afficherCarteArticle($article); ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <?php 
                    afficherPagination($page, $nbPages, ['search' => $search, 'genre' => $genre]);
                ?>

            </div>
        </section>

    </main>

    <?php include("static/footer.php"); ?>

</body>

</html>
