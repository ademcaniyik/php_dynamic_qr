<?php
require 'db.php';

// Veritabanından QR kod bilgilerini al
$stmt = $pdo->query('SELECT qr_code_id, target_url FROM qr_codes');
$qr_codes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// QR kodlarını JSON formatında döndür
header('Content-Type: application/json');
echo json_encode($qr_codes);
?>
