<?php
session_start();
require_once("includes/auth.php");
require_once("includes/functions-DB.php");
require_once("php/functions_query.php");

exigerRole(2);

$id_article = (int) ($_GET['id'] ?? 0);

if ($id_article <= 0) {
    header('Location: index.php');
    exit;
}

$erreur = '';
$conn   = connectionDB();
$article = getArticle($conn, $id_article);

if ($article === null) {
    closeDB($conn);
    header('Location: index.php');
    exit;
}

if (!estAdmin() && !estAuteur($conn, $id_article, $_SESSION['id_utilisateur'])) {
    closeDB($conn);
    header('Location: index.php?erreur=droits');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre   = trim($_POST['titre'] ?? '');
    $contenu = trim($_POST['contenu'] ?? '');

    if ($titre === '') {
        $erreur = 'Le titre est obligatoire.';
    } elseif ($contenu === '') {
        $erreur = 'Le contenu est obligatoire.';
    } else {
        $ok = modifierArticle($conn, $id_article, $titre, $contenu);
        if ($ok) {
            closeDB($conn);
            header('Location: article.php?id=' . $id_article);
            exit;
        } else {
            $erreur = 'Une erreur est survenue, veuillez réessayer.';
        }
    }
}

closeDB($conn);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'article - Bwat Let</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include("static/header.php"); ?>

    <main>
        <div class="container">
            <div class="form-page">

                <h2>Modifier l'article</h2>

                <?php if ($erreur !== ''): ?>
                    <p class="alert alert-error"><?php echo htmlspecialchars($erreur); ?></p>
                <?php endif; ?>

                <form method="POST" action="modifier_article.php?id=<?php echo $id_article; ?>">

                    <div class="form-group">
                        <label for="titre">Titre</label>
                        <input type="text" id="titre" name="titre"
                               value="<?php echo htmlspecialchars($_POST['titre'] ?? $article['titreArticle']); ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Film</label>
                        <p class="form-static"><?php echo htmlspecialchars($article['titreFilm']); ?></p>
                    </div>

                    <div class="form-group">
                        <label for="contenu">Contenu</label>
                        <textarea id="contenu" name="contenu" rows="14" required><?php echo htmlspecialchars($_POST['contenu'] ?? $article['contenu']); ?></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Enregistrer</button>
                        <a href="article.php?id=<?php echo $id_article; ?>" class="btn-login">Annuler</a>
                    </div>

                </form>
            </div>
        </div>
    </main>

    <?php include("static/footer.php"); ?>
</body>
</html>
