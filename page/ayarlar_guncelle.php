<?php
session_start();
include 'db_connection.php';

// Oturumu kontrol et
if (!isset($_SESSION['username'])) {
    header("Location: admin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dosyaların yükleme işlemleri
    $uploadDirectory = "uploads/";
    $site_arkaurl = $uploadDirectory . basename($_FILES["site_arkaurl"]["name"]);
    $site_logourl = $uploadDirectory . basename($_FILES["site_logourl"]["name"]);

    // Dosyaları sunucuya yükle
    if (move_uploaded_file($_FILES["site_arkaurl"]["tmp_name"], $site_arkaurl) && move_uploaded_file($_FILES["site_logourl"]["tmp_name"], $site_logourl)) {
        // Dosyalar başarılı bir şekilde yüklendiğinde diğer verileri al
        $site_ismi = $_POST['site_ismi'];
        $footer_metni = $_POST['footer_metni'];
        $masa_sayisi = $_POST['masa_sayisi'];

        // Veritabanına güncelleme sorgusu
        $sql = "UPDATE sitebilgi SET siteismi = ?, sitearkaurl = ?, sitelogourl = ?, footer = ?, masasayisi = ? WHERE id = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $site_ismi, $site_arkaurl, $site_logourl, $footer_metni, $masa_sayisi);

        if ($stmt->execute()) {
            header("Location: admin_panel.php");
        } else {
            echo "Ayarları güncellerken bir hata oluştu: " . $stmt->error;
        }
    } else {
        echo "Dosya yükleme işlemi başarısız oldu.";
    }
}

// Bağlantıyı kapat
$conn->close();
?>
