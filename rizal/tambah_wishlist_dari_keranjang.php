<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

$input = json_decode(file_get_contents('php://input'), true);
$produk_ids = $input['produk_ids'] ?? [];
$user_id = $input['user_id'] ?? null;

if (empty($produk_ids) || !$user_id) {
    echo json_encode(['success' => false, 'message' => 'User ID atau produk tidak valid']);
    exit;
}

$koneksi->begin_transaction();

try {
    // Siapkan prepared statement untuk cek dan insert
    $cekStmt = $koneksi->prepare("SELECT COUNT(*) FROM wishlist WHERE user_id = ? AND produk_id = ?");
    $insertStmt = $koneksi->prepare("INSERT INTO wishlist (user_id, produk_id) VALUES (?, ?)");

    foreach ($produk_ids as $produk_id) {
        // Cek apakah produk sudah ada di wishlist user ini
        $cekStmt->bind_param("ii", $user_id, $produk_id);
        $cekStmt->execute();
        $cekStmt->bind_result($count);
        $cekStmt->fetch();
        $cekStmt->store_result();

        if ($count == 0) {
            // Jika belum ada, insert
            $insertStmt->bind_param("ii", $user_id, $produk_id);
            $insertStmt->execute();
        }
    }

    $koneksi->commit();
    echo json_encode(['success' => true, 'message' => 'Produk berhasil ditambahkan ke wishlist']);
} catch (Exception $e) {
    $koneksi->rollback();
    echo json_encode([
        'success' => false,
        'message' => 'Gagal menambahkan ke wishlist: ' . $e->getMessage()
    ]);
}
?>
