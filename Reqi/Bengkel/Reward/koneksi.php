<?php
$host     = "localhost"; // Nama host, biasanya 'localhost'
$username = "root";      // Username MySQL Anda
$password = "";          // Password MySQL Anda
$database = "voucher"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
