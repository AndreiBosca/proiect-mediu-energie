<?php
require 'db.php';

// pentru demo folosim user_id = 1
$user_id = 1;

// citim ultimele intrări (sorted)
$stmt = $pdo->prepare("SELECT * FROM readings WHERE user_id = ? ORDER BY year DESC, month DESC");
$stmt->execute([$user_id]);
$readings = $stmt->fetchAll();
?>
<!doctype html>
<html lang="ro">
<head>
  <meta charset="utf-8">
  <title>Monitorizare consum energie</title>
  <link rel="stylesheet" href="css/styles.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <div class="container">
    <h1>Monitorizare consum energie</h1>

    <section class="form-section">
      <h2>Adaugă / actualizează consum</h2>
      <form id="addForm" method="post" action="add.php">
        <input type="hidden" name="user_id" value="<?=htmlspecialchars($user_id)?>">
        <label>An: <input type="number" name="year" min="2000" max="2100" required></label>
        <label>Luna: <input type="number" name="month" min="1" max="12" required></label>
        <label>Consum (kWh): <input type="number" step="0.01" name="consumption_kwh" required></label>
        <button type="submit">Salvează</button>
      </form>
    </section>

    <section class="table-section">
      <h2>Înregistrări</h2>
      <table>
        <thead>
          <tr><th>An</th><th>Lună</th><th>Consum kWh</th><th>Acțiuni</th></tr>
        </thead>
        <tbody>
          <?php foreach($readings as $r): ?>
            <tr>
              <td><?=htmlspecialchars($r['year'])?></td>
              <td><?=htmlspecialchars($r['month'])?></td>
              <td><?=htmlspecialchars($r['consumption_kwh'])?></td>
              <td>
                <a href="edit.php?id=<?= $r['id'] ?>">Editează</a> |
                <a href="delete.php?id=<?= $r['id'] ?>" onclick="return confirm('Ștergi?')">Șterge</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>

    <section class="chart-section">
      <h2>Grafic consum (ultime 12 înregistrări)</h2>
      <canvas id="consumptionChart" width="800" height="300"></canvas>
    </section>
  </div>

  <script src="js/script.js"></script>
</body>
</html>
