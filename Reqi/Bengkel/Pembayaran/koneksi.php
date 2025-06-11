<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'toko_online';

try {
    $conn = new mysqli($host, $username, $password, $database);
    
    if ($conn->connect_error) {
        throw new Exception("Koneksi gagal: " . $conn->connect_error);
    }
    
    // Set charset untuk menghindari masalah encoding
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    // Tampilkan pesan error yang lebih ramah pengguna
    die("<h2>Terjadi masalah dengan database</h2>
        <p>Silakan coba lagi nanti atau hubungi administrator.</p>
        <p><small>Error: " . $e->getMessage() . "</small></p>");
}
?>