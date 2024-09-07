<?php
// Veritabanı bağlantısını include et
include 'db_connection.php';


// POST yöntemiyle gelen kullanıcı ID'sini al
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Kullanıcıyı sil
    $sql = "DELETE FROM admin WHERE id = $user_id";

    if ($conn->query($sql) === TRUE) {
        // Kullanıcı başarıyla silindiğinde ana sayfaya yönlendir
        header("Location: admin_panel.php");
        exit();
    } else {
        echo "Kullanıcı silinirken hata oluştu: " . $conn->error;
    }
}

// Bağlantıyı kapat
$conn->close();
?>
