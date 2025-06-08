<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? 0;
$tipe = $input['tipe'] ?? '';

if ($id <= 0 || empty($tipe)) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

if ($tipe === 'Katalog') {
    $stmt = $koneksi->prepare("DELETE FROM produk WHERE id = ?");
} elseif ($tipe === 'Voucher') {
    $stmt = $koneksi->prepare("DELETE FROM voucher WHERE id = ?");
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid type']);
    exit;
}

$stmt->bind_param("i", $id);
$success = $stmt->execute();

echo json_encode(['success' => $success]);
?>