<?php
session_start();
require_once("includes/constantes.php");
require_once("includes/functions-DB.php");

if (isset($_SESSION['id_utilisateur'])) {
    header('Location: index.php');
    exit;
}

$erreur = isset($_GET['erreur']) ? 'Login ou mot de passe incorrect.' : '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Bwat Let</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <?php include("static/header.php"); ?>

    <main>
        <div class="container">
            <div class="form-page">

                <h2>Se connecter</h2>

                <?php if ($erreur): ?>
                    <p class="alert alert-error"><?php echo htmlspecialchars($erreur); ?></p>
                <?php endif; ?>

                <form method="POST" action="php/login.php">

                    <div class="form-group">
                        <label for="login">Nom d'utilisateur</label>
                        <input type="text" id="login" name="login" required>
                    </div>

                    <div class="form-group">
                        <label for="mdp">Mot de passe</label>
                        <input type="password" id="mdp" name="mdp" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Se connecter</button>
                        <a href="inscription.php" class="btn-login">Créer un compte</a>
                    </div>

                </form>
            </div>
        </div>
    </main>

    <?php include("static/footer.php"); ?>
</body>
</html>
