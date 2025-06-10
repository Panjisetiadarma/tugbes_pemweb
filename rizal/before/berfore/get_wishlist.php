<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "";
$db = "toko_online";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die(json_encode(["error" => "Koneksi gagal"]));
}

// Ambil semua produk dalam wishlist dengan field yang sesuai
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