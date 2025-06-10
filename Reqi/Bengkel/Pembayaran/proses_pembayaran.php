<?php
include 'koneksi.php';

// Ambil data dari form
$voucher = $_POST['voucher'] ?? 0;
$ongkir = $_POST['ongkir'] ?? 0;
$payment_method = $_POST['payment'] ?? '';
$quantities = $_POST['itemQty'] ?? [];

// Update jumlah item di keranjang
foreach($quantities as $id => $qty) {
    $stmt = $conn->prepare("UPDATE keranjang SET jumlah = ? WHERE id = ?");
    $stmt->bind_param("ii", $qty, $id);
    $stmt->execute();
}

// Hitung total pembayaran
$query = "SELECT SUM(p.harga * k.jumlah) as subtotal 
          FROM keranjang k 
          JOIN produk_jasa p ON k.produk_id = p.id_produk";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$subtotal = $row['subtotal'];
$pajak = ($subtotal - $voucher) * 0.11;
$total = $subtotal - $voucher + $pajak + $ongkir;

// Simpan ke tabel pembayaran
$stmt = $conn->prepare("INSERT INTO pembayaran (id_servis, total, metode_pembayaran) 
                        VALUES (?, ?, ?)");
// Anda perlu menyesuaikan id_servis sesuai kebutuhan
$id_servis = 1; // Contoh saja
$stmt->bind_param("ids", $id_servis, $total, $payment_method);
$stmt->execute();

// Redirect ke halaman sukses
header("Location: pembayaran_sukses.php");
exit();
?>