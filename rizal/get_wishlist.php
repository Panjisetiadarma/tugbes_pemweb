<?php
include 'koneksi.php';
header('Content-Type: application/json');



// Ambil produk dalam wishlist 
$sql = "SELECT p.id, p.judul, p.deskripsi, p.harga, p.gambar, p.kategori 
        FROM wishlist w 
        JOIN produk p ON w.produk_id = p.id";
$result = $conn->query($sql);

$wishlist = [];
while ($row = $result->fetch_assoc()) {
    $wishlist[] = $row;
}

echo json_encode($wishlist);
?>