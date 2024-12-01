<?php
require 'vendor/autoload.php';
require 'db.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;

// QR kod oluşturma
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_qr'])) {
    $target_url = $_POST['target_url'];
    $qr_code_id = uniqid(); // Benzersiz bir ID oluştur

    // Veritabanına URL ve ID'yi ekle
    $stmt = $pdo->prepare('INSERT INTO qr_codes (qr_code_id, target_url) VALUES (?, ?)');
    $stmt->execute([$qr_code_id, $target_url]);

    // QR kod oluşturma
    $qrCode = new QrCode("http://sanal-album.ademcaniyik.xyz/redirect.php?id=$qr_code_id");
    $qrCode->setSize(300);
    $qrCode->setMargin(10);
    $qrCode->setEncoding(new Encoding('UTF-8'));
    $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::High);

    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    // QR kodunu dosyaya kaydet
    $filePath = 'qr_codes/' . $qr_code_id . '.png';
    file_put_contents($filePath, $result->getString());

    // QR kodu görüntülenebilir hale getirme
    $qr_code_image = $result->getString();
    $qr_code_mime_type = $result->getMimeType();
}

// QR kod bilgilerini ve yönlendirmesini güncelleme
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_qr'])) {
    $qr_code_id = $_POST['qr_code_id'];
    $new_target_url = $_POST['new_target_url'];

    // Veritabanında URL'yi güncelle
    $stmt = $pdo->prepare('UPDATE qr_codes SET target_url = ? WHERE qr_code_id = ?');
    $stmt->execute([$new_target_url, $qr_code_id]);

    $message = 'QR code updated successfully!';
}

// QR kod bilgilerini almak
$qr_code_info = null;
if (isset($_GET['redirect_id'])) {
    $qr_code_id = $_GET['redirect_id'];
    $stmt = $pdo->prepare('SELECT target_url FROM qr_codes WHERE qr_code_id = ?');
    $stmt->execute([$qr_code_id]);
    $qr_code_info = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generator</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { display: flex; }
        .form-container, .info-container { width: 50%; padding: 10px; }
        .form-container { border-right: 1px solid #ddd; }
        .qr-image { max-width: 300px; height: auto; }
        .message { color: green; }
        .qr-list { margin-top: 20px; }
        .qr-item { margin-bottom: 10px; }
        #update-qr-modal { 
            display:none; 
            position:fixed; 
            top:20%; 
            left:20%; 
            width:60%; 
            padding:20px; 
            background:#fff; 
            border:1px solid #ddd; 
            z-index: 1000; 
        }
        #update-qr-modal img { max-width: 150px; height: auto; display: block; margin: 10px 0; }
        .overlay { 
            display:none; 
            position:fixed; 
            top:0; 
            left:0; 
            width:100%; 
            height:100%; 
            background:rgba(0,0,0,0.5); 
            z-index: 999; 
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // QR kodlarını yükle
            function loadQRCodeList() {
                $.ajax({
                    url: 'fetch_qr_codes.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let html = '';
                        data.forEach(function(qr) {
                            html += `<div class="qr-item">
                                <p><strong>ID:</strong> ${qr.qr_code_id}</p>
                                <p><strong>Target URL:</strong> ${qr.target_url}</p>
                                <p><strong>QR Code:</strong> <img src="qr_codes/${qr.qr_code_id}.png" alt="QR Code" class="qr-image"></p>
                                <button onclick="updateQR('${qr.qr_code_id}', '${qr.target_url}')">Update</button>
                                <a href="qr_codes/${qr.qr_code_id}.png" download="${qr.qr_code_id}.png">Download</a>
                            </div>`;
                        });
                        $('#qr-list').html(html);
                    }
                });
            }

            loadQRCodeList();

            // QR kod yönlendirmesini güncelle
            window.updateQR = function(id, url) {
                $('#update-qr-id').val(id);
                $('#update-new-target-url').val(url);
                $('#update-qr-image').attr('src', `qr_codes/${id}.png`);
                $('#update-qr-modal').show();
                $('.overlay').show();
            };

            $('#update-qr-form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'update_qr_code.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                        $('#update-qr-modal').hide();
                        $('.overlay').hide();
                        loadQRCodeList();
                    }
                });
            });

            // Close modal on overlay click
            $('.overlay').click(function() {
                $('#update-qr-modal').hide();
                $(this).hide();
            });
        });
    </script>
</head>
<body>

    <div class="container">
        <!-- QR Kod Oluşturma Formu -->
        <div class="form-container">
            <h2>Create QR Code</h2>
            <form method="POST">
                <label for="target_url">Target URL:</label>
                <input type="text" id="target_url" name="target_url" required>
                <button type="submit" name="create_qr">Generate QR Code</button>
            </form>

            <?php if (isset($qr_code_image)): ?>
                <h3>Generated QR Code</h3>
                <img src="data:<?php echo $qr_code_mime_type; ?>;base64,<?php echo base64_encode($qr_code_image); ?>" class="qr-image" alt="QR Code">
                <br>
                <a href="data:<?php echo $qr_code_mime_type; ?>;base64,<?php echo base64_encode($qr_code_image); ?>" download="qr_code.png">Download QR Code</a>
            <?php endif; ?>
        </div>

        <!-- QR Kod Bilgileri ve Güncelleme -->
        <div class="info-container">
            <h2>QR Code List</h2>
            <div id="qr-list">
                <!-- QR kodları burada listelenecek -->
            </div>
        </div>
    </div>

    <!-- Update QR Modal -->
    <div id="update-qr-modal">
        <h2>Update QR Code</h2>
        <form id="update-qr-form">
            <input type="hidden" id="update-qr-id" name="qr_code_id">
            <label for="update-new-target-url">New Target URL:</label>
            <input type="text" id="update-new-target-url" name="new_target_url" required>
            <img id="update-qr-image" src="" alt="QR Code">
            <button type="submit">Update QR Code</button>
        </form>
        <button onclick="$('#update-qr-modal').hide(); $('.overlay').hide();">Close</button>
    </div>

    <!-- Overlay for Modal -->
    <div class="overlay"></div>

</body>
</html>
