<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['LOGGED_USER'])) {
    // Redirige vers la page de connexion avec un paramètre GET pour indiquer l'erreur
    header('Location: index.php?error=not_logged_in');
    exit;
}

// Déconnexion de l'utilisateur
unset($_SESSION['LOGGED_USER']);

// Redirige vers la page de connexion
header('Location: index.php');
exit;