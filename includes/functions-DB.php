<?php
require_once(__DIR__ . '/../includes/config-bdd.php');

function connect_db() {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $connexion = mysqli_connect(SERVEUR, UTILISATEUR, MOTDEPASSE, BASEDEDONNEES);
    mysqli_set_charset($connexion, "utf8");
    return $connexion;
}

function disconnect_db($connexion) {
    mysqli_close($connexion);
}

function readDB($connexion, $requete) {
    $resultat = mysqli_query($connexion, $requete);
    return mysqli_fetch_all($resultat, MYSQLI_ASSOC);
}

function writeDB($connexion, $requete) {
    return mysqli_query($connexion, $requete);
}
?>