<?php
session_start();
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');
?>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Site de recettes</a>

        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="index.php">Accueil</a>
            </li>

            <?php if (isset($_SESSION['LOGGED_USER'])) : ?>

            <li class="nav-item">
                <a class="nav-link" href="logout.php">Me déconnecter</a>
            </li>

            <?php else : ?>

            <li class="nav-item">
                <a class="nav-link" href="register.php">M’inscrire</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Me connecter</a>
            </li>

            <?php endif; ?>
        </ul>

    </nav>
</header>