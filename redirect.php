<?php
require 'db.php';

$qr_code_id = $_GET['id'] ?? '';

if (empty($qr_code_id)) {
    echo 'ID parameter is missing!';
    exit();
}

$stmt = $pdo->prepare('SELECT target_url FROM qr_codes WHERE qr_code_id = ?');
$stmt->execute([$qr_code_id]);
$qr_code = $stmt->fetch();

if ($qr_code) {
    $target_url = $qr_code['target_url'];

    // URL'nin başında http:// veya https:// olup olmadığını kontrol et
    if (!preg_match('/^https?:\/\//', $target_url)) {
        // Eğer yoksa, varsayılan olarak http:// ekle
        $target_url = 'http://' . $target_url;
    }

    header('Location: ' . $target_url);
    exit();
} else {
    echo 'QR code not found!';
}
?>
