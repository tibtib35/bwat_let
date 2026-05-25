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

$erreur = '';
$conn   = connectionDB();
$avis   = getAvis($conn, $id_avis);

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
    $titre = trim($_POST['titre'] ?? '');
    $texte = trim($_POST['texte'] ?? '');
    $note  = (int) ($_POST['note'] ?? 0);

    if ($titre === '') {
        $erreur = 'Le titre est obligatoire.';
    } elseif ($texte === '') {
        $erreur = 'Le texte est obligatoire.';
    } elseif ($note < 1 || $note > 5) {
        $erreur = 'La note doit être entre 1 et 5.';
    } else {
        $ok = modifierAvis($conn, $id_avis, $titre, $texte, $note);
        if ($ok) {
            closeDB($conn);
            header('Location: article.php?id=' . $avis['id_article']);
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
    <title>Modifier l'avis - Bwat Let</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include("static/header.php"); ?>

    <main>
        <div class="container">
            <div class="form-page">

                <h2>Modifier l'avis</h2>

                <?php if ($erreur !== ''): ?>
                    <p class="alert alert-error"><?php echo htmlspecialchars($erreur); ?></p>
                <?php endif; ?>

                <form method="POST" action="modifier_avis.php?id=<?php echo $id_avis; ?>">

                    <div class="form-group">
                        <label for="titre">Titre</label>
                        <input type="text" id="titre" name="titre"
                               value="<?php echo htmlspecialchars($_POST['titre'] ?? $avis['titre']); ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="note">Note</label>
                        <select id="note" name="note" required>
                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                <option value="<?php echo $i; ?>"
                                    <?php if ((int)($_POST['note'] ?? $avis['note']) === $i) echo 'selected'; ?>>
                                    <?php echo $i; ?> / 5
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="texte">Votre avis</label>
                        <textarea id="texte" name="texte" rows="8" required><?php echo htmlspecialchars($_POST['texte'] ?? $avis['texte']); ?></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Enregistrer</button>
                        <a href="article.php?id=<?php echo $avis['id_article']; ?>" class="btn-login">Annuler</a>
                    </div>

                </form>
            </div>
        </div>
    </main>

    <?php include("static/footer.php"); ?>
</body>
</html>
