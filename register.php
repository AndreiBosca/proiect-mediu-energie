<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $error = "Numele de utilizator există deja.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        if ($stmt->execute([$username, $hash])) {
            header('Location: login.php');
            exit;
        } else {
            $error = "Eroare la crearea contului.";
        }
    }
}
?>
<!doctype html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <title>Înregistrare</title>
    <link rel="stylesheet" href="css/styles.css?v=2">
</head>
<body>
<div class="login-container">
    <h2>Creare Cont Nou</h2>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post">
        <label>Alege Utilizator:</label>
        <input type="text" name="username" required>
        <label>Alege Parolă:</label>
        <input type="password" name="password" required>
        <button type="submit">Creează Cont</button>
    </form>
    <p><a href="login.php">Înapoi la Login</a></p>
</div>
</body>
</html>