<?php
$koneksi = new mysqli("localhost", "root", "", "pembayaran");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemNames = $_POST['itemName'];
    $itemPrices = $_POST['itemPrice'];
    $itemQtys = $_POST['itemQty'];
    $voucher = $_POST['voucher'];
    $ongkir = $_POST['ongkir'];
    $payment = $_POST['payment'];

    $subtotal = 0;
    $itemNameText = "";
    $itemPriceText = "";
    $itemQtyText = "";

    for ($i = 0; $i < count($itemNames); $i++) {
        $itemNameText .= $itemNames[$i] . ";";
        $itemPriceText .= $itemPrices[$i] . ";";
        $itemQtyText .= $itemQtys[$i] . ";";
        $subtotal += $itemPrices[$i] * $itemQtys[$i];
    }

    $pajak = ($subtotal - $voucher) * 0.11;
    $total = $subtotal - $voucher + $pajak + $ongkir;

    $stmt = $koneksi->prepare("INSERT INTO transaksi (item_name, item_price, item_qty, subtotal, voucher, ongkir, pajak, total, metode_pembayaran) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiiiiis", $itemNameText, $itemPriceText, $itemQtyText, $subtotal, $voucher, $ongkir, $pajak, $total, $payment);

    if ($stmt->execute()) {
        echo "<script>alert('Transaksi berhasil disimpan!'); window.location.href='index.php';</script>";
    } else {
        echo "Gagal menyimpan transaksi: " . $stmt->error;
    }

    $stmt->close();
    $koneksi->close();
}
?>
