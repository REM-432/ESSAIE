<?php
session_start();
require 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $avatarPath = $_SESSION['avatar'];

    if ($password !== $confirm_password) {
        echo 'Les mots de passe ne correspondent pas. <a href="modifier-profil.php">Réessayer</a>';
        exit();
    }

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $avatarDir = 'uploads/avatars/';
        if (!is_dir($avatarDir)) {
            mkdir($avatarDir, 0777, true);
        }
        $avatarPath = $avatarDir . basename($_FILES['avatar']['name']);
        move_uploaded_file($_FILES['avatar']['tmp_name'], $avatarPath);
    }

    $stmt = $pdo->prepare('UPDATE membres SET username = ?, avatar = ? WHERE username = ?');
    $stmt->execute([$username, $avatarPath, $_SESSION['username']]);

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('UPDATE membres SET password = ? WHERE username = ?');
        $stmt->execute([$hashed_password, $username]);
    }

    $_SESSION['username'] = $username;
    $_SESSION['avatar'] = $avatarPath;

    header('Location: espace-membre.php');
    exit();
}

$stmt = $pdo->prepare('SELECT * FROM membres WHERE username = ?');
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Profil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Modifier Profil</h1>
        <form action="modifier-profil.php" method="POST" enctype="multipart/form-data">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" required><br>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password"><br>
            <label for="confirm_password">Confirmez le mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password"><br>
            <label for="avatar">Avatar :</label>
            <input type="file" id="avatar" name="avatar" accept="image/*"><br>
            <button type="submit">Mettre à jour</button>
        </form>
        <a href="espace-membre.php">Retour</a>
    </div>
</body>
</html>