<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
?>
<!doctype html>
<html lang="ro">
<head>
  <meta charset="utf-8">
  <title>Grafic Consum</title>
  <link rel="stylesheet" href="css/styles.css?v=2">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <div class="container">
    <?php include 'navbar.php'; ?>
    <h1>Evoluție Grafică</h1>
    <div class="card">
        <canvas id="consumptionChart"></canvas>
    </div>
  </div>
  <script src="js/script.js"></script>
</body>
</html>