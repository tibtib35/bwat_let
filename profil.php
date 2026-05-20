<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("includes/constantes.php");
require_once("includes/functions-DB.php");
require_once("php/functions_query.php");
require_once("php/functions_structure.php");

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_utilisateur'])) {
    header('Location: connection.php');
    exit();
}

$user_id = $_SESSION['id_utilisateur'];
$error = '';
$success = '';

// Récupérer les informations de l'utilisateur depuis la base de données
$mysqli = connectionDB();
$user = getUserInfo($mysqli, $user_id);
closeDB($mysqli);

// Rediriger si l'utilisateur n'existe pas
if (!$user) {
    header('Location: index.php');
    exit();
}

// Traiter les modifications du profil
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
        // Mettre à jour la base de données
        $mysqli = connectionDB();
        $update_result = updateUserInfo($mysqli, $user_id, $new_nom, $new_prenom, $new_email, $new_adresse);
        closeDB($mysqli);
        
        if ($update_result) {
            $success = 'Profil mis à jour avec succès !';
            $user['nom'] = $new_nom;
            $user['prenom'] = $new_prenom;
            $user['email'] = $new_email;
            $user['adresse'] = $new_adresse;
        } else {
            $error = 'Erreur lors de la mise à jour du profil.';
        }
    }
}

// Traiter le changement de mot de passe
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
    } else {
        // Vérifier que l'ancien mot de passe est correct
        if ($old_password === $user['mdp']) {
            // Vérifier que le nouveau mot de passe est différent de l'ancien
            if ($new_password === $user['mdp']) {
                $error = 'Le nouveau mot de passe doit être différent de l\'ancien.';
            } else {
                // Mettre à jour le mot de passe
                $mysqli = connectionDB();
                $update_result = updateUserPassword($mysqli, $user_id, $new_password);
                closeDB($mysqli);
                
                if ($update_result) {
                    $success = 'Mot de passe changé avec succès !';
                    // Récupérer les infos actualisées
                    $mysqli = connectionDB();
                    $user = getUserInfo($mysqli, $user_id);
                    closeDB($mysqli);
                } else {
                    $error = 'Erreur lors de la mise à jour du mot de passe.';
                }
            }
        } else {
            $error = 'L\'ancien mot de passe est incorrect.';
        }
    }
}

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
                    <!-- Barre d'onglets -->
                    <div class="profile-tabs">
                        <button class="tab-button active" onclick="switchTab('profile')">
                            <i class="fas fa-user"></i> Informations personnelles
                        </button>
                        <button class="tab-button" onclick="switchTab('password')">
                            <i class="fas fa-lock"></i> Mot de passe
                        </button>
                    </div>

                    <!-- Onglet Informations personnelles -->
                    <div id="profile" class="tab-content active">
                        <div class="profile-card">
                            <h2>Informations personnelles</h2>

                            <?php if (!empty($error)): ?>
                                <div class="alert alert-error">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <?php echo htmlspecialchars($error); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($success)): ?>
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i>
                                    <?php echo htmlspecialchars($success); ?>
                                </div>
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
                                    <input type="text" id="login" name="login" value="<?php echo htmlspecialchars($user['login']); ?>" disabled>
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
                                        <label for="dateNaissance">Date de naissance</label>
                                        <input type="date" id="dateNaissance" name="dateNaissance" value="<?php echo htmlspecialchars($user['dateNaissance']); ?>" disabled>
                                        <small>Ne peut pas être modifiée</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Rôle</label>
                                        <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($user['nomRole']); ?>" disabled>
                                        <small>Ne peut pas être modifié</small>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="dateCreation">Membre depuis</label>
                                        <input type="text" id="dateCreation" name="dateCreation" value="<?php echo date('d/m/Y', strtotime($user['dateCreation'])); ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="derniereConnexion">Dernière connexion</label>
                                        <input type="text" id="derniereConnexion" name="derniereConnexion" value="<?php echo date('d/m/Y à H:i', strtotime($user['derniereConnexion'])); ?>" disabled>
                                    </div>
                                </div>

                                <button type="submit" name="update_profile" class="btn-primary">
                                    <i class="fas fa-save"></i> Sauvegarder les modifications
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Onglet Mot de passe -->
                    <div id="password" class="tab-content">
                        <div class="profile-card">
                            <h2>Changer le mot de passe</h2>

                            <?php if (!empty($error) && isset($_POST['update_password'])): ?>
                                <div class="alert alert-error">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <?php echo htmlspecialchars($error); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($success) && isset($_POST['update_password'])): ?>
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i>
                                    <?php echo htmlspecialchars($success); ?>
                                </div>
                            <?php endif; ?>

                            <form method="POST" class="profile-form">
                                <div class="form-group">
                                    <label for="old_password">Ancien mot de passe</label>
                                    <input type="password" id="old_password" name="old_password" placeholder="Entrez votre ancien mot de passe" required>
                                </div>

                                <div class="form-group">
                                    <label for="new_password">Nouveau mot de passe</label>
                                    <input type="password" id="new_password" name="new_password" placeholder="Entrez votre nouveau mot de passe" required>
                                    <small>Au moins 8 caractères</small>
                                </div>

                                <div class="form-group">
                                    <label for="confirm_password">Confirmer le mot de passe</label>
                                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmez votre nouveau mot de passe" required>
                                </div>

                                <button type="submit" name="update_password" class="btn-primary">
                                    <i class="fas fa-key"></i> Changer le mot de passe
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Lien de déconnexion -->
                    <div class="profile-actions">
                        <a href="php/logout.php" class="btn-secondary">
                            <i class="fas fa-sign-out-alt"></i> Se déconnecter
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include("static/footer.php"); ?>

    <script>
        function switchTab(tabName) {
            // Masquer tous les onglets
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => tab.classList.remove('active'));

            // Désactiver tous les boutons
            const buttons = document.querySelectorAll('.tab-button');
            buttons.forEach(btn => btn.classList.remove('active'));

            // Afficher l'onglet sélectionné
            document.getElementById(tabName).classList.add('active');

            // Activer le bouton correspondant
            event.target.classList.add('active');
        }
    </script>
</body>

</html>
