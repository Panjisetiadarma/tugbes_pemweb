<?php
include 'koneksi.php';

$data = json_decode(file_get_contents('php://input'), true);
$cartId = $data['cartId'];
$change = (int)$data['change'];

// Ambil data keranjang saat ini
$sql = "SELECT jumlah, produk_id FROM keranjang WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cartId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Item tidak ditemukan']);
    exit;
}

$row = $result->fetch_assoc();
$currentQuantity = (int)$row['jumlah'];
$newQuantity = $currentQuantity + $change;

// Validasi kuantitas minimal 1
if ($newQuantity < 1) {
    $newQuantity = 1;
}

// Update database
$updateSql = "UPDATE keranjang SET jumlah = ? WHERE id = ?";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->bind_param("ii", $newQuantity, $cartId);
$updateStmt->execute();

// Ambil harga produk
$productSql = "SELECT harga FROM produk WHERE id = ?";
$productStmt = $conn->prepare($productSql);
$productStmt->bind_param("i", $row['produk_id']);
$productStmt->execute();
$productResult = $productStmt->get_result();
$productRow = $productResult->fetch_assoc();

$harga = (int)$productRow['harga'];
$newSubtotal = $harga * $newQuantity;

// Hitung ulang total keseluruhan
$totalSql = "SELECT 
                SUM(keranjang.jumlah) AS totalAllItems, 
                SUM(keranjang.jumlah * produk.harga) AS totalAllPrice 
             FROM keranjang 
             JOIN produk ON keranjang.produk_id = produk.id";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();

echo json_encode([
    'success' => true,
    'newQuantity' => $newQuantity,
    'newSubtotal' => $newSubtotal,
    'totalAllItems' => $totalRow['totalAllItems'] ?? 0,
    'totalAllPrice' => $totalRow['totalAllPrice'] ?? 0
]);

$conn->close();
?>