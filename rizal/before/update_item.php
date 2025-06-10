<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? 0;
$tipe = $input['tipe'] ?? '';
$updates = $input['updates'] ?? [];

if ($id <= 0 || empty($tipe) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$success = false;

if ($tipe === 'Katalog') {
    $judul = $updates[1] ?? '';
    $deskripsi = $updates[2] ?? '';
    $harga = str_replace(['Rp', '.', ' '], '', $updates[3] ?? '0');
    
    $stmt = $koneksi->prepare("UPDATE produk SET judul = ?, deskripsi = ?, harga = ? WHERE id = ?");
    $stmt->bind_param("ssii", $judul, $deskripsi, $harga, $id);
    $success = $stmt->execute();
} elseif ($tipe === 'Voucher') {
    $judul = $updates[1] ?? '';
    $potongan = str_replace(['Rp', '.', ' '], '', $updates[4] ?? '0');
    
    $stmt = $koneksi->prepare("UPDATE voucher SET judul = ?, potongan = ? WHERE id = ?");
    $stmt->bind_param("sii", $judul, $potongan, $id);
    $success = $stmt->execute();
}

echo json_encode(['success' => $success]);
?>