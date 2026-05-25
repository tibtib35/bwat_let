<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("includes/constantes.php");
require_once("includes/functions-DB.php");
require_once("php/functions_query.php");
require_once("php/functions_structure.php");

session_start();

if (!isset($_SESSION['id_utilisateur'])) {
    header('Location: connection.php');
    exit();
}

$user_id = $_SESSION['id_utilisateur'];
$error = '';
$success = '';

$mysqli = connectionDB();
$user = getUserInfo($mysqli, $user_id);
closeDB($mysqli);

if (!$user) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $new_email = trim($_POST['email'] ?? '');
    $new_adresse = trim($_POST['adresse'] ?? '');
    $new_prenom = trim($_POST['prenom'] ?? '');
    $new_nom = trim($_POST['nom'] ?? '');

    if (empty($new_email)) {
        $error = 'L\'email est requis.';
    } elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $error = 'L\'email n\'est pas valide.';
    } elseif (empty($new_adresse)) {
        $error = 'L\'adresse est requise.';
    } elseif (empty($new_nom)) {
        $error = 'Le nom est requis.';
    } elseif (empty($new_prenom)) {
        $error = 'Le prénom est requis.';
    } else {
        $mysqli = connectionDB();
        $update_result = updateUserInfo($mysqli, $user_id, $new_nom, $new_prenom, $new_email, $new_adresse);
        closeDB($mysqli);

        if ($update_result) {
            $success = 'Profil mis à jour avec succès.';
            $user['nom'] = $new_nom;
            $user['prenom'] = $new_prenom;
            $user['email'] = $new_email;
            $user['adresse'] = $new_adresse;
        } else {
            $error = 'Erreur lors de la mise à jour du profil.';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_password'])) {
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($old_password)) {
        $error = 'L\'ancien mot de passe est requis.';
    } elseif (empty($new_password)) {
        $error = 'Le nouveau mot de passe est requis.';
    } elseif (strlen($new_password) < 8) {
        $error = 'Le nouveau mot de passe doit contenir au moins 8 caractères.';
    } elseif ($new_password !== $confirm_password) {
        $error = 'Les mots de passe ne correspondent pas.';
    } elseif ($old_password !== $user['mdp']) {
        $error = 'L\'ancien mot de passe est incorrect.';
    } elseif ($new_password === $user['mdp']) {
        $error = 'Le nouveau mot de passe doit être différent de l\'ancien.';
    } else {
        $mysqli = connectionDB();
        $update_result = updateUserPassword($mysqli, $user_id, $new_password);
        closeDB($mysqli);

        if ($update_result) {
            $success = 'Mot de passe changé avec succès.';
            $mysqli = connectionDB();
            $user = getUserInfo($mysqli, $user_id);
            closeDB($mysqli);
        } else {
            $error = 'Erreur lors de la mise à jour du mot de passe.';
        }
    }
}

