<?php
// POST isteğini kontrol et
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // POST verilerini al
    $data = json_decode(file_get_contents("php://input"), true);

    // Veritabanına bağlan
    include 'db_connection.php';

    // Siparişleri veritabanına ekle
    foreach ($data["orders"] as $order) {
        $productName = $order["productName"];
        $quantity = $order["quantity"];
        $table = $data["table"]; // Masayı al

        $sql = "INSERT INTO siparisler (urun_adi, miktar, masa) VALUES ('$productName', $quantity, $table)";
        if ($conn->query($sql) !== TRUE) {
            echo "Sipariş eklenirken bir hata oluştu: " . $conn->error;
        }
    }

    // Bağlantıyı kapat
    $conn->close();

    // Başarılı mesajı döndür
    echo "Siparişler başarıyla alındı.";
} else {
    // POST isteği yoksa hata mesajı döndür
    echo "Geçersiz istek.";
}
?>
