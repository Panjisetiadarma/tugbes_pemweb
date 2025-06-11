<?php
include 'koneksi.php';

$id = $_GET['id'] ?? 0;
if($id > 0) {
    $stmt = $conn->prepare("DELETE FROM keranjang WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: ".$_SERVER['HTTP_REFERER']);
exit();
?>