<?php
session_start();
require_once("includes/auth.php");
require_once("includes/functions-DB.php");
require_once("php/functions_query.php");

/* TODO: appeler exigerRole() avec le bon rôle minimum */

$id_article = /* TODO: récupérer $_GET['id'] casté en (int), valeur par défaut 0 */ 0;

if ($id_article <= 0) {
    header('Location: index.php');
    exit;
}

$conn    = connectionDB();
$article = /* TODO: appeler getArticle() */ null;

if ($article === null) {
    closeDB($conn);
    header('Location: index.php');
    exit;
}

// Vérifier les droits : auteur OU administrateur
if (/* TODO: même vérification que dans modifier_article.php */ false) {
    closeDB($conn);
    header('Location: index.php?erreur=droits');
    exit;
}

// Traitement : suppression confirmée via POST
if (/* TODO: vérifier que la méthode HTTP est POST */) {
    $ok = /* TODO: appeler supprimerArticle() */ false;

    closeDB($conn);

    if ($ok) {
        // TODO: rediriger vers index.php
    } else {
        header('Location: index.php?erreur=suppression');
        exit;
    }
}

closeDB($conn);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer l'article - Bwat Let</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include("static/header.php"); ?>
    <?php include("static/nav.php"); ?>

    <main>
        <div class="container form-page">
            <h2>Supprimer l'article</h2>

            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                Êtes-vous sûr de vouloir supprimer l'article
                <strong><?php echo htmlspecialchars($article['titreArticle']); ?></strong> ?
                <br>Cette action est irréversible.
            </div>

            <!-- Formulaire de confirmation : un bouton POST pour confirmer -->
            <form method="POST" action="supprimer_article.php?id=<?php echo $id_article; ?>">
                <div class="form-actions">
                    <a href="article.php?id=<?php echo $id_article; ?>" class="btn-login">Annuler</a>
                    <button type="submit" class="btn-danger">Supprimer définitivement</button>
                </div>
            </form>

        </div>
    </main>

    <?php include("static/footer.php"); ?>
</body>
</html>
