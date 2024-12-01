<?php
require 'vendor/autoload.php';
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qr_code_id']) && isset($_POST['new_target_url'])) {
    $qr_code_id = $_POST['qr_code_id'];
    $new_target_url = $_POST['new_target_url'];

    // Veritabanında URL'yi güncelle
    $stmt = $pdo->prepare('UPDATE qr_codes SET target_url = ? WHERE qr_code_id = ?');
    $stmt->execute([$new_target_url, $qr_code_id]);

    echo 'QR code updated successfully!';
} else {
    echo 'Invalid request!';
}
