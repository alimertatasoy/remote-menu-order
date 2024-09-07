<?php
include 'db_connection.php';

$sql = "SELECT * FROM sitebilgi WHERE id = 1"; // Örnek olarak id = 1'i kullanıyorum, tablonuza göre güncelleyin
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $siteTitle = $row["siteismi"];
    $siteBackgroundURL = $row["sitearkaurl"];
    $siteLogoURL = $row["sitelogourl"];
    $footerText = $row["footer"];
    $tableCount = $row["masasayisi"]; // Masa sayısını al
} else {
    $siteTitle = "Site Başlığı";
    $siteBackgroundURL = "/varsayılan/arkaplan.jpg";
    $siteLogoURL = "/varsayılan/logo.png";
    $footerText = "&copy; 2024 Akıllı Menü Sistemi. Tüm hakları saklıdır.";
    $tableCount = 3; // Varsayılan masa sayısı
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $siteTitle; ?></title>
    <style>
        body {
            background-image: url('<?php echo 'page/' .$siteBackgroundURL; ?>');
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
    <link rel="stylesheet" href="style/main.css">
</head>

<body>
    <div class="sepet">
        <img src="img/sepet.png" alt="Sepet">
    </div>
    <header class="box">
        <img src="<?php echo 'page/' . $siteLogoURL; ?>" alt="Site Logo">

        <h1><?php echo $siteTitle; ?></h1>
    </header>
    <hr>

    <center>
        <label for="table-select">Masa Seçin:</label>
        <select id="table-select">
            <option value="" selected disabled hidden>Seçiniz</option>
            <?php
            // Masa seçeneklerini oluştur
            for ($i = 1; $i <= $tableCount; $i++) {
                echo '<option value="' . $i . '">Masa ' . $i . '</option>';
            }
            ?>
        </select>
    </center>

    <div class="button-container">
        <button class="button" onclick="showCategory('yemek')">Yemekler</button>
        <button class="button" onclick="showCategory('içecek')">İçecekler</button>
        <button class="button" onclick="showCategory('tatlı')">Tatlılar</button>
    </div>
    <main class="box">
        <?php
        include 'db_connection.php';

        $sql = "SELECT urun_adi, fiyat, resim_yolu, tip FROM urunler";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card ' . $row["tip"] . '">';
                echo '<img src="page/' . $row["resim_yolu"] . '" alt="' . $row["urun_adi"] . '" style="width: 100%; height: auto;">';
                echo '<hr>';
                echo '<div class="product-title">' . $row["urun_adi"] . '</div>';
                echo '<div class="price">' . $row["fiyat"] . ' TL</div>';
                echo '<div class="quantity-container">';
                echo '<button class="quantity-button" onclick="decreaseQuantity(this)">-</button>';
                echo '<span class="quantity">0</span>';
                echo '<button class="quantity-button" onclick="increaseQuantity(this)">+</button>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "Ürün bulunamadı.";
        }
        $conn->close();
        ?>
    </main>
    <hr>
    <footer class="box copyright">
        <?php echo $footerText; ?>
    </footer>
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <h2>Sepetinizdeki Siparişler</h2>
            <ul id="order-list"></ul>
            <button id="send-order-button" onclick="sendOrder()">Siparişi Gönder</button>
        </div>
    </div>
    <script>
        function showCategory(category) {
            var cards = document.querySelectorAll('.card');
            cards.forEach(function (card) {
                if (card.classList.contains(category)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        window.onload = function () {
            showCategory('yemek');
        }

        function increaseQuantity(button) {
            var quantityElement = button.parentNode.querySelector('.quantity');
            var quantity = parseInt(quantityElement.textContent);
            quantityElement.textContent = quantity + 1;
        }

        function decreaseQuantity(button) {
            var quantityElement = button.parentNode.querySelector('.quantity');
            var quantity = parseInt(quantityElement.textContent);
            if (quantity > 0) {
                quantityElement.textContent = quantity - 1;
            }
        }

        function openPopup() {
            document.getElementById("popup").style.display = "block";
            displayOrders();
        }

        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }

        function displayOrders() {
            var orders = document.querySelectorAll('.card');
            var orderList = document.getElementById('order-list');
            orderList.innerHTML = ''; // Clear previous content
            var hasItems = false; // Başlangıçta sepette hiçbir şey olmadığını varsayalım
            orders.forEach(function (order) {
                var productName = order.querySelector('.product-title').textContent;
                var quantity = parseInt(order.querySelector('.quantity').textContent);
                if (quantity > 0) {
                    hasItems = true; // Sepette en az bir ürün varsa hasItems'i true yap
                    var listItem = document.createElement('li');
                    listItem.textContent = quantity + " adet " + productName;
                    var deleteButton = document.createElement('button');
                    deleteButton.textContent = "Sil";
                    deleteButton.onclick = function () {
                        order.querySelector('.quantity').textContent = '0'; // Set quantity to 0
                        displayOrders(); // Refresh the order list
                    };
                    listItem.appendChild(deleteButton);
                    orderList.appendChild(listItem);
                }
            });
            // Sepette hiçbir şey yoksa "Siparişi Gönder" butonunu gizle
            var sendOrderButton = document.getElementById('send-order-button');
            if (hasItems) {
                sendOrderButton.style.display = 'block';
            } else {
                sendOrderButton.style.display = 'none';
            }
        }

        document.querySelector('.sepet').addEventListener('click', openPopup);

        function sendOrder() {
            var selectedTable = document.getElementById('table-select').value; // Seçilen masa değerini al

            if (!selectedTable) {
                alert("Lütfen bir masa seçin.");
                return; // Masa seçilmediyse işlemi sonlandır
            }

            var orders = [];
            var cards = document.querySelectorAll('.card');
            cards.forEach(function (card) {
                var productName = card.querySelector('.product-title').textContent;
                var quantity = parseInt(card.querySelector('.quantity').textContent);
                if (quantity > 0) {
                    orders.push({ productName: productName, quantity: quantity });
                }
            });

            // JSON formatına dönüştürülen siparişleri bir POST isteğiyle gönder
            fetch('process_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ orders: orders, table: selectedTable }), // Masayı da POST verisine ekleyin
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Sipariş gönderilirken bir hata oluştu. Status: ' + response.status);
                    }
                    return response.text();
                })
                .then(data => {
                    alert(data);
                    displayOrders(); // Sipariş alındıktan sonra sipariş listesini güncelleyin
                    openPopup(); // Popup'ı açın ve sipariş listesini gösterin
                })
                .catch(error => {
                    console.error('Hata:', error);
                    alert('Sipariş gönderilirken bir hata oluştu. Lütfen tekrar deneyin.');
                });
        }

        function displayOrders() {
            var orders = document.querySelectorAll('.card');
            var orderList = document.getElementById('order-list');
            orderList.innerHTML = ''; // Önceki içeriği temizleyin
            var totalAmount = 0; // Toplam tutarı saklamak için değişken

            var hasItems = false; // Başlangıçta sepette hiçbir şey olmadığını varsayalım
            orders.forEach(function (order) {
                var productName = order.querySelector('.product-title').textContent;
                var quantity = parseInt(order.querySelector('.quantity').textContent);
                var pricePerItem = parseFloat(order.querySelector('.price').textContent); // Ürün başına fiyatı al
                var subtotal = pricePerItem * quantity; // Toplam tutarı hesapla
                totalAmount += subtotal; // Toplam tutarı güncelle

                if (quantity > 0) {
                    hasItems = true; // Sepette en az bir ürün varsa hasItems'i true yap
                    var listItem = document.createElement('li');
                    listItem.textContent = quantity + " adet " + productName + " - Toplam: " + subtotal.toFixed(2) + " TL"; // Toplamı listeye ekleyin
                    var deleteButton = document.createElement('button');
                    deleteButton.textContent = "Sil";
                    deleteButton.onclick = function () {
                        order.querySelector('.quantity').textContent = '0'; // Siparişi sil
                        displayOrders(); // Sipariş listesini güncelle
                    };
                    listItem.appendChild(deleteButton);
                    orderList.appendChild(listItem);
                }
            });

            // Toplam tutarı gösteren bir liste öğesi oluşturun
            var totalListItem = document.createElement('li');
            totalListItem.textContent = "Toplam Tutar: " + totalAmount.toFixed(2) + " TL";
            orderList.appendChild(totalListItem);

            // Sepette hiçbir şey yoksa "Siparişi Gönder" butonunu gizle
            var sendOrderButton = document.getElementById('send-order-button');
            if (hasItems) {
                sendOrderButton.style.display = 'block';
            } else {
                sendOrderButton.style.display = 'none';
            }
        }

    </script>


</body>

</html>