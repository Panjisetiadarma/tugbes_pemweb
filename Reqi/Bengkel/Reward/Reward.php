
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>vouchel</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <!-- NAVIGATION BAR -->
  <div class="navbar d-flex justify-content-between px-3 py-2 bg-light">
    <div class="nav-left">
      <button class="btn-icon border-0 bg-transparent">
        <img src="gambar1.png" alt="Kiri" width="50" height="40">
      </button>
    </div>
    <div class="nav-right">
      <button class="btn-icon border-0 bg-transparent">
        <img src="gambar3.png" alt="Kanan" width="50" height="40">
      </button>
    </div>
  </div>

  <h2 class="my-5 text-center">vouchel</h2>

  <div class="container text-center">
    <p>Lihat vouchel mu setiap hari untuk mendapatkan promo menarik!</p>

    <!-- Voucher akan ditampilkan di sini -->
    <div class="row" id="voucher-list"></div>
  </div>

  <footer class="mt-5"></footer>

  <!-- Script ambil data reward -->
  <script>
fetch('get_voucher.php')
  .then(response => response.json())
  .then(data => {
    const container = document.getElementById('voucher-list');

    if (!Array.isArray(data) || data.length === 0) {
        container.innerHTML = '<p class="col-12">Tidak ada voucher tersedia saat ini.</p>';
        return;
    }

    data.forEach((item, index) => {
        const col = document.createElement('div');
        col.className = 'col-md-4';

        col.innerHTML = `
        <div class="card mb-4">
          <div class="card-header bg-light">vouchel</div>
          <div class="card-body">
            <h5 class="card-title">${item.nama}</h5>
            <p> ${item.deskripsi}</p>
            <p>Berlaku sampai: ${item.berlaku}</p>
          </div>
          <div class="card-footer">
           <a href="#" class="btn btn-primary accept-btn" data-nama="${item.nama}">Accept</a>
          </div>
        </div>
        `;

        container.appendChild(col);
    });
  })
  .catch(error => {
    console.error('Gagal memuat voucher:', error);
    document.getElementById('voucher-list').innerHTML = '<p class="col-12">Gagal memuat voucher.</p>';
  });

document.addEventListener('click', function(e) {
  if (e.target.classList.contains('accept-btn')) {
    e.preventDefault();
    const voucherNama = e.target.getAttribute('data-nama');

    fetch('accept_voucher.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: 'nama=' + encodeURIComponent(voucherNama)
    })
    .then(response => response.text())
    .then(result => {
      alert(result); // Misal: "Voucher berhasil disimpan!"
    });
  }
});

  </script>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
