<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

$input = json_decode(file_get_contents('php://input'), true);
$produk_id = $input['produk_id'] ?? null;

if ($produk_id === null) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

// Tambahkan pengecekan keberadaan produk
$check = $koneksi->prepare("SELECT * FROM wishlist WHERE produk_id = ?");
$check->bind_param("i", $produk_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Produk tidak ditemukan di wishlist']);
    exit;
}

// Hapus produk dari wishlist
$stmt = $koneksi->prepare("DELETE FROM wishlist WHERE produk_id = ?");
$stmt->bind_param("i", $produk_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $koneksi->error]);
}
?>