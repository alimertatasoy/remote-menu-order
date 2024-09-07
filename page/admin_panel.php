<?php
session_start();
// Değişkenleri tanımla
$site_ismi = '';
$site_arkaurl = '';
$site_logourl = '';
$footer_metni = '';
$masa_sayisi = '';
// Oturumu kontrol et
if (!isset($_SESSION['username'])) {
    // Kullanıcı girişi yapılmamışsa giriş sayfasına yönlendir
    header("Location: admin.php");
    exit();
}
?>

<?php
// Veritabanı bağlantısını include et
include 'db_connection.php';

$sql = "SELECT * FROM sitebilgi WHERE id = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $site_ismi = $row["siteismi"];
    $site_arkaurl = $row["sitearkaurl"];
    $site_logourl = $row["sitelogourl"];
    $footer_metni = $row["footer"];
    $masa_sayisi = $row["masasayisi"];
} else {
    // Varsayılan değerler kullanılabilir veya hata mesajı gösterilebilir
    // Örneğin:
    echo "Site ve masa ayarları bulunamadı.";
}



// Sipariş verildiğinde işle
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verildi_mi'])) {
    $verildi_mi = $_POST['verildi_mi'];
    $siparis_id = $_POST['siparis_id'];

    $sql = "UPDATE siparisler SET verildi_mi = '$verildi_mi' WHERE id = '$siparis_id'";

    if ($conn->query($sql) !== TRUE) {
        echo "Sipariş durumu güncellenirken hata oluştu: " . $conn->error;
    }
}

// Sıralama ve arama parametrelerini al
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'tarih'; // Sıralama özelliği (varsayılan: tarih)
$search = isset($_GET['search']) ? $_GET['search'] : ''; // Arama kelimesi

// Siparişleri veritabanından al
$sql = "SELECT s.id, s.urun_adi, SUM(s.miktar) as toplam_miktar, s.masa, s.tarih, MAX(s.verildi_mi) as verildi_mi 
FROM siparisler s
INNER JOIN (
    SELECT masa, urun_adi, MAX(tarih) as max_tarih
    FROM siparisler
    WHERE urun_adi LIKE '%$search%' OR masa LIKE '%$search%'
    GROUP BY masa, urun_adi
) m ON s.masa = m.masa AND s.urun_adi = m.urun_adi AND s.tarih = m.max_tarih
GROUP BY s.id, s.urun_adi, s.masa, s.tarih
ORDER BY $order_by DESC

";
$result = $conn->query($sql);

