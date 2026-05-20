<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Bwat Let</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php require_once('./static/header.php'); ?>
    <?php require_once('./static/nav.php'); ?>
    <main>
        <h2>Connexion</h2>

        <?php
        if (isset($_GET['erreur'])) {
            echo '<p>Login ou mot de passe incorrect.</p>';
        }
        ?>

        <form action="php/login.php" method="post">
            <label for="login">Login :</label>
            <input type="text" name="login" id="login">

            <label for="mdp">Mot de passe :</label>
            <input type="password" name="mdp" id="mdp">

            <input type="submit" value="Se connecter">
        </form>
    </main>
    <?php require_once('./static/footer.php'); ?>
</body>
</html>
