<?php
session_start();
require_once("includes/auth.php");
require_once("includes/functions-DB.php");
require_once("php/functions_query.php");

exigerRole(2);

$conn = connectionDB();
$articles = getArticlesByUser($conn, $_SESSION['id_utilisateur']);
closeDB($conn);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes articles - Bwat Let</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include("static/header.php"); ?>

    <main>
        <section class="profile-section">
            <div class="container">
                <div class="profile-card" style="max-width: 860px;">
                    <h2>Mes articles (<?php echo count($articles); ?>)</h2>

                    <?php if (empty($articles)): ?>
                        <p>Vous n'avez pas encore rédigé d'article. <a href="creer_article.php" style="color: var(--accent);">Créer un article</a></p>
                    <?php else: ?>
                        <ul class="profile-list">
                            <?php foreach ($articles as $art): ?>
                                <li class="profile-list-item">
                                    <div>
                                        <div class="profile-list-title"><?php echo htmlspecialchars($art['titreArticle']); ?></div>
                                        <div class="profile-list-meta">
                                            <?php echo htmlspecialchars($art['titreFilm']); ?>
                                            &bull; <?php echo date('d/m/Y', strtotime($art['dateCreation'])); ?>
                                        </div>
                                    </div>
                                    <div class="profile-list-actions">
                                        <a href="article.php?id=<?php echo $art['id_article']; ?>" class="btn-edit">Voir</a>
                                        <a href="modifier_article.php?id=<?php echo $art['id_article']; ?>" class="btn-edit">Modifier</a>
                                        <a href="supprimer_article.php?id=<?php echo $art['id_article']; ?>" class="btn-danger-small">Supprimer</a>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <?php include("static/footer.php"); ?>
</body>
</html>
