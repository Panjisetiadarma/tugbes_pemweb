<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function showMethods(method) {
            document.getElementById("otherMethods").style.display = (method === 'other') ? 'block' : 'none';
            document.getElementById("bankMethods").style.display = (method === 'bank') ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Metode Pembayaran</h2>
        <div class="payment-methods">
            <button type="button" onclick="showMethods('bank')">Transfer Bank</button>
            <button type="button" onclick="showMethods('other')">Metode Lainnya</button>
        </div>

        <form method="POST" action="">
            <div id="otherMethods" style="display: none;">
                <h3>Pilih Metode Pembayaran</h3>
                <label><input type="radio" name="payment" value="QRIS"> QRIS</label><br>
                <label><input type="radio" name="payment" value="DANA"> DANA</label><br>
            </div>

            <div id="bankMethods" style="display: none;">
                <h3>Pilih Bank</h3>
                <label><input type="radio" name="payment" value="BCA"> Bank BCA</label><br>
                <label><input type="radio" name="payment" value="Mandiri"> Bank Mandiri</label><br>
                <label><input type="radio" name="payment" value="BNI"> Bank BNI</label><br>
                <label><input type="radio" name="payment" value="BRI"> Bank BRI</label><br>
            </div>

            <br>
            <button type="submit" name="submit">Bayar</button>
        </form>

        <p class="note">Pembayaran bisa dilakukan menggunakan metode QRIS, DANA, atau transfer bank.</p>

        <?php
        if (isset($_POST['submit'])) {
            if (isset($_POST['payment'])) {
                $metode = $_POST['payment'];
                $stmt = $conn->prepare("INSERT INTO pembayaran (metode) VALUES (?)");
                $stmt->bind_param("s", $metode);
                if ($stmt->execute()) {
                    echo "<p style='color:green;'>Metode pembayaran <strong>$metode</strong> berhasil disimpan.</p>";
                } else {
                    echo "<p style='color:red;'>Gagal menyimpan metode pembayaran.</p>";
                }
                $stmt->close();
            } else {
                echo "<p style='color:red;'>Silakan pilih metode pembayaran terlebih dahulu.</p>";
            }
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
