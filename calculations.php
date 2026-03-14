<?php
// 1. Activăm afișarea erorilor pentru depanare
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db.php';
session_start();

// 2. Verificăm dacă ești logat
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$show_result = false;
$total_kwh = 0;
$cost = 0;
$current_year = date('Y');
$price_input = "";

// 3. Procesarea formularului
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ne asigurăm că prețul este un număr
    $price_input = isset($_POST['price']) ? $_POST['price'] : 0;
    $price = (float)$price_input;
    
    // Interogăm baza de date pentru suma consumului pe anul curent
    $sql = "SELECT SUM(consumption_kwh) as total FROM readings WHERE user_id = ? AND year = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$user_id, $current_year])) {
        $row = $stmt->fetch();
        
        // Dacă există date, le luăm. Dacă e NULL (nu ai date), punem 0.
        $total_kwh = $row['total'] !== null ? (float)$row['total'] : 0;
        
        // Facem calculul
        $cost = $total_kwh * $price;
        $show_result = true;
    } else {
        echo "Eroare la citirea din baza de date.";
    }
}
?>
<!doctype html>
<html lang="ro">
<head>
  <meta charset="utf-8">
  <title>Calculator Costuri</title>
  <link rel="stylesheet" href="css/styles.css?v=2">
  <style>
      .result-box {
          background-color: #e8f5e9;
          border: 1px solid #4caf50;
          padding: 20px;
          margin-top: 20px;
          border-radius: 8px;
          text-align: center;
      }
      .result-value {
          font-size: 1.5em;
          font-weight: bold;
          color: #2e7d32;
      }
      .warning-box {
          background-color: #fff3cd;
          border: 1px solid #ffecb5;
          color: #856404;
          padding: 15px;
          margin-bottom: 20px;
          border-radius: 5px;
      }
  </style>
</head>
<body>
  <div class="container">
    <?php include 'navbar.php'; ?>
    
    <h1>Calculator Costuri (Anul <?= $current_year ?>)</h1>
    
    <?php if ($total_kwh == 0 && !$show_result): ?>
    <div class="warning-box">
        <strong>Notă:</strong> Asigură-te că ai adăugat citiri de consum în pagina "Panou Principal" înainte de a face calcule.
    </div>
    <?php endif; ?>

    <div class="card" style="max-width: 500px; margin: 0 auto;">
        <form method="post" action="">
            <label>Introdu prețul energiei (RON/kWh):</label>
            <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($price_input) ?>" placeholder="Ex: 1.3" required>
            <button type="submit">Calculează Total Anual</button>
        </form>

        <?php if ($show_result): ?>
            <div class="result-box">
                <h3>Rezultate pentru <?= $current_year ?></h3>
                
                <p>Consum Total înregistrat:</p>
                <div class="result-value"><?= number_format($total_kwh, 2) ?> kWh</div>
                
                <hr style="margin: 15px 0; opacity: 0.3;">
                
                <p>Cost Total estimat:</p>
                <div class="result-value"><?= number_format($cost, 2) ?> RON</div>
                
                <?php if($total_kwh == 0): ?>
                    <p style="color: red; font-size: 0.9em; margin-top: 10px;">
                        (Rezultatul este 0 deoarece nu ai introdus încă nicio citire de consum pe anul acesta.)
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
  </div>
</body>
</html>