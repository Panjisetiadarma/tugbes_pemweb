<?php
$host = "localhost";
$user = "root";
$pass = ""; // sesuaikan
$dbname = "checkin_db"; // nama database

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
