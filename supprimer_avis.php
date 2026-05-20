<?php
session_start();
require_once("includes/auth.php");
require_once("includes/functions-DB.php");
require_once("php/functions_query.php");

exigerConnexion();

$id_avis = (int) ($_GET['id'] ?? 0);

if ($id_avis <= 0) {
    header('Location: index.php');
    exit;
}

$conn = connectionDB();
$avis = getAvis($conn, $id_avis);

if ($avis === null) {
    closeDB($conn);
    header('Location: index.php');
    exit;
}

if (!estAdmin() && !estAuteurAvis($conn, $id_avis, $_SESSION['id_utilisateur'])) {
    closeDB($conn);
    header('Location: index.php?erreur=droits');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_article = $avis['id_article'];
    $ok = supprimerAvis($conn, $id_avis);

    closeDB($conn);

    if ($ok) {
        header('Location: article.php?id=' . $id_article);
        exit;
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
    <title>Supprimer l'avis - Bwat Let</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include("static/header.php"); ?>
    <?php include("static/nav.php"); ?>

    <main>
        <div class="container form-page">
            <h2>Supprimer l'avis</h2>

            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                Êtes-vous sûr de vouloir supprimer cet avis ?
                <br><strong><?php echo htmlspecialchars($avis['titre']); ?></strong>
                <br>Cette action est irréversible.
            </div>

            <form method="POST" action="supprimer_avis.php?id=<?php echo $id_avis; ?>">
                <div class="form-actions">
                    <a href="article.php?id=<?php echo $avis['id_article']; ?>" class="btn-login">Annuler</a>
                    <button type="submit" class="btn-danger">Supprimer définitivement</button>
                </div>
            </form>

        </div>
    </main>

    <?php include("static/footer.php"); ?>
</body>
</html>
