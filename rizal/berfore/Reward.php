
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

<div class="container my-4">
  <h4>Voucher Tersedia</h4>
  <div id="voucherList" class="row g-3">
    <!-- Voucher cards will be injected here -->
  </div>
</div>

<script>
  fetch('get_voucher.php')
    .then(response => response.json())
    .then(data => {
      const voucherList = document.getElementById('voucherList');
      data.forEach(voucher => {
        const card = document.createElement('div');
        card.className = 'col-md-4';

        card.innerHTML = `
          <div class="card h-100 shadow-sm border-success">
            <div class="card-body">
              <h5 class="card-title text-success">${voucher.name}</h5>
              <p class="card-text">${voucher.deskripsi}</p>
              <p class="card-text"><small class="text-muted">Voucher Kedaluwarsa: ${formatTanggal(voucher.waktu_akhir)}</small></p>
              <button class="btn btn-success">Gunakan</button>
            </div>
          </div>
        `;
        voucherList.appendChild(card);
      });
    });

  function formatTanggal(dateStr) {
    const tanggal = new Date(dateStr);
    const options = { day: 'numeric', month: 'long', year: 'numeric' };
    return tanggal.toLocaleDateString('id-ID', options);
  }
</script>


</body>
</html>
