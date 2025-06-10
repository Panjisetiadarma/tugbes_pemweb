<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

$judul = $input['judul'] ?? '';
$deskripsi = $input['deskripsi'] ?? '';
$gambar = $input['gambar'] ?? '';
$harga = $input['harga'] ?? 0;
$kategori = $input['kategori'] ?? '';

if (!$judul || !$harga) {
    echo json_encode(["success" => false, "message" => "Data tidak lengkap"]);
    exit;
}

$host = "localhost";
$user = "root";
$pass = "";
$db = "toko_online";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Koneksi gagal"]);
    exit;
}

// Cek apakah produk sudah ada di wishlist
$stmt = $conn->prepare("SELECT id FROM produk WHERE judul = ?");
$stmt->bind_param("s", $judul);
$stmt->execute();
$res = $stmt->get_result();
$produk = $res->fetch_assoc();

if (!$produk) {
    // Tambahkan ke produk jika belum ada
    $stmt = $conn->prepare("INSERT INTO produk (judul, deskripsi, harga, gambar, kategori) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $judul, $deskripsi, $harga, $gambar, $kategori);
    $stmt->execute();
    $produk_id = $stmt->insert_id;
} else {
    $produk_id = $produk['id'];
}

// Tambahkan ke wishlist
$stmt = $conn->prepare("INSERT INTO wishlist (produk_id) VALUES (?)");
$stmt->bind_param("i", $produk_id);
$success = $stmt->execute();

echo json_encode(["success" => $success]);
?>