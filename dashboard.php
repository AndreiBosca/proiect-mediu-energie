<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }

$user_id = $_SESSION['user_id'];
// Citim datele doar pentru userul logat
$stmt = $pdo->prepare("SELECT * FROM readings WHERE user_id = ? ORDER BY year DESC, month DESC");
$stmt->execute([$user_id]);
$readings = $stmt->fetchAll();
?>
<!doctype html>
<html lang="ro">
<head>
  <meta charset="utf-8">
  <title>Dashboard Energie</title>
  <link rel="stylesheet" href="css/styles.css?v=2">
</head>
<body>
  <div class="container">
    <?php include 'navbar.php'; ?>
    
    <h1>Istoric Consum</h1>

    <div class="content-grid">
        <div class="card">
            <h3>Adaugă Consum</h3>
            <form action="add.php" method="post">
                <label>An: <input type="number" name="year" value="<?=date('Y')?>" required></label>
                <label>Luna: <input type="number" name="month" min="1" max="12" required></label>
                <label>Consum (kWh): <input type="number" step="0.01" name="consumption_kwh" required></label>
                <button type="submit">Salvează</button>
            </form>
        </div>

        <div class="card">
            <h3>Înregistrările Tale</h3>
            <table>
                <thead>
                <tr><th>An</th><th>Lună</th><th>Consum (kWh)</th><th>Acțiuni</th></tr>
                </thead>
                <tbody>
                <?php foreach($readings as $r): ?>
                    <tr>
                    <td><?=htmlspecialchars($r['year'])?></td>
                    <td><?=htmlspecialchars($r['month'])?></td>
                    <td><strong><?=htmlspecialchars($r['consumption_kwh'])?></strong></td>
                    <td>
                        <a href="delete.php?id=<?= $r['id'] ?>" style="color:red;" onclick="return confirm('Ștergi?')">Șterge</a>
                    </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
  </div>
</body>
</html>