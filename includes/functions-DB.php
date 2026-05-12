<?php
require_once(__DIR__ . '/../includes/config-bdd.php');

function connectionDB() {
    $connexion = mysqli_connect(SERVEUR, UTILISATEUR, MOTDEPASSE, BASEDEDONNEES);

    if (!$connexion) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }

    mysqli_set_charset($connexion, "utf8");

    return $connexion;
}

function closeDB($connexion) {
    mysqli_close($connexion);
}

function readDB($connexion, $sql_input) {
    $resultat = mysqli_query($connexion, $sql_input);

    if (!$resultat) {
        return [];
    }

    if (mysqli_num_rows($resultat) === 0) {
        return [];
    }

    return mysqli_fetch_all($resultat, MYSQLI_ASSOC);
}

function writeDB($connexion, $sql_input) {
    return mysqli_query($connexion, $sql_input);
}
?>
