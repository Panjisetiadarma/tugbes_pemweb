<?php
// admin.php
require_once 'koneksi.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tipe']) && $_POST['tipe'] === 'Katalog') {
        // Handle katalog submission
        $judul = $_POST['judul'];
        $deskripsi = $_POST['deskripsi'];
        $harga = $_POST['harga'];
        $kategori = $_POST['kategori']; // Ambil kategori dari form
        
        // Handle image upload
        $gambar = '';
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
            move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
            $gambar = $target_file;
        }
        
        $stmt = $koneksi->prepare("INSERT INTO produk (judul, deskripsi, harga, gambar, kategori) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $judul, $deskripsi, $harga, $gambar, $kategori);
        $stmt->execute();
        
    } elseif (isset($_POST['tipe']) && $_POST['tipe'] === 'Voucher') {
        // Handle voucher submission
        $judul = $_POST['judulVoucher'];
        $potongan = $_POST['potongan'];
        
        $stmt = $koneksi->prepare("INSERT INTO voucher (judul, potongan) VALUES (?, ?)");
        $stmt->bind_param("si", $judul, $potongan);
        $stmt->execute();
    }
}

// Get data from database
$produk = $koneksi->query("SELECT 'Katalog' as tipe, id, judul, deskripsi, harga, '-' as potongan, gambar, kategori FROM produk");
$voucher = $koneksi->query("SELECT 'Voucher' as tipe, id, judul, '-' as deskripsi, '-' as harga, potongan, '-' as gambar, '-' as kategori FROM voucher");

// Combine results
$data = [];
while ($row = $produk->fetch_assoc()) $data[] = $row;
while ($row = $voucher->fetch_assoc()) $data[] = $row;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manajemen Katalog & Voucher</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    img.preview {
      max-width: 60px;
    }
  </style>
</head>
<body class="bg-light">
<div class="container my-4">
  <h1 class="text-center mb-4">Manajemen Data</h1>

  <div class="text-center mb-4">
    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#modalKatalog">Tambah Katalog</button>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalVoucher">Tambah Voucher</button>
  </div>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Tipe</th>
        <th>Judul</th>
        <th>Deskripsi</th>
        <th>Harga</th>
        <th>Potongan</th>
        <th>Gambar</th>
        <th>Kategori</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody id="tabelGabungan">
      <?php foreach ($data as $item): ?>
      <tr>
        <td><?= htmlspecialchars($item['tipe']) ?></td>
        <td><?= htmlspecialchars($item['judul']) ?></td>
        <td><?= htmlspecialchars($item['deskripsi']) ?></td>
        <td><?= $item['tipe'] === 'Katalog' ? 'Rp ' . number_format($item['harga'], 0, ',', '.') : '-' ?></td>
        <td><?= $item['tipe'] === 'Voucher' ? 'Rp ' . number_format($item['potongan'], 0, ',', '.') : '-' ?></td>
        <td><?= $item['gambar'] !== '-' && !empty($item['gambar']) ? '<img src="' . htmlspecialchars($item['gambar']) . '" class="preview" />' : '-' ?></td>
        <td><?= htmlspecialchars($item['kategori']) ?></td>
        <td>
          <button class="btn btn-warning btn-sm me-1" onclick="editRow(this)">Edit</button>
          <button class="btn btn-danger btn-sm" onclick="hapusRow(this, <?= $item['id'] ?? 0 ?>, '<?= $item['tipe'] ?>')">Hapus</button>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- Modal Katalog -->
<div class="modal fade" id="modalKatalog" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="formKatalog" method="post" enctype="multipart/form-data">
        <input type="hidden" name="tipe" value="Katalog">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Katalog</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Judul / Nama Barang</label>
            <input type="text" class="form-control" name="judul" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select class="form-select" name="kategori" required>
              <option value="">Pilih Kategori</option>
              <option value="oli">Oli</option>
              <option value="ban">Ban</option>
              <option value="gear">Gear</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi Barang</label>
            <textarea class="form-control" name="deskripsi" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Harga Barang (Rp)</label>
            <input type="number" class="form-control" name="harga" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Upload Gambar</label>
            <input type="file" class="form-control" name="gambar" accept="image/*">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Voucher -->
<div class="modal fade" id="modalVoucher" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="formVoucher" method="post">
        <input type="hidden" name="tipe" value="Voucher">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Voucher</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Judul Voucher</label>
            <input type="text" class="form-control" name="judulVoucher" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Potongan Harga (Rp)</label>
            <input type="number" class="form-control" name="potongan" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function hapusRow(btn, id, tipe) {
    if (confirm("Yakin ingin menghapus data ini?")) {
      fetch('hapus_item.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id, tipe: tipe })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          btn.closest("tr").remove();
        } else {
          alert('Gagal menghapus data');
        }
      });
    }
  }

  function editRow(btn) {
    const row = btn.closest("tr");
    const cells = row.querySelectorAll("td");
    const tipe = cells[0].innerText;

    // index kolom yang bisa diedit
    const editableIndexes = tipe === "Katalog" ? [1, 2, 3, 6] : [1, 4]; // Tambah index 6 (kategori) untuk Katalog
    editableIndexes.forEach(i => {
      const val = cells[i].innerText.replace("Rp ", "").trim();
      if (i === 6) { // Jika kolom kategori
        const select = document.createElement("select");
        select.className = "form-select form-select-sm";
        select.innerHTML = `
          <option value="oli" ${val === 'oli' ? 'selected' : ''}>Oli</option>
          <option value="ban" ${val === 'ban' ? 'selected' : ''}>Ban</option>
          <option value="gear" ${val === 'gear' ? 'selected' : ''}>Gear</option>
        `;
        cells[i].innerHTML = "";
        cells[i].appendChild(select);
      } else {
        const input = document.createElement("input");
        input.className = "form-control form-control-sm";
        input.value = val;
        cells[i].innerHTML = "";
        cells[i].appendChild(input);
      }
    });

    btn.textContent = "Simpan";
    btn.className = "btn btn-success btn-sm me-1";
    btn.onclick = () => {
      const data = {
        id: row.querySelector('button.btn-danger').getAttribute('data-id'),
        tipe: tipe,
        updates: {}
      };
      
      editableIndexes.forEach(i => {
        const inputElement = cells[i].querySelector("input, select");
        const val = inputElement.value;
        if (i === 3 || i === 4) {
          cells[i].innerHTML = `Rp ${val}`;
        } else if (i === 6) {
          cells[i].innerHTML = val; // Kategori tidak perlu format Rp
        } else {
          cells[i].innerHTML = val;
        }
        data.updates[i] = val;
      });
      
      fetch('update_item.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
      .then(response => response.json())
      .then(result => {
        if (!result.success) {
          alert('Gagal menyimpan perubahan');
        }
      });
      
      btn.textContent = "Edit";
      btn.className = "btn btn-warning btn-sm me-1";
      btn.onclick = () => editRow(btn);
    };
  }
</script>
</body>
</html>