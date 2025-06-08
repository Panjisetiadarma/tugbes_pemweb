<?php
// Data voucher statis (tanpa database)
$vouchers = [
    [
        'id' => 1,
        'title' => 'Diskon 10%',
        'description' => 'Dapatkan potongan 10% untuk servis motor Anda.',
        'expiry_date' => '2025-12-31'
    ],
    [
        'id' => 2,
        'title' => 'Gratis Oli',
        'description' => 'Gratis oli mesin untuk setiap servis lengkap.',
        'expiry_date' => '2025-07-15'
    ],
    [
        'id' => 3,
        'title' => 'Servis Gratis',
        'description' => '1x servis gratis setelah 5x servis berbayar.',
        'expiry_date' => '2025-08-01'
    ]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitur Reward Voucher</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .voucher-item {
            background-color: #f5f5f5;
            padding: 15px;
            margin: 15px auto;
            border-radius: 8px;
            max-width: 600px;
        }
        .voucher-item h2 {
            margin-top: 0;
        }
        .voucher-item button {
            margin-top: 10px;
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<!-- NAVIGATION BAR -->
<div class="navbar">
    <div class="nav-left">
        <a href="javascript:history.back()">
            <img src="gambar1.png" alt="kembali" class="img-content">
        </a>
    </div>
    <div class="nav-center">
        <h1 class="link-text">Reward Voucher</h1>
    </div>
    <div class="nav-right">
        <a href="favorit.html"><img src="gambar2.png" alt="love" class="img-right"></a>
        <a href="keranjang.html"><img src="gambar3.png" alt="toko" class="img-right"></a>
    </div>
</div>

<div class="container">
    <h1>Daftar Voucher</h1>

    <?php if (!empty($vouchers)): ?>
        <?php foreach ($vouchers as $voucher): ?>
            <div class="voucher-item">
                <h2><?= htmlspecialchars($voucher['title']) ?></h2>
                <p><?= htmlspecialchars($voucher['description']) ?></p>
                <p class="expiry-date">Kedaluwarsa: <?= date("d F Y", strtotime($voucher['expiry_date'])) ?></p>
                <button onclick="klaimVoucher(<?= $voucher['id'] ?>)">Klaim Voucher</button>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Tidak ada voucher tersedia.</p>
    <?php endif; ?>
</div>

<script>
function klaimVoucher(id) {
    alert("Voucher dengan ID " + id + " berhasil diklaim!");
}
</script>

</body>
</html>
