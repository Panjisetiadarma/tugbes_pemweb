<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "tubes_pemweb";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>

<?php
$koneksi = new mysqli("localhost", "root", "", "tubes_pemweb");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}