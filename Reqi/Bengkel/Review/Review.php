<?php
include 'koneksi.php';

// Jika form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $ulasan = mysqli_real_escape_string($conn, $_POST['ulasan']);

    if (!empty($nama) && !empty($ulasan)) {
        $sql = "INSERT INTO ulasan (nama, ulasan) VALUES ('$nama', '$ulasan')";
        mysqli_query($conn, $sql);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Bengkel</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .review-form, .review-list {
            max-width: 600px;
            margin: 20px auto;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: vertical;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .review-item {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .review-item h3 {
            margin: 0 0 5px 0;
        }
        .review-item p {
            margin: 0;
        }
    </style>
</head>
<body>

<!-- NAVIGATION BAR -->
<style>
    .navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #ffffff;
        padding: 10px 20px;
        border-bottom: 1px solid #ddd;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .nav-left,
    .nav-right {
        display: flex;
        align-items: center;
    }

    .nav-center {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }

    .nav-center h1 {
        margin: 0;
        font-size: 20px;
        font-weight: bold;
        color: #333;
    }

    .img-content, .img-right {
        width: 24px;
        height: 24px;
        margin-left: 10px;
        cursor: pointer;
    }

    .img-content {
        margin-left: 0;
    }
</style>

<div class="navbar">
    <!-- Tombol kembali di kiri -->
    <div class="nav-left">
        <a href="javascript:history.back()">
            <img src="gambar1.png" alt="kembali" class="img-content">
        </a>
    </div>

    <!-- Judul di tengah -->
    <div class="nav-center">
        <h1 class="link-text">Review Bengkel</h1>
    </div>

    <!-- Ikon favorit dan keranjang di kanan -->
    <div class="nav-right">
        <a href="keranjang.html"><img src="gambar3.png" alt="toko" class="img-right"></a>
        <a href="favorit.html"><img src="gambar2.png" alt="love" class="img-right"></a>
    </div>
</div>


<div class="container">
    <!-- Form untuk menulis ulasan -->
    <div class="review-form">
        <h2>Tulis Ulasan Anda</h2>
        <form action="" method="POST">
            <input type="text" name="nama" placeholder="Nama Anda" required>
            <textarea name="ulasan" placeholder="Tulis ulasan Anda di sini..." required></textarea>
            <button type="submit">Kirim Ulasan</button>
        </form>
    </div>

    <!-- Daftar ulasan -->
    <div class="review-list">
        <h2>Ulasan yang Ada</h2>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM ulasan ORDER BY id DESC");
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='review-item'>
                        <h3>" . htmlspecialchars($row['nama']) . "</h3>
                        <p>" . nl2br(htmlspecialchars($row['ulasan'])) . "</p>
                      </div>";
            }
        } else {
            echo "<p>Belum ada ulasan.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
