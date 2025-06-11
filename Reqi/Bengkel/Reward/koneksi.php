<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "toko_online";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>

<?php
$koneksi = new mysqli("localhost", "root", "", "toko_online");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error); // Pastikan ini bekerja
}