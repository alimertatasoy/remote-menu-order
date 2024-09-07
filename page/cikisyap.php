<?php
// Oturumu başlat
session_start();

// Tüm oturum verilerini yok et
session_destroy();

// Giriş sayfasına yönlendir
header("Location: admin.php");
exit();
?>
