<?php
session_start();
require 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$stmt = $pdo->prepare('SELECT avatar FROM membres WHERE username = ?');
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch();

$_SESSION['avatar'] = $user['avatar'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Membre</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-user icon"></i>Bienvenue, <?= htmlspecialchars($_SESSION['username']); ?>!</h1>
        <?php if (!empty($_SESSION['avatar'])): ?>
            <img src="<?= htmlspecialchars($_SESSION['avatar']); ?>" alt="Avatar">
        <?php endif; ?>
        <div class="profile-options">
            <a href="modifier-profil.php"><i class="fas fa-edit icon"></i>Modifier Profil</a>
            <a href="deconnexion.php"><i class="fas fa-sign-out-alt icon"></i>Déconnexion</a>
        </div>
    </div>
</body>
</html>