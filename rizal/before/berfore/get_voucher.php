<?php
include 'koneksi.php'; // pastikan ini koneksi ke database

$query = "SELECT * FROM voucher ORDER BY waktu_akhir ASC";
$result = mysqli_query($conn, $query);

$vouchers = [];
while ($row = mysqli_fetch_assoc($result)) {
    $vouchers[] = $row;
}

header('Content-Type: application/json');
echo json_encode($vouchers);
?>
