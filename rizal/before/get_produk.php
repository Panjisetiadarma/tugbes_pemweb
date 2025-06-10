<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "";
$db = "toko_online";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Koneksi gagal: ' . $conn->connect_error]);
    exit;
}

$kategori = $_GET['kategori'] ?? '';
if (empty($kategori)) {
    http_response_code(400);
    echo json_encode(['error' => 'Parameter kategori tidak boleh kosong']);
    exit;
}

$query = "SELECT judul, deskripsi, gambar, harga FROM produk WHERE kategori = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("s", $kategori);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $row['harga'] = (int)$row['harga']; // pastikan harga berupa angka
    $data[] = $row;
}

echo json_encode($data);
?>
