<?php

require_once("includes/constantes.php");
require_once("includes/functions-DB.php");
require_once("php/functions_query.php");
require_once("php/functions_structure.php");

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
        <section class="auth-page">
            <div class="auth-container">
                <div class="auth-card">
                    <div class="auth-header">
                        <h1>S'inscrire</h1>
                        <p>Créez un compte pour rejoindre Bwat Let</p>
                    </div>

                    <?php 
                    session_start();
                    $error = isset($_GET['error']) ? ($_SESSION['inscription_error'] ?? '') : '';
                    $success = isset($_GET['success']) ? true : false;
                    $saved_data = isset($_SESSION['inscription_data']) ? $_SESSION['inscription_data'] : [];
                    if (!empty($error)) unset($_SESSION['inscription_error']);
                    if (!empty($saved_data)) unset($_SESSION['inscription_data']);
                    ?>

                    <?php if ($error): ?>
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            Inscription réussie ! Vous pouvez maintenant vous connecter.
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="php/signup.php" class="auth-form">
                        <div class="form-group">
                            <label for="lastname">Nom</label>
                            <input type="text" id="lastname" name="lastname" placeholder="Entrez votre nom" value="<?php echo htmlspecialchars($saved_data['lastname'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="firstname">Prénom</label>
                            <input type="text" id="firstname" name="firstname" placeholder="Entrez votre prénom" value="<?php echo htmlspecialchars($saved_data['firstname'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Adresse</label>
                            <input type="text" id="address" name="address" placeholder="Entrez votre adresse" value="<?php echo htmlspecialchars($saved_data['address'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="birthdate">Date de naissance</label>
                            <input type="date" id="birthdate" name="birthdate" placeholder="Entrez votre date de naissance" value="<?php echo htmlspecialchars($saved_data['birthdate'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Nom d'utilisateur</label>
                            <input type="text" id="username" name="username" placeholder="Entrez votre nom d'utilisateur" value="<?php echo htmlspecialchars($saved_data['username'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Adresse email</label>
                            <input type="email" id="email" name="email" placeholder="Entrez votre email" value="<?php echo htmlspecialchars($saved_data['email'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                            <small>Au moins 8 caractères</small>
                        </div>

                        <div class="form-group">
                            <label for="password_confirm">Confirmer le mot de passe</label>
                            <input type="password" id="password_confirm" name="password_confirm" 
                                   placeholder="Confirmez votre mot de passe" required>
                        </div>

                        <button type="submit" class="btn-primary btn-block">S'inscrire</button>
                    </form>

                    <div class="auth-footer">
                        <p>Vous avez déjà un compte ? <a href="connection.php">Se connecter</a></p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include("static/footer.php"); ?>
</body>

</html>
