<?php
require 'db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM readings WHERE id = ?");
    $stmt->execute([$id]);
    $r = $stmt->fetch();
    if (!$r) { echo "Inregistrare inexistenta."; exit; }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $year = (int)$_POST['year'];
    $month = (int)$_POST['month'];
    $consumption = (float)$_POST['consumption_kwh'];
    $stmt = $pdo->prepare("UPDATE readings SET year=?, month=?, consumption_kwh=? WHERE id=?");
    $stmt->execute([$year, $month, $consumption, $id]);
    header('Location: index.php'); exit;
} else {
    header('Location: index.php'); exit;
}
?>
<!doctype html>
<html lang="ro">
<head>
  <meta charset="utf-8">
  <title>Editează</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <div class="container">
    <h1>Editează înregistrare</h1>
    <form method="post" action="edit.php">
      <input type="hidden" name="id" value="<?=htmlspecialchars($r['id'])?>">
      <label>An: <input type="number" name="year" value="<?=htmlspecialchars($r['year'])?>" required></label>
      <label>Luna: <input type="number" name="month" value="<?=htmlspecialchars($r['month'])?>" required></label>
      <label>Consum (kWh): <input type="number" step="0.01" name="consumption_kwh" value="<?=htmlspecialchars($r['consumption_kwh'])?>" required></label>
      <button type="submit">Salvează</button>
    </form>
    <p><a href="index.php">Înapoi</a></p>
  </div>
</body>
</html>
