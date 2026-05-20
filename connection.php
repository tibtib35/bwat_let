<?php
require_once("includes/constantes.php");
require_once("includes/functions-DB.php");

session_start();

// Rediriger si déjà connecté
if (isset($_SESSION['id_utilisateur'])) {
    header('Location: index.php');
    exit();
}

$error = isset($_GET['erreur']) ? 'Login ou mot de passe incorrect.' : '';

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Bwat Let</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <?php include("static/header.php"); ?>
    <?php include("static/nav.php"); ?>

    <main>
        <section class="auth-page">
            <div class="auth-container">
                <div class="auth-card">
                    <div class="auth-header">
                        <h1>Se connecter</h1>
                        <p>Accédez à votre compte Bwat Let</p>
                    </div>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="php/login.php" class="auth-form">
                        <div class="form-group">
                            <label for="login">Nom d'utilisateur</label>
                            <input type="text" id="login" name="login" placeholder="Entrez votre nom d'utilisateur" required>
                        </div>

                        <div class="form-group">
                            <label for="mdp">Mot de passe</label>
                            <input type="password" id="mdp" name="mdp" placeholder="Entrez votre mot de passe" required>
                        </div>

                        <button type="submit" class="btn-primary btn-block">Se connecter</button>
                    </form>

                    <div class="auth-footer">
                        <p>Vous n'avez pas de compte ? <a href="inscription.php">S'inscrire</a></p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include("static/footer.php"); ?>
</body>

</html>
