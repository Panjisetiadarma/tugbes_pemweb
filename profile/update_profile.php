<?php
session_start();
include "../navbar/koneksi.php";

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../login/index.php");
    exit;
}

$username = $_SESSION['username'];

// Ambil data user
$query = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
$user = mysqli_fetch_assoc($query);

// Proses saat form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = $_POST['new_name'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error = "Password baru dan konfirmasi tidak cocok.";
    } else {
        $update = mysqli_query($conn, "UPDATE user SET username='$new_name', password='$new_password' WHERE username='$username'");
        if ($update) {
            $_SESSION['username'] = $new_name;
            $success = "Profil berhasil diperbarui.";
            header("Refresh:1"); // refresh halaman agar nama baru tampil
        } else {
            $error = "Gagal memperbarui profil.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 60px;
        }

        .container {
            background: white;
            padding: 25px 30px;
            border-radius: 10px;
            width: 350px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .inputan-baru {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .inputan-baru label {
            width: 100%;
            text-align: left;
            font-weight: 500;
            margin-bottom: -8px;
        }

        .inputan-baru input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .inputan-baru button:hover {
            background: #0052a3;
        }


        button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        .message.success {
            color: green;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>
   <body>
    <!-- Profil Section -->
    <div style="text-align: center; margin-bottom: 30px;">
    <div style="position: relative; display: inline-block;">
        <img src="img/th.jpeg" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; background: #daa520;">
    </div>
    <h3 style="margin-top: 10px;"><?= htmlspecialchars($user['username']) ?></h3>

    <!-- Form Container -->
    <div class="container">
        <h2>Edit Profil</h2>

        <?php if (isset($error)): ?>
            <div class="message"><?= $error ?></div>
        <?php elseif (isset($success)): ?>
            <div class="message success"><?= $success ?></div>
        <?php endif; ?>

        <form class="inputan-baru" method="POST">
            <label>Nama Pengguna Baru</label>
            <input type="text" name="new_name" required>

            <label>Password Baru</label>
            <input type="password" name="new_password" required>

            <label>Konfirmasi Password Baru</label>
            <input type="password" name="confirm_password" required>

            <button type="submit">Simpan Perubahan</button>
        </form>

        <a href="../lobi/lobi.php" class="back"><- Kembali</a>
    </div>
</body>

    </div>
</body>
</html>
