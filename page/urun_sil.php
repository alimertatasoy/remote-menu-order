<?php
// Veritabanı bağlantısını include et
include 'db_connection.php';


// Silinecek ürünün id'sini al
$urun_id = $_POST['urun_id'];

// Veritabanından ürünü sil
$sql = "DELETE FROM urunler WHERE id = $urun_id";

if ($conn->query($sql) === TRUE) {
    header("Location: admin_panel.php");
} else {
    echo "Ürün silinirken hata oluştu: " . $conn->error;
}

// Bağlantıyı kapat
$conn->close();
?>
