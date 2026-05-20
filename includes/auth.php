<?php
function exigerConnexion() {
    if (!isset($_SESSION['id_utilisateur'])) {
        header('Location: ../connection.php');
        exit;
    }
}

function exigerRole($roleMin) {
    exigerConnexion();

    if ($_SESSION['id_role'] < $roleMin) {
        header('Location: ../index.php?erreur=droits');
        exit;
    }
}


function estAdmin() {
    return isset($_SESSION['id_role']) && $_SESSION['id_role'] === 3;
}
?>
