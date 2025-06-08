<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Estimasi Pembayaran</title>
 <style>
  body {
  font-family: Arial, sans-serif;
  background-color: #f5f5f5;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  padding: 30px;
}
.container {
  background-color: #fff;
  padding: 30px 40px;
  border-radius: 12px;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
  width: 500px;
}
h2 {
  text-align: center;
  margin-bottom: 20px;
}
h3 {
  text-align: left;
  margin-bottom: 15px;
  margin-top: 25px;
}
label {
  display: block;
  margin-top: 15px;
  font-weight: bold;
}
input[type="number"], input[type="text"] {
  width: 100%;
  padding: 10px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
.item-row {
  display: flex;
  gap: 10px;
  margin-top: 10px;
}
.item-row input {
  flex: 1;
}
button {
  margin-top: 15px;
  padding: 10px 20px;
  background-color: #28a745;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
button.remove {
  background-color: #dc3545;
}
.result {
  margin-top: 25px;
  font-size: 16px;
  line-height: 1.8;
}
.result span {
  float: right;
}
.total {
  font-weight: bold;
  font-size: 18px;
  border-top: 1px solid #ccc;
  margin-top: 15px;
  padding-top: 10px;
}
.payment-methods {
  display: flex;
  justify-content: flex-start;
  gap: 10px;
  margin: 20px 0;
}
.payment-methods button {
  background-color: #007bff;
}
.note {
  font-size: 14px;
  margin-top: 15px;
  color: #666;
}
#otherMethods, #bankMethods {
  margin-top: 10px;
}
.payment-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.close-btn {
  background-color: #dc3545;
  color: white;
  border: none;
  font-size: 18px;
  padding: 0 10px;
  border-radius: 5px;
  cursor: pointer;
}

 </style>
 
  <script>
    let pajakPersen = 11;

    function formatRupiah(angka) {
      return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(angka);
    }

    function addItem() {
      const itemList = document.getElementById("itemList");

      const itemRow = document.createElement("div");
      itemRow.className = "item-row";

      itemRow.innerHTML = `
        <input type="text" placeholder="Nama barang" oninput="updateTotal()" name="itemName[]">
        <input type="number" placeholder="Harga" oninput="updateTotal()" name="itemPrice[]">
        <input type="number" placeholder="Jumlah" oninput="updateTotal()" name="itemQty[]">
        <button class="remove" onclick="removeItem(this)">✕</button>
      `;

      itemList.appendChild(itemRow);
    }

    function removeItem(btn) {
      btn.parentElement.remove();
      updateTotal();
    }

    function updateTotal() {
      let subtotal = 0;
      const itemRows = document.querySelectorAll(".item-row");

      itemRows.forEach(row => {
        const harga = parseFloat(row.children[1].value) || 0;
        const jumlah = parseFloat(row.children[2].value) || 0;
        subtotal += harga * jumlah;
      });

      const voucher = parseFloat(document.getElementById("voucher").value) || 0;
      const ongkir = parseFloat(document.getElementById("ongkir").value) || 0;

      const pajak = ((subtotal - voucher) * pajakPersen) / 100;
      const total = subtotal - voucher + pajak + ongkir;

      document.getElementById("subtotalText").textContent = formatRupiah(subtotal);
      document.getElementById("voucherText").textContent = '-' + formatRupiah(voucher);
      document.getElementById("ongkirText").textContent = formatRupiah(ongkir);
      document.getElementById("totalText").textContent = formatRupiah(total);
    }

    function showMethods(method) {
      document.querySelector(".payment-methods").style.display = "none";
      document.getElementById("bankMethods").style.display = "none";
      document.getElementById("otherMethods").style.display = "none";

      if (method === 'bank') {
        document.getElementById("bankMethods").style.display = 'block';
      } else if (method === 'other') {
        document.getElementById("otherMethods").style.display = 'block';
      }
    }

    function resetPayment() {
      document.querySelector(".payment-methods").style.display = "flex";
      document.getElementById("bankMethods").style.display = "none";
      document.getElementById("otherMethods").style.display = "none";

      const radios = document.querySelectorAll('input[name="payment"]');
      radios.forEach(r => r.checked = false);
    }

    window.onload = () => addItem();
  </script>
</head>
<body>
  <div class="container">
    <h2>Estimasi Pembayaran</h2>

    <form method="POST" action="koneksi.php">
      <div id="itemList">
        <label>Daftar Barang</label>
      </div>
      <button type="button" onclick="addItem()">+ Tambah Barang</button>

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
