<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Chemin vers les includes (remonter d'un niveau depuis php/)
require_once("../includes/constantes.php");
require_once("../includes/functions-DB.php");
require_once("functions_query.php");
require_once("functions_structure.php");

// Initialiser les variables
$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lastname = trim($_POST['lastname'] ?? '');
    $firstname = trim($_POST['firstname'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $birthdate = trim($_POST['birthdate'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    // Validations
    if (empty($lastname)) {
        $error = 'Le nom est requis.';
    } elseif (empty($firstname)) {
        $error = 'Le prénom est requis.';
    } elseif (empty($address)) {
        $error = 'L\'adresse est requise.';
    } elseif (empty($birthdate)) {
        $error = 'La date de naissance est requise.';
    } elseif (empty($username)) {
        $error = 'Le nom d\'utilisateur est requis.';
    } elseif (empty($email)) {
        $error = 'L\'email est requis.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'L\'email n\'est pas valide.';
    } elseif (empty($password)) {
        $error = 'Le mot de passe est requis.';
    } elseif (strlen($password) < 8) {
        $error = 'Le mot de passe doit contenir au moins 8 caractères.';
    } elseif ($password !== $password_confirm) {
        $error = 'Les mots de passe ne correspondent pas.';
    } else {
        // Ajouter le nouvel utilisateur à la base de données
        $mysqli = connectionDB();
        $insert_result = addProfile($mysqli, $username, $lastname, $firstname, $address, $email, $birthdate, $password);
        closeDB($mysqli);
        
        if ($insert_result) {
            $success = true;
        } else {
            $error = 'Erreur lors de l\'inscription. Veuillez réessayer.';
        }
    }
} else {
    $error = 'Méthode de requête non valide.';
}

// Redirection ou retour avec message
if ($success) {
    // Redirection vers la page de connexion avec message de succès
    header('Location: ../inscription.php?success=1');
    exit();
} else {
    // Retour à la page d'inscription avec les erreurs et données
    $_SESSION['inscription_error'] = $error;
    $_SESSION['inscription_data'] = [
        'lastname' => $lastname ?? '',
        'firstname' => $firstname ?? '',
        'address' => $address ?? '',
        'birthdate' => $birthdate ?? '',
        'username' => $username ?? '',
        'email' => $email ?? ''
    ];
    header('Location: ../inscription.php?error=1');
    exit();
}

?>