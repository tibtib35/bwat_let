<?php
session_start();
require_once("includes/auth.php");
require_once("includes/functions-DB.php");
require_once("php/functions_query.php");

// Vérifier que l'utilisateur est rédacteur ou administrateur
exigerRole(2);

$conn = connectionDB();
$id_utilisateur = $_SESSION['id_utilisateur'];
$articles = getArticlesByUser($conn, $id_utilisateur);
closeDB($conn);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes articles - Bwat Let</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <?php include("static/header.php"); ?>

    <main>
        <div class="container">
            <h1>Mes articles</h1>
            <p class="section-description">
                Voici la liste des articles que vous avez rédigés. Vous pouvez les visualiser, les modifier ou les supprimer.
            </p>

            <?php if (empty($articles)): ?>
                <div class="no-articles">
                    <p>Vous n'avez pas encore rédigé d'article.</p>
                    <a href="creer_article.php" class="btn-primary" style="display: inline-block; margin-top: 20px;">Créer un article</a>
                </div>
            <?php else: ?>
                <div class="articles-grid">
                    <?php foreach ($articles as $article): ?>
                        <div class="article-card">
                            <div class="article-header">
                                <h3 class="article-title"><?php echo htmlspecialchars($article['titreArticle']); ?></h3>
                            </div>
                            
                            <div class="article-meta">
                                <span><strong>Film:</strong> <?php echo htmlspecialchars($article['titreFilm']); ?></span>
                                <span><strong>Date:</strong> <?php echo date('d/m/Y', strtotime($article['dateCreation'])); ?></span>
                            </div>

                            <div class="article-actions">
                                <a href="article.php?id=<?php echo $article['id_article']; ?>" class="btn-small btn-view">Voir</a>
                                <a href="modifier_article.php?id=<?php echo $article['id_article']; ?>" class="btn-small btn-edit">Modifier</a>
                                <a href="supprimer_article.php?id=<?php echo $article['id_article']; ?>" class="btn-small btn-delete">Supprimer</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include("static/footer.php"); ?>
</body>
</html>
