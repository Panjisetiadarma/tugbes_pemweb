<?php
include 'koneksi.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$ids = $data['ids'] ?? [];

if (empty($ids)) {
    echo json_encode(['success' => false, 'message' => 'Tidak ada item yang dipilih']);
    exit;
}

// Sanitize input
$ids = array_map('intval', $ids);
$idList = implode(',', $ids);

// Hapus item terpilih
$deleteSql = "DELETE FROM keranjang WHERE id IN ($idList)";
if ($conn->query($deleteSql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menghapus item: ' . $conn->error]);
}

$conn->close();
?>