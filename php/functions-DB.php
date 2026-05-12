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

function closeDB($mysqli) {
    mysqli_close($mysqli);
}

function readDB($mysqli, $sql_input) {
    $resultat = mysqli_query($mysqli, $sql_input);

    if (!$resultat) {
        return [];
    }

    if (mysqli_num_rows($resultat) === 0) {
        return [];
    }

    return mysqli_fetch_all($resultat, MYSQLI_ASSOC);
}

function writeDB($mysqli, $sql_input) {
    return mysqli_query($mysqli, $sql_input);
}
?>
