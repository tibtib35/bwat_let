<?php
session_start();
require_once("includes/constantes.php");
require_once("includes/functions-DB.php");
require_once("php/functions_query.php");

$erreur  = isset($_GET['error'])   ? ($_SESSION['inscription_error'] ?? '') : '';
$succes  = isset($_GET['success']);
$donnees = $_SESSION['inscription_data'] ?? [];

if ($erreur)   unset($_SESSION['inscription_error']);
if ($donnees)  unset($_SESSION['inscription_data']);

if (isset($_SESSION['id_utilisateur'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Bwat Let</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include("static/header.php"); ?>

    <main>
        <div class="container">
            <div class="form-page">

                <h2>Créer un compte</h2>

                <?php if ($erreur): ?>
                    <p class="alert alert-error"><?php echo htmlspecialchars($erreur); ?></p>
                <?php endif; ?>

                <?php if ($succes): ?>
                    <p class="alert alert-success">Inscription réussie ! <a href="connection.php">Se connecter</a></p>
                <?php endif; ?>

                <form method="POST" action="php/signup.php">

                    <div class="form-group">
                        <label for="lastname">Nom</label>
                        <input type="text" id="lastname" name="lastname"
                               value="<?php echo htmlspecialchars($donnees['lastname'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="firstname">Prénom</label>
                        <input type="text" id="firstname" name="firstname"
                               value="<?php echo htmlspecialchars($donnees['firstname'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="username">Nom d'utilisateur</label>
                        <input type="text" id="username" name="username"
                               value="<?php echo htmlspecialchars($donnees['username'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email"
                               value="<?php echo htmlspecialchars($donnees['email'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="birthdate">Date de naissance</label>
                        <input type="date" id="birthdate" name="birthdate"
                               value="<?php echo htmlspecialchars($donnees['birthdate'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Adresse</label>
                        <input type="text" id="address" name="address"
                               value="<?php echo htmlspecialchars($donnees['address'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" required>
                        <small>Au moins 8 caractères</small>
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">Confirmer le mot de passe</label>
                        <input type="password" id="password_confirm" name="password_confirm" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">S'inscrire</button>
                        <a href="connection.php" class="btn-login">Déjà un compte ?</a>
                    </div>

                </form>
            </div>
        </div>
    </main>

    <?php include("static/footer.php"); ?>
</body>
</html>
