<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

$judul = $input['judul'] ?? '';
$deskripsi = $input['deskripsi'] ?? '';
$gambar = $input['gambar'] ?? '';
$harga = $input['harga'] ?? 0;
$jumlah = $input['jumlah'] ?? 1;

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

// Cek apakah produk dengan judul ini sudah ada di tabel produk
$stmt = $conn->prepare("SELECT id FROM produk WHERE judul = ?");
$stmt->bind_param("s", $judul);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

if ($row) {
    $produk_id = $row['id'];
} else {
    // Tambahkan ke tabel produk jika belum ada
    $stmt = $conn->prepare("INSERT INTO produk (judul, deskripsi, harga, gambar, kategori) VALUES (?, ?, ?, ?, '')");
    $stmt->bind_param("ssis", $judul, $deskripsi, $harga, $gambar);
    $stmt->execute();
    $produk_id = $stmt->insert_id;
}

// Cek apakah sudah ada di keranjang
$stmt = $conn->prepare("SELECT id, jumlah FROM keranjang WHERE produk_id = ?");
$stmt->bind_param("i", $produk_id);
$stmt->execute();
$res = $stmt->get_result();
$existing = $res->fetch_assoc();

if ($existing) {
    // Update jumlah
    $new_jumlah = $existing['jumlah'] + $jumlah;
    $stmt = $conn->prepare("UPDATE keranjang SET jumlah = ? WHERE id = ?");
    $stmt->bind_param("ii", $new_jumlah, $existing['id']);
    $stmt->execute();
} else {
    // Tambahkan item baru ke keranjang
    $stmt = $conn->prepare("INSERT INTO keranjang (produk_id, jumlah) VALUES (?, ?)");
    $stmt->bind_param("ii", $produk_id, $jumlah);
    $stmt->execute();
}

echo json_encode(["success" => true]);
?>
