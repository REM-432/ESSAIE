<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Erreur de sécurité.');
    }

    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo 'Les mots de passe ne correspondent pas. <a href="inscription.php">Réessayer</a>';
        exit();
    }

    $stmt = $pdo->prepare('SELECT COUNT(*) FROM membres WHERE username = ?');
    $stmt->execute([$username]);
    if ($stmt->fetchColumn() > 0) {
        echo 'Nom d\'utilisateur déjà pris. <a href="inscription.php">Réessayer</a>';
    } else {
        $avatarPath = null;
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $avatarDir = 'uploads/avatars/';
            if (!is_dir($avatarDir)) {
                mkdir($avatarDir, 0777, true);
            }
            $avatarPath = $avatarDir . basename($_FILES['avatar']['name']);
            move_uploaded_file($_FILES['avatar']['tmp_name'], $avatarPath);
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare('INSERT INTO membres (username, password, avatar) VALUES (?, ?, ?)');
        if ($stmt->execute([$username, $hashed_password, $avatarPath])) {
            echo '<div class="success-message">Votre compte a été créé avec succès ! Vous allez être redirigé...</div>';
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "index.php";
                    }, 3000); // Redirection après 3 secondes
                  </script>';
        } else {
            echo 'Erreur lors de l\'inscription. <a href="inscription.php">Réessayer</a>';
        }
    }
}
?>