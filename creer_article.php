<?php
session_start();
require_once("includes/auth.php");
require_once("includes/functions-DB.php");
require_once("php/functions_query.php");

exigerRole(2);

$erreur = '';
$conn   = connectionDB();
$films  = getFilmsSansArticle($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre   = trim($_POST['titre'] ?? '');
    $contenu = trim($_POST['contenu'] ?? '');
    $id_film = (int) ($_POST['id_film'] ?? 0);

    if ($titre === '') {
        $erreur = 'Le titre est obligatoire.';
    } elseif ($contenu === '') {
        $erreur = 'Le contenu est obligatoire.';
    } elseif ($id_film <= 0) {
        $erreur = 'Veuillez sélectionner un film.';
    } else {
        $ok = creerArticle($conn, $titre, $contenu, $_SESSION['id_utilisateur'], $id_film);
        if ($ok) {
            closeDB($conn);
            header('Location: index.php');
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
    <title>Nouvel article - Bwat Let</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include("static/header.php"); ?>

    <main>
        <div class="container">
            <div class="form-page">

                <h2>Rédiger un article</h2>

                <?php if ($erreur !== ''): ?>
                    <p class="alert alert-error"><?php echo htmlspecialchars($erreur); ?></p>
                <?php endif; ?>

                <form method="POST" action="creer_article.php">

                    <div class="form-group">
                        <label for="titre">Titre</label>
                        <input type="text" id="titre" name="titre"
                               value="<?php echo htmlspecialchars($_POST['titre'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="id_film">Film</label>
                        <select id="id_film" name="id_film" required>
                            <option value="0">-- Choisir un film --</option>
                            <?php foreach ($films as $film): ?>
                                <option value="<?php echo $film['id_film']; ?>"
                                    <?php if (isset($_POST['id_film']) && $_POST['id_film'] == $film['id_film']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($film['titre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="contenu">Contenu</label>
                        <textarea id="contenu" name="contenu" rows="14" required><?php echo htmlspecialchars($_POST['contenu'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Publier</button>
                        <a href="index.php" class="btn-login">Annuler</a>
                    </div>

                </form>
            </div>
        </div>
    </main>

    <?php include("static/footer.php"); ?>
</body>
</html>