// Bağlantıyı kapat
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-ZpJxFUJkIRb9HLnXoRcC6F4rWQIwYVKXg+u/y9RYWnsYRvdopW3/umQpMxcsWOPW3k0ZDX+3DQ4zcqJrL0eH5A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #333;
            overflow-y: auto;
            padding-top: 20px;
        }

        .sidebar img {
            margin-top: 10px;
            margin-bottom: 50px;
        }

        .sidebar a {
            padding: 10px;
            text-decoration: none;
            font-size: 18px;
            color: #ccc;
            display: block;
            transition: all 0.3s ease;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar a:hover {
            background-color: #555;
            color: #fff;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .content h2 {
            color: #333;
        }

        .content p {
            color: #666;
        }

        @media screen and (max-height: 450px) {
            .sidebar {
                padding-top: 15px;
            }

            .sidebar a {
                font-size: 14px;
            }
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 40px;
        }

        .company-info {
            padding: 10px;
            background-color: #444;
            color: #fff;
            text-align: center;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            cursor: pointer;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        input[type=text] {
            width: calc(100% - 20px);
            padding: 8px;
            margin: 8px 0;
            box-sizing: border-box;
        }

        button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin: 10px 5px;
        }

        button:hover {
            background-color: #45a049;
        }

        .cont {
            display: flex;
            justify-content: space-between;
        }

        form {
            display: flex;
            margin-bottom: 20px;
            align-items: center;
            justify-content: space-evenly;
            flex-wrap: wrap;
        }

        input {
            width: 50%;
            /* Genişlik yüzde cinsinden belirtildi */
            font-size: 15px;
            /* Font boyutu piksel cinsinden belirtildi */
        }

        .delete-button {
            background-color: #f44336;
        }

        .delete-button:hover {
            background-color: #d32f2f;
        }

        /* Tablo stilleri */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Form stilleri */
        form {
            margin-top: 20px;
        }

        form div {
            margin-bottom: 10px;
        }

        form label {
            display: block;
            font-weight: bold;
        }

        form input[type="text"],
        form input[type="number"],
        form select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        form input[type="file"] {
            width: calc(100% - 70px);
        }

        form input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        form input[type="submit"] {
            padding: 12px 24px;
            /* Örnek olarak boyutları artırabilirsiniz */
            font-size: 16px;
            width: 100%;
            /* Örnek olarak font boyutunu artırabilirsiniz */
        }

        /* Sil butonu */
        .delete-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            border-radius: 4px;
        }

        .delete-button:hover {
            background-color: #df3727;
        }
        div #settingsContent{
            display: block;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Yönetici Paneli</h1>
    </div>

    <div class="sidebar">
        <center>
            <img src="..\img\ATASOY.png" alt="" width="200">
        </center>
        <a href="#" data-target="productsContent"><i class="fas fa-box"></i> Siparişler</a>
        <a href="#" data-target="ordersContent"><i class="fas fa-shopping-cart"></i> Ürünler</a>
        <a href="#" data-target="usersContent"><i class="fas fa-users"></i> Kullanıcılar</a>
        <a href="#" data-target="settingsContent"><i class="fas fa-cog"></i> Site ve Masa Ayarları</a>
        <a href="#" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</a>
        <div class="company-info">
            <p>Mr.ATASOY</p>
            <p>Aksaray/Merkez</p>
            <p>+90 542 269 70 93</p>
        </div>
    </div>

    <div class="content">
    <div id="settingsContent" style="display:none;">
        <h2>Site ve Masa Ayarları</h2>
        <form method="POST" action="ayarlar_guncelle.php" enctype="multipart/form-data">
            <div style="margin-bottom: 10px;">
                <label for="site_ismi">Site İsmi:</label>
                <input type="text" id="site_ismi" name="site_ismi" value="<?php echo $site_ismi; ?>" required>
            </div>
            <div style="margin-bottom: 10px;">
                <label for="site_arkaurl">Site Arka Plan Resmi Seç:</label>
                <input type="file" id="site_arkaurl" name="site_arkaurl" accept="image/*" required>
            </div>
            <div style="margin-bottom: 10px;">
                <label for="site_logourl">Site Logo Resmi Seç:</label>
                <input type="file" id="site_logourl" name="site_logourl" accept="image/*" required>
            </div>
            <div style="margin-bottom: 10px;">
                <label for="footer_metni">Footer Metni:</label>
                <textarea id="footer_metni" name="footer_metni" rows="4" required><?php echo $footer_metni; ?></textarea>
            </div>
            <div style="margin-bottom: 10px;">
                <label for="masa_sayisi">Masa Sayısı:</label>
                <input type="number" id="masa_sayisi" name="masa_sayisi" value="<?php echo $masa_sayisi; ?>" required>
            </div>
            <div>
                <input type="submit" value="Ayarları Güncelle">
            </div>
        </form>
    </div>



        <div id="productsContent" style="display:none;">
            <div class="cont">
                <form method="GET">
                    <input type="text" name="search" placeholder="Ürün veya Masa Ara" value="<?php echo $search; ?>">
                    <button type="submit">Ara</button>
                </form>
            </div>

            <table>
                <tr>
                    <th onclick="window.location.href='?order_by=urun_adi'">Ürün Adı</th>
                    <th onclick="window.location.href='?order_by=toplam_miktar'">Miktar</th>
                    <th onclick="window.location.href='?order_by=masa'">Masa</th>
                    <th onclick="window.location.href='?order_by=tarih'">Tarih</th>
                    <th>Verildi mi?</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    // Her bir sipariş için bir satır oluştur
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["urun_adi"] . "</td>";
                        echo "<td>" . $row["toplam_miktar"] . "</td>";
                        echo "<td>" . $row["masa"] . "</td>";
                        echo "<td>" . $row["tarih"] . "</td>";
                        echo "<td>";
                        echo "<form method='POST'>";
                        echo "<input type='hidden' name='siparis_id' value='" . $row["id"] . "'>";
                        echo "<input type='checkbox' name='verildi_mi' value='1' " . ($row["verildi_mi"] ? "checked" : "") . " onchange='this.form.submit()'>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Henüz sipariş yok.</td></tr>";
                }
                ?>
            </table>

        </div>
        <div id="ordersContent" style="display:none;">
            <?php
            // Veritabanı bağlantısını include et
            include 'db_connection.php';


            // Ürünleri veritabanından al
            $sql = "SELECT * FROM urunler";
            $result = $conn->query($sql);

            // Bağlantıyı kapat
            $conn->close();
            ?>
            <h2>Ürünleri Düzenle</h2>
            <form method="POST" action="urun_ekle.php" enctype="multipart/form-data">
                <div style="margin-bottom: 10px;">
                    <label for="urun_adi">Ürün Adı:</label>
                    <input type="text" id="urun_adi" name="urun_adi" required>
                </div>
                <div style="margin-bottom: 10px;">
                    <label for="fiyat">Fiyat:</label>
                    <input type="number" id="fiyat" name="fiyat" required>
                </div>
                <div style="margin-bottom: 10px;">
                    <label for="tip">Ürün Tipi:</label>
                    <select id="tip" name="tip">
                        <option value="yemek">Yemek</option>
                        <option value="içecek">İçecek</option>
                        <option value="tatlı">Tatlı</option>
                    </select>
                </div>
                <div style="margin-bottom: 10px;">
                    <label for="resim_yolu">Resim Yolu:</label>
                    <input type="file" id="resim_yolu" name="resim_yolu" accept="image/*" required>
                </div>
                <div>
                    <input type="submit" value="Ürün Ekle">
                </div>
            </form>

            <table>
                <tr>
                    <th>Ürün Adı</th>
                    <th>Fiyat</th>
                    <th>Tip</th>
                    <th>Resim</th>
                    <th>İşlem</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["urun_adi"] . "</td>";
                        echo "<td>" . $row["fiyat"] . "</td>";
                        echo "<td>" . $row["tip"] . "</td>";
                        echo "<td><img src='" . $row["resim_yolu"] . "' alt='" . $row["urun_adi"] . "' style='max-width: 100px;'></td>";
                        echo "<td><form method='POST' action='urun_sil.php'><input type='hidden' name='urun_id' value='" . $row["id"] . "'><input class='delete-button' type='submit' value='Sil'></form></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Henüz ürün yok.</td></tr>";
                }
                ?>
            </table>
        </div>
        <div id="usersContent" style="display:none;">
            <h2>Kullanıcılar</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Kullanıcı Adı</th>
                    <th>İşlem</th>
                </tr>
                <?php
                // Veritabanına bağlan
                // Veritabanı bağlantısını include et
                include 'db_connection.php';


                // Kullanıcıları veritabanından al
                $sql = "SELECT * FROM admin";
                $result = $conn->query($sql);

                // Bağlantıyı kapat
                $conn->close();

                // Kullanıcıları tabloya ekle
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["username"] . "</td>";
                        echo "<td><form method='POST' action='kullanici_sil.php'><input type='hidden' name='user_id' value='" . $row["id"] . "'><input class='delete-button' type='submit' value='Sil'></form></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Kullanıcı bulunamadı.</td></tr>";
                }
                ?>
            </table>

            <h2>Kullanıcı Ekle</h2>
            <form method="POST" action="kullanici_ekle.php">
                <div style="margin-bottom: 10px;">
                    <label for="username">Kullanıcı Adı:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div style="margin-bottom: 10px;">
                    <label for="password">Şifre:</label>
                    <input type="password" id="password" name="password" required style="padding: 8px;">
                </div>
                <div>
                    <input type="submit" value="Kullanıcı Ekle">
                </div>
            </form>
        </div>

    </div>

    <script>
        // Başlangıçta ana sayfa içeriğini göster
        document.getElementById('productsContent').style.display = 'block';

        // Menü bağlantılarına tıklama olaylarını dinleyen bir JavaScript kodu
        document.querySelectorAll('.sidebar a').forEach(function (item) {
            item.addEventListener('click', function (event) {
                event.preventDefault(); // Bağlantıya tıklanınca sayfanın yeniden yüklenmesini engeller
                var targetContent = document.getElementById(this.getAttribute('data-target'));
                document.querySelectorAll('.content > div').forEach(function (content) {
                    content.style.display = 'none'; // Tüm içerikleri gizler
                });
                targetContent.style.display = 'block'; // Hedef içeriği gösterir
            });
        });


        // Çıkış yap butonuna tıklama olayı
        document.getElementById('logoutBtn').addEventListener('click', function (event) {
            event.preventDefault();
            // Oturumu sonlandır ve giriş sayfasına yönlendir
            window.location.href = 'cikisyap.php';
        });
    </script>

</body>

</html>