<?php
require_once('./functions-DB.php');
require_once('./functions_query.php');

session_start();

$login = $_POST['login'];
$mdp   = $_POST['mdp'];

$mysqli   = connectionDB();
$dresseur = getDresseur($mysqli, $login, $mdp);
closeDB($mysqli);

if ($dresseur !== null) {
    $_SESSION['id_dresseur']  = $dresseur['id_dresseur'];
    $_SESSION['nom_dresseur'] = $dresseur['nom_dresseur'];

    header('Location: ../index.php');
    exit;
} else {
    header('Location: ../connection.php?erreur=1');
    exit;
}
?>
