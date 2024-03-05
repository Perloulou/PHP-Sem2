<?php
session_start();
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');

// Validation du formulaire
if (isset($_POST['mail']) && isset($_POST['password'])) {
    if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Il faut un email valide pour soumettre le formulaire.';
    } else {
        foreach ($users as $user) {
            if (
                $user['mail'] === $_POST['mail'] &&
                password_verify($_POST['password'], $user['password'])
            ) {
                // Incrémenter le compteur de connexion si les informations d'identification sont valides
                if (!isset($_COOKIE['LOGIN_COUNTER'])) {
                    // Si le cookie n'existe pas, initialiser le compteur à 1
                    setcookie('LOGIN_COUNTER', 1, time() + 365*24*3600, '/', '', false, false); // Réglages ajustés pour le développement en localhost
                } else {
                    // Si le cookie existe, incrémenter le compteur
                    setcookie('LOGIN_COUNTER', $_COOKIE['LOGIN_COUNTER'] + 1, time() + 365*24*3600, '/', '', false, false); // Réglages ajustés pour le développement en localhost
                }

                // Enregistrer l'utilisateur connecté dans la session
                $_SESSION['LOGGED_USER'] = [
                    'mail' => $user['mail'],
                    'pseudo' => $user['pseudo'],
                ];

                // Rediriger l'utilisateur vers une autre page après la connexion
                redirectToUrl('index.php');
            }
        }

        // Si les informations d'identification ne sont pas valides, afficher un message d'erreur
        $_SESSION['LOGIN_ERROR_MESSAGE'] = sprintf(
            'Les informations envoyées ne permettent pas de vous identifier : (%s/%s)',
            $_POST['mail'],
            strip_tags($_POST['password'])
        );
    }
}

// Rediriger l'utilisateur vers la page de connexion en cas d'échec de connexion
redirectToUrl('login.php');