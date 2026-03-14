<?php
require 'db.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) { echo json_encode([]); exit; }

$stmt = $pdo->prepare("SELECT year, month, consumption_kwh FROM readings WHERE user_id = ? ORDER BY year DESC, month DESC LIMIT 12");
$stmt->execute([$_SESSION['user_id']]);
$rows = array_reverse($stmt->fetchAll());

$labels = []; $data = [];
foreach ($rows as $r) {
    $labels[] = $r['year']."-".$r['month'];
    $data[] = (float)$r['consumption_kwh'];
}
echo json_encode(['labels'=>$labels, 'data'=>$data]);