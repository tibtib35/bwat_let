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
    $from_admin = isset($_GET['from']) && $_GET['from'] === 'admin';
    $ok = supprimerAvis($conn, $id_avis);
    closeDB($conn);
    if (!$ok) {
        header('Location: index.php?erreur=suppression');
    } elseif ($from_admin) {
        header('Location: admin.php');
    } else {
        header('Location: article.php?id=' . $id_article);
    }
    exit;
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

    <main>
        <div class="container">
            <div class="form-page">

                <h2>Supprimer l'avis</h2>

                <p class="alert alert-error">
                    Êtes-vous sûr de vouloir supprimer l'avis
                    <strong>«&nbsp;<?php echo htmlspecialchars($avis['titre']); ?>&nbsp;»</strong> ?
                    Cette action est irréversible.
                </p>

                <?php $from_admin = isset($_GET['from']) && $_GET['from'] === 'admin'; ?>
                <form method="POST" action="supprimer_avis.php?id=<?php echo $id_avis; ?><?php echo $from_admin ? '&from=admin' : ''; ?>">
                    <div class="form-actions">
                        <button type="submit" class="btn-danger">Supprimer définitivement</button>
                        <?php if ($from_admin): ?>
                            <a href="admin.php" class="btn-login">Annuler</a>
                        <?php else: ?>
                            <a href="article.php?id=<?php echo $avis['id_article']; ?>" class="btn-login">Annuler</a>
                        <?php endif; ?>
                    </div>
                </form>

            </div>
        </div>
    </main>

    <?php include("static/footer.php"); ?>
</body>
</html>
