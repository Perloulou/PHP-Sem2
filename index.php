<!-- inclusion des variables et fonctions -->

<?php
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/recipes.php');
require_once(__DIR__ . '/functions.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Page d'accueil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- inclusion de l'entête du site -->
    <?php require_once(__DIR__ . '/header.php'); ?>

    <main>
        <div class="container">
            <h1>Site de recettes</h1>
            <!-- Formulaire de connexion -->
            <?php require_once(__DIR__ . '/login.php'); 

            // Vérifier si l'utilisateur est connecté
            if (isset($_SESSION['LOGGED_USER'])) {
                // Afficher le nombre de connexions seulement si l'utilisateur est connecté
                echo "Nombre de connexions : " . $_COOKIE['LOGIN_COUNTER'];
            }
            
            foreach (getRecipes($recipes) as $recipe) : ?>
            <article>
                <h3><?php echo $recipe['title']; ?></h3>
                <div><?php echo $recipe['recipe']; ?></div>
                <i><?php echo displayAuthor($recipe['author'], $users); ?></i>
            </article>
            <?php endforeach ?>
        </div>
    </main>

    <!-- inclusion du bas de page du site -->
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>

</html>