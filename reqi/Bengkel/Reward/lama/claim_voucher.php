<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voucher_id = intval($_POST['voucher_id']);
    $user_identifier = $_SERVER['REMOTE_ADDR']; // atau bisa pakai session/email jika ada login

    // Cek jika sudah klaim
    $cek = $conn->prepare("SELECT * FROM voucher_claims WHERE voucher_id = ? AND user_identifier = ?");
    $cek->bind_param("is", $voucher_id, $user_identifier);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows > 0) {
        echo "Anda sudah klaim voucher ini.";
    } else {
        $stmt = $conn->prepare("INSERT INTO voucher_claims (voucher_id, user_identifier) VALUES (?, ?)");
        $stmt->bind_param("is", $voucher_id, $user_identifier);
        if ($stmt->execute()) {
            echo "Voucher berhasil diklaim!";
        } else {
            echo "Gagal klaim voucher.";
        }
    }
}
?>
