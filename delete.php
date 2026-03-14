<?php
require 'db.php';
session_start();
if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    // Ștergem doar dacă aparține userului logat!
    $stmt = $pdo->prepare("DELETE FROM readings WHERE id = ? AND user_id = ?");
    $stmt->execute([(int)$_GET['id'], $_SESSION['user_id']]);
}
header('Location: dashboard.php');