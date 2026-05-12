<?php
require_once('../includes/functions-DB.php');
require_once('./functions_query.php');

session_start();

$login = $_POST['login'];
$mdp   = $_POST['mdp'];

$mysqli   = connectionDB();
$utilisateur = getUtilisateur($mysqli, $login, $mdp);
closeDB($mysqli);

if ($utilisateur !== null) {
    $_SESSION['id_utilisateur']  = $utilisateur['id_utilisateur'];
    $_SESSION['username'] = $utilisateur['username'];

    header('Location: ../index.php');
    exit;
} else {
    header('Location: ../connection.php?erreur=1');
    exit;
}
?>
