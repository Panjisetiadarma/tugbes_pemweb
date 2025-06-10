<?php
include 'koneksi.php';

$nama = $_POST['nama'] ?? '';

if ($nama !== '') {
    // Misalnya kita simpan ke tabel claimed_voucher
    $sql = "INSERT INTO claimed_voucher (nama_voucher, user_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    $user_id = 1; // Sesuaikan dengan sistem login mu nanti

    mysqli_stmt_bind_param($stmt, "si", $nama, $user_id);
    if (mysqli_stmt_execute($stmt)) {
        echo "Voucher berhasil disimpan!";
    } else {
        echo "Gagal menyimpan voucher.";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Data tidak valid.";
}

mysqli_close($conn);
?>
