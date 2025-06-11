<?php 
include 'koneksi.php';

// Ambil semua data dari tabel produk_jasa
$query = "SELECT * FROM produk";
$result = mysqli_query($conn, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Estimasi Pembayaran</title>
  <link rel="stylesheet" href="style.css">
  <script>
    let pajakPersen = 11;

    function formatRupiah(angka) {
      return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(angka);
    }

    function updateTotal() {
      const hargaInputs = document.querySelectorAll('.harga');
      const qtyInputs = document.querySelectorAll('.qty');
      let subtotal = 0;

      for (let i = 0; i < hargaInputs.length; i++) {
        const harga = parseFloat(hargaInputs[i].value) || 0;
        const qty = parseInt(qtyInputs[i].value) || 0;
        subtotal += harga * qty;
      }

      const voucher = parseFloat(document.getElementById("voucher").value) || 0;
      const ongkir = parseFloat(document.getElementById("ongkir").value) || 0;

      const pajak = ((subtotal - voucher) * pajakPersen) / 100;
      const total = subtotal - voucher + pajak + ongkir;

      document.getElementById("subtotalText").textContent = formatRupiah(subtotal);
      document.getElementById("voucherText").textContent = '-' + formatRupiah(voucher);
      document.getElementById("ongkirText").textContent = formatRupiah(ongkir);
      document.getElementById("totalText").textContent = formatRupiah(total);
    }
  </script>
</head>
<body>
  <div class="container">
    <h1>Estimasi Pembayaran</h1>

    <form method="POST" action="proses_pembayaran.php">
      <div id="itemList">
        <label>Daftar Produk</label>
        <?php foreach($products as $product): ?>
          <div class="item-row">
            <input type="text" value="<?= htmlspecialchars($product['nama']) ?>" readonly>
            <input type="number" class="harga" value="<?= $product['harga'] ?>" readonly>
            <input type="number" class="qty" name="qty[<?= $product['id'] ?>]" min="0" value="0" oninput="updateTotal()">
          </div>
        <?php endforeach; ?>
      </div>

      <label for="voucher">Voucher Diskon (Rp)</label>
      <input type="number" id="voucher" name="voucher" placeholder="misal: 10000" oninput="updateTotal()">

      <label for="ongkir">Ongkos Kirim (Rp)</label>
      <input type="number" id="ongkir" name="ongkir" placeholder="misal: 15000" oninput="updateTotal()">

      <h3>Metode Pembayaran</h3>
      <div class="payment-methods">
        <button type="button" onclick="showMethods('bank')">Transfer Bank</button>
        <button type="button" onclick="showMethods('other')">Metode Lainnya</button>
      </div>

      <div id="bankMethods" style="display: none;">
        <div class="payment-header">
          <h3>Pilih Bank</h3>
          <button class="close-btn" type="button" onclick="resetPayment()">✕</button>
        </div>
        <label><input type="radio" name="payment" value="BCA"> Bank BCA</label><br>
        <label><input type="radio" name="payment" value="Mandiri"> Bank Mandiri</label><br>
        <label><input type="radio" name="payment" value="BNI"> Bank BNI</label><br>
        <label><input type="radio" name="payment" value="BRI"> Bank BRI</label><br>
      </div>

      <div id="otherMethods" style="display: none;">
        <div class="payment-header">
          <h3>Pilih Metode Pembayaran</h3>
          <button class="close-btn" type="button" onclick="resetPayment()">✕</button>
        </div>
        <label><input type="radio" name="payment" value="QRIS"> QRIS</label><br>
        <label><input type="radio" name="payment" value="DANA"> DANA</label><br>
      </div>

      <div class="result">
        <div>Subtotal <span id="subtotalText">Rp0,00</span></div>
        <div>Voucher <span id="voucherText">-Rp0,00</span></div>
        <div>Ongkir <span id="ongkirText">Rp0,00</span></div>
        <div class="total">Total Estimasi <span id="totalText">Rp0,00</span></div>
      </div>

      <button type="submit">Bayar</button>
    </form>

    <p class="note">Pembayaran bisa dilakukan menggunakan metode QRIS, DANA, atau transfer bank.</p>
  </div>
</body>
</html>
