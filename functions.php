<?php
// Charger les données existantes
$users = include(__DIR__ . '/variables.php');

function saveData($data) {
    global $users;

    // Ajouter les nouvelles données
    $users[] = $data;

    // Enregistrer les données mises à jour
    file_put_contents(__DIR__ . '/variables.php', '<?php return ' . var_export($users, true) . ';');

    // Définir un cookie pour l'utilisateur
    setcookie(
        'LOGGED_USER',
        json_encode(['mail' => $data['mail'], 'pseudo' => $data['pseudo']]), // Inclure le pseudo dans le cookie
        [
            'expires' => time() + 365*24*3600,
            'secure' => true,
            'httponly' => true,
        ]
    );

}

function displayAuthor(string $authorEmail, array $users): string
{
    foreach ($users as $user) {
        if ($authorEmail === $user['mail']) {
            return $user['pseudo'] . ' (' . $user['age'] . ' ans)';
        }
    }
    return 'Auteur inconnu';
}

function isValidRecipe(array $recipe): bool
{
    if (array_key_exists('is_enabled', $recipe)) {
        $isEnabled = $recipe['is_enabled'];
    } else {
        $isEnabled = false;
    }

    return $isEnabled;
}

function getRecipes(array $recipes): array
{
    $valid_recipes = [];

    foreach ($recipes as $recipe) {
        if (isValidRecipe($recipe)) {
            $valid_recipes[] = $recipe;
        }
    }

    return $valid_recipes;
}
function redirectToUrl(string $url): never
{
    header("Location: {$url}");
    exit();
}