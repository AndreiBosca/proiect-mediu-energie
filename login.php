<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Utilizator sau parolă incorectă.";
    }
}
?>
<!doctype html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <title>Login - Proiect Energie</title>
    <link rel="stylesheet" href="css/styles.css?v=2">
</head>
<body>
<div class="login-container">
    <h2>Autentificare</h2>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post">
        <label>Utilizator:</label>
        <input type="text" name="username" required>
        <label>Parolă:</label>
        <input type="password" name="password" required>
        <button type="submit">Intră în cont</button>
    </form>
    <p>Nu ai cont? <a href="register.php">Înregistrează-te aici</a></p>
</div>
</body>
</html>