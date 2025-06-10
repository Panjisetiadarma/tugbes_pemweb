<?php
header('Content-Type: application/json');

include 'koneksi.php';

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
