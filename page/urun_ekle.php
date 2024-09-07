<?php
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}
// Veritabanına bağlan
// Veritabanı bağlantısını include et
include 'db_connection.php';


// Formdan gelen verileri al
$urun_adi = $_POST['urun_adi'];
$fiyat = $_POST['fiyat'];
$tip = $_POST['tip'];
$resim_yolu = ""; // Bu değeri dosya yükleme işleminden sonra güncelleyeceğiz

// Dosya yükleme işlemi
if(isset($_FILES['resim_yolu'])) {
    $file = $_FILES['resim_yolu'];
    $fileName = $_FILES['resim_yolu']['name'];
    $fileTmpName = $_FILES['resim_yolu']['tmp_name'];
    $fileSize = $_FILES['resim_yolu']['size'];
    $fileError = $_FILES['resim_yolu']['error'];
    $fileType = $_FILES['resim_yolu']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'gif');

    if(in_array($fileActualExt, $allowed)) {
        if($fileError === 0) {
            $fileNameNew = uniqid('', true).".".$fileActualExt;
            $fileDestination = 'uploads/'.$fileNameNew;
            move_uploaded_file($fileTmpName, $fileDestination);
            $resim_yolu = $fileDestination;
        } else {
            echo "Dosya yükleme sırasında bir hata oluştu.";
        }
    } else {
        echo "Bu dosya türüne izin verilmiyor.";
    }
}

// Veritabanına bağlan
// Veritabanı bağlantısını include et
include 'db_connection.php';


// Veritabanına ürünü ekle
$sql = "INSERT INTO urunler (urun_adi, fiyat, tip, resim_yolu)
VALUES ('$urun_adi', '$fiyat', '$tip', '$resim_yolu')";

if ($conn->query($sql) === TRUE) {
    header("Location: admin_panel.php");
} else {
    echo "Ürün eklenirken hata oluştu: " . $conn->error;
}

// Bağlantıyı kapat
$conn->close();
