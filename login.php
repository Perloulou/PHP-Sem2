<?php

require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- inclusion de l'entête du site -->
    <?php require_once(__DIR__ . '/header.php'); ?>


    <main>
        <div class="container">
            <?php 
            // Vérifie si un message d'erreur est présent dans les paramètres GET
            if (isset($_GET['error'])) {
                // Affiche un message d'erreur approprié
                echo '<div class="alert alert-danger" role="alert">Vous devez être connecté pour vous déconnecter.</div>';
            }
            ?>

            <!-- Si utilisateur/trice est non identifié(e), on affiche le formulaire -->
            <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>

            <form action="form-l.php" method="POST">
                <!-- si message d'erreur on l'affiche -->
                <?php if (isset($_SESSION['LOGIN_ERROR_MESSAGE'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_SESSION['LOGIN_ERROR_MESSAGE'];
                    unset($_SESSION['LOGIN_ERROR_MESSAGE']); ?>
                    <!-- Bouton pour créer un compte -->
                    <br>
                    <a href="register.php" class="btn btn-primary">Créer un compte</a>
                </div>
                <?php endif; ?>
                <div class="mb-3">
                    <label for="mail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="mail" name="mail" aria-describedby="mail-help"
                        placeholder="you@exemple.com" required>
                    <div id="mail-help" class="form-text">L'email utilisé lors de la création de compte.</div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>

            <!-- Si utilisateur/trice bien connectée on affiche un message de succès -->
            <?php else : ?>
            <div class="alert alert-success" role="alert">
                Bonjour <?php echo $_SESSION['LOGGED_USER']['pseudo']; ?>, tu es déjà connecté.e !
            </div>
            <a href="logout.php">Cliques ici pour te déconnecter !</a>
            <?php endif; ?>

        </div>
    </main>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var emailField = document.getElementById("mail");
        var loggedUserEmail =
            "<?php echo isset($_SESSION['LOGGED_USER']['mail']) ? $_SESSION['LOGGED_USER']['mail'] : ''; ?>";
        emailField.value = loggedUserEmail;
    });
    </script>
</body>

</html>