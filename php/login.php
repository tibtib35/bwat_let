<?php
require_once('../includes/constantes.php');
require_once('../includes/functions-DB.php');
require_once('./functions_query.php');

session_start();

$error = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $mdp = $_POST['mdp'] ?? '';

    if (empty($login)) {
        $error = 'Le nom d\'utilisateur est requis.';
    } elseif (empty($mdp)) {
        $error = 'Le mot de passe est requis.';
    } else {
        try {
            $mysqli = connectionDB();
            $utilisateur = login($mysqli, $login, $mdp);
            closeDB($mysqli);

            if ($utilisateur !== null) {
                $_SESSION['id_utilisateur'] = $utilisateur['id_utilisateur'];
                $_SESSION['login'] = $utilisateur['login'];
                $_SESSION['prenom'] = $utilisateur['prenom'] ?? '';
                $_SESSION['nom'] = $utilisateur['nom'] ?? '';
                
                header('Location: ../index.php');
                exit();
            } else {
                header('Location: ../connection.php?erreur=1');
                exit();
            }
        } catch (Exception $e) {
            header('Location: ../connection.php?erreur=2');
            exit();
        }
    }
} else {

    header('Location: ../connection.php');
    exit();
}
?>