$mysqli = connectionDB();
$mes_avis = getAvisByUser($mysqli, $user_id);
$mes_articles = getArticlesByUser($mysqli, $user_id);
closeDB($mysqli);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Bwat Let</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include("static/header.php"); ?>

    <main>
        <section class="profile-section">
            <div class="container">

                <div class="profile-header">
                    <div class="profile-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="profile-welcome">
                        <h1>Bienvenue, <?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?> !</h1>
                        <p class="profile-role">
                            <i class="fas fa-shield-alt"></i>
                            Rôle : <strong><?php echo htmlspecialchars($user['nomRole'] ?? 'Utilisateur'); ?></strong>
                        </p>
                    </div>
                </div>

                <div class="profile-content">

                    <div class="profile-card">
                        <h2>Informations personnelles</h2>

                        <?php if (!empty($error) && isset($_POST['update_profile'])): ?>
                            <p class="alert alert-error"><?php echo htmlspecialchars($error); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($success) && isset($_POST['update_profile'])): ?>
                            <p class="alert alert-success"><?php echo htmlspecialchars($success); ?></p>
                        <?php endif; ?>

                        <form method="POST" class="profile-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="nom">Nom</label>
                                    <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="login">Nom d'utilisateur</label>
                                <input type="text" id="login" value="<?php echo htmlspecialchars($user['login']); ?>" disabled>
                                <small>Ne peut pas être modifié</small>
                            </div>

                            <div class="form-group">
                                <label for="email">Adresse email</label>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="adresse">Adresse</label>
                                <input type="text" id="adresse" name="adresse" value="<?php echo htmlspecialchars($user['adresse']); ?>" required>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Date de naissance</label>
                                    <input type="date" value="<?php echo htmlspecialchars($user['dateNaissance']); ?>" disabled>
                                    <small>Ne peut pas être modifiée</small>
                                </div>
                                <div class="form-group">
                                    <label>Rôle</label>
                                    <input type="text" value="<?php echo htmlspecialchars($user['nomRole']); ?>" disabled>
                                    <small>Ne peut pas être modifié</small>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Membre depuis</label>
                                    <input type="text" value="<?php echo date('d/m/Y', strtotime($user['dateCreation'])); ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Dernière connexion</label>
                                    <input type="text" value="<?php echo date('d/m/Y à H:i', strtotime($user['derniereConnexion'])); ?>" disabled>
                                </div>
                            </div>

                            <button type="submit" name="update_profile" class="btn-primary">Sauvegarder</button>
                        </form>
                    </div>

                    <div class="profile-card" style="margin-top: 1.5rem;">
                        <h2>Changer le mot de passe</h2>

                        <?php if (!empty($error) && isset($_POST['update_password'])): ?>
                            <p class="alert alert-error"><?php echo htmlspecialchars($error); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($success) && isset($_POST['update_password'])): ?>
                            <p class="alert alert-success"><?php echo htmlspecialchars($success); ?></p>
                        <?php endif; ?>

                        <form method="POST" class="profile-form">
                            <div class="form-group">
                                <label for="old_password">Ancien mot de passe</label>
                                <input type="password" id="old_password" name="old_password" placeholder="Entrez votre ancien mot de passe" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">Nouveau mot de passe</label>
                                <input type="password" id="new_password" name="new_password" placeholder="Au moins 8 caractères" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirmer le mot de passe</label>
                                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmez votre nouveau mot de passe" required>
                            </div>
                            <button type="submit" name="update_password" class="btn-primary">Changer le mot de passe</button>
                        </form>
                    </div>

                    <div class="profile-actions">
                        <a href="php/logout.php" class="btn-secondary">
                            <i class="fas fa-sign-out-alt"></i> Se déconnecter
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <section class="profile-section" style="padding-top: 0;">
            <div class="container">

                <div class="profile-card" style="max-width: 860px;">
                    <h2>Mes avis (<?php echo count($mes_avis); ?>)</h2>

                    <?php if (empty($mes_avis)): ?>
                        <p>Vous n'avez pas encore posté d'avis.</p>
                    <?php else: ?>
                        <ul class="profile-list">
                            <?php foreach ($mes_avis as $a): ?>
                                <li class="profile-list-item">
                                    <div>
                                        <div class="profile-list-title">
                                            <?php echo htmlspecialchars($a['titre']); ?>
                                            — <span style="color: var(--accent);"><?php echo $a['note']; ?>/5</span>
                                        </div>
                                        <div class="profile-list-meta">
                                            <?php echo htmlspecialchars($a['titreFilm']); ?>
                                            &bull; <?php echo date('d/m/Y', strtotime($a['dateCreation'])); ?>
                                        </div>
                                    </div>
                                    <div class="profile-list-actions">
                                        <a href="article.php?id=<?php echo $a['id_article']; ?>" class="btn-edit">Voir</a>
                                        <a href="modifier_avis.php?id=<?php echo $a['id_avis']; ?>" class="btn-edit">Modifier</a>
                                        <a href="supprimer_avis.php?id=<?php echo $a['id_avis']; ?>" class="btn-danger-small">Supprimer</a>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <?php if ((int)($_SESSION['id_role'] ?? 0) >= 2): ?>
                <div class="profile-card" style="max-width: 860px; margin-top: 1.5rem;">
                    <h2>Mes articles (<?php echo count($mes_articles); ?>)</h2>

                    <?php if (empty($mes_articles)): ?>
                        <p>Vous n'avez pas encore rédigé d'article.</p>
                    <?php else: ?>
                        <ul class="profile-list">
                            <?php foreach ($mes_articles as $art): ?>
                                <li class="profile-list-item">
                                    <div>
                                        <div class="profile-list-title"><?php echo htmlspecialchars($art['titreArticle']); ?></div>
                                        <div class="profile-list-meta">
                                            <?php echo htmlspecialchars($art['titreFilm']); ?>
                                            &bull; <?php echo date('d/m/Y', strtotime($art['dateCreation'])); ?>
                                        </div>
                                    </div>
                                    <div class="profile-list-actions">
                                        <a href="article.php?id=<?php echo $art['id_article']; ?>" class="btn-edit">Voir</a>
                                        <a href="modifier_article.php?id=<?php echo $art['id_article']; ?>" class="btn-edit">Modifier</a>
                                        <a href="supprimer_article.php?id=<?php echo $art['id_article']; ?>" class="btn-danger-small">Supprimer</a>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </div>
        </section>
    </main>

    <?php include("static/footer.php"); ?>
</body>
</html>
