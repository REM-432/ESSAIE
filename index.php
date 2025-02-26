<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1>Connexion à l'espace membre</h1>
        <form action="connexion.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <label for="username"><i class="fas fa-user icon"></i> Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password"><i class="fas fa-lock icon"></i> Mot de passe :</label>
            <input type="password" id="password" name="password" required><br>
            <button type="submit"><i class="fas fa-sign-in-alt icon"></i> Se connecter</button>
        </form>
        <a href="inscription.php" class="btn-register"><i class="fas fa-user-plus icon"></i> Inscription</a>
    </div>
</body>
</html>