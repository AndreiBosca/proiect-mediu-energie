<?php
require 'db.php';
session_start(); // Pornim sesiunea

// Dacă nu e logat, îl trimitem la login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Luăm ID-ul din sesiune, NU din $_POST (pentru securitate)
    $user_id = $_SESSION['user_id'];
    $year = (int)$_POST['year'];
    $month = (int)$_POST['month'];
    $consumption = (float)$_POST['consumption_kwh'];

    $sql = "INSERT INTO readings (user_id, year, month, consumption_kwh)
            VALUES (:user_id, :year, :month, :consumption)
            ON DUPLICATE KEY UPDATE consumption_kwh = :consumption_upd, created_at = CURRENT_TIMESTAMP";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':user_id' => $user_id,
        ':year' => $year,
        ':month' => $month,
        ':consumption' => $consumption,
        ':consumption_upd' => $consumption
    ]);

    header('Location: dashboard.php'); // Redirecționăm către dashboard
    exit;
}