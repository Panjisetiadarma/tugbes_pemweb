<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$password = "";
$db = "toko_online";

$conn = mysqli_connect($host, $user, $password, $db);

if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "Koneksi gagal"]);
    exit;
}

$query = "SELECT * FROM voucher";
$result = mysqli_query($conn, $query);

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Query gagal"]);
    exit;
}

$voucher_list = [];

while ($row = mysqli_fetch_assoc($result)) {
    $voucher_list[] = [
        'nama' => $row['judul'],
        'deskripsi' => $row['deskripsi'] ?? 'Tidak ada',
        'potongan' => $row['potongan'] . ' ' . $row['tipe_potongan'],
        'berlaku' => $row['waktu_akhir'] ?? 'Tidak ditentukan'
    ];
}

echo json_encode($voucher_list);
?>
