<?php
// Veritabanına bağlan
// Veritabanı bağlantısını include et
include 'db_connection.php';


// POST yöntemiyle gelen kullanıcı adı ve şifreyi al
$username = $_POST['username'];
$password = $_POST['password'];

// Kullanıcı adının benzersiz olduğunu kontrol etmek için veritabanında bir sorgu yap
$sql_check_username = "SELECT * FROM admin WHERE username='$username'";
$result_check_username = $conn->query($sql_check_username);

// Kullanıcı adının benzersiz olduğunu kontrol et
if ($result_check_username->num_rows > 0) {
    echo "Bu kullanıcı adı zaten kullanımda.";
} else {
    // Kullanıcı adı benzersizse, yeni kullanıcıyı eklemek için sorgu oluştur
    $sql_add_user = "INSERT INTO admin (username, password) VALUES ('$username', '$password')";

    // Kullanıcıyı eklemeyi dene
    if ($conn->query($sql_add_user) === TRUE) {
        echo "Yeni kullanıcı başarıyla eklendi.";
        header("Location: admin_panel.php");
    } else {
        echo "Kullanıcı eklenirken hata oluştu: " . $conn->error;
    }
}

// Bağlantıyı kapat
$conn->close();
?>
