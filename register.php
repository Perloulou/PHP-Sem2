<?php
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <!-- inclusion de l'entête du site -->
    <?php require_once(__DIR__ . '/header.php'); ?>

    <main class="container">

        <!-- Si utilisateur/trice est non identifié(e), on affiche le formulaire -->
        <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>

        <form action="form-r.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="pseudo">Pseudo:</label>
                <input type="text" id="pseudo" name="pseudo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="mail">Mail:</label>
                <input type="email" id="mail" name="mail" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe:</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="birthYear">Année de naissance:</label>
                <input type="number" id="birthYear" name="birthYear" min="1920" max="2024" step="1" class="form-control"
                    required>
            </div>
            <div class="form-group">
                <label for="bio">Bio:</label>
                <textarea placeholder="Ecris ta bio ici !" id="bio" name="bio" class="form-control" rows="5"
                    required></textarea>
            </div>
            <div class="form-group">
                <label for="pdp">Photo de profil:</label>
                <input type="file" id="pdp" name="pdp" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-primary">Inscription</button>
        </form>

        <!-- Si utilisateur/trice bien connectée on affiche un message de succès -->
        <?php else : ?>
        <div class="alert alert-success" role="alert">
            Bonjour <?php echo $_SESSION['LOGGED_USER']['pseudo']; ?>, tu es déjà inscrit.e !
        </div>
        <a href="logout.php">Pour créer un nouveau profil, déconnectes toi !</a>
        <?php endif; ?>

    </main>

    <!-- inclusion du bas de page du site -->
    <?php require_once(__DIR__ . '/footer.php'); ?>

</body>


</html>