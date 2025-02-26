<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1>Inscription</h1>
        <form id="registration-form" action="verification.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required><br>
            <label for="confirm_password">Confirmez le mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password" required><br>
            <label for="avatar">Avatar :</label>
            <input type="file" id="avatar" name="avatar" accept="image/*"><br>
            <button type="submit">S'inscrire</button>
        </form>
        <div class="spinner" id="spinner"></div>
        <div class="success-message" id="success-message">Votre compte a été créé avec succès !</div>
        <a href="index.php" class="btn-return">Retour à la connexion</a>
    </div>
    <script>
        document.getElementById('registration-form').addEventListener('submit', function(event) {
            event.preventDefault();
            document.getElementById('spinner').style.display = 'block';
            setTimeout(() => {
                this.submit();
            }, 2000); 
        });
    </script>
</body>
</html>