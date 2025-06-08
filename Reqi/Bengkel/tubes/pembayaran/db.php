<?php
$host = "localhost";
$user = "root";
$pass = ""; // sesuaikan dengan password MySQL Anda
$db   = "penjualan";

// Buat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
