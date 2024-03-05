<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <?php
session_start();
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/variables.php');

// Vérification que tous les champs sont remplis
if (!empty($_POST['pseudo']) && !empty($_POST['mail']) && !empty($_POST['birthYear']) && !empty($_POST['bio']) && !empty($_FILES['pdp']) && $_FILES['pdp']['error'] == 0) {

    // Vérification du format de l'adresse email
    if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        echo "Le format de l'adresse email n'est pas correct !";
        echo '<br><a href="javascript:history.back()">Retour</a>';
    } else {
        // Récupération de l'année de naissance soumise dans le formulaire
        $birthYear = intval($_POST['birthYear']);

        // Calcul de l'âge en soustrayant l'année de naissance de l'année actuelle
        $currentYear = date('Y');
        $age = $currentYear - $birthYear;

        // Vérification si l'utilisateur a au moins 18 ans
        if ($age < 18) {
            echo "Vous devez avoir au moins 18 ans pour vous inscrire.";
            echo '<br><a href="javascript:history.back()">Retour</a>';
            return;
        }

        if ($_FILES['pdp']['size'] > 1000000) {
            echo "L'envoi n'a pas pu être effectué, erreur ou image trop volumineuse";
            return;
        }

        // Testons, si l'extension n'est pas autorisée
        $fileInfo = pathinfo($_FILES['pdp']['name']);
        $extension = $fileInfo['extension'];
        $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];

        if (!in_array($extension, $allowedExtensions)) {
            echo "L'envoi n'a pas pu être effectué, l'extension {$extension} n'est pas autorisée";
            return;
        }

        // Testons, si le dossier uploads est manquant
        $path = __DIR__ . '/uploads/';

        if (!is_dir($path)) {
            echo "L'envoi n'a pas pu être effectué, le dossier uploads est manquant";
            return;
        }

        // On peut valider le fichier et le stocker définitivement
        move_uploaded_file($_FILES['pdp']['tmp_name'], $path . basename($_FILES['pdp']['name']));

        // Traitement des données du formulaire
        // Permet d'éviter les attaques XSS
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashage du mot de passe                    
        $mail = htmlspecialchars($_POST['mail']);
        $bio = htmlspecialchars($_POST['bio']);

        $data = [
            'pseudo' => $pseudo,
            'password' => $password,
            'mail' => $mail,
            'age' => $age,
            'bio' => $bio,
            'pdp' => $path . basename($_FILES['pdp']['name'])
        ];

        // Enregistrement des données dans variables.php
        saveData($data);

        // Déconnexion de l'utilisateur après l'inscription
        session_destroy();
        require_once(__DIR__ . '/header.php');

        // Affichage de la carte avec les informations de l'utilisateur
        ?>
    <div class="container">
        <h3>Message bien reçu !</h3>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Rappel de vos informations</h5>
                <p class="card-text"><b>Pseudo</b> : <?php echo $pseudo; ?></p>
                <p class="card-text"><b>Email</b> : <?php echo $mail; ?></p>
                <p class="card-text"><b>Age</b> : <?php echo $age; ?></p>
                <p class="card-text"><b>Bio</b> : <?php echo $bio; ?></p>
            </div>
        </div>
        <br>
        <a href="login.php">Se connecter</a>
    </div>
    <?php
    }
} else {
    echo "Merci de remplir tous les champs pour s'inscrire.";
    echo '<br><a href="javascript:history.back()">Retour</a>';
    return;
}

?>

</body>

</html>