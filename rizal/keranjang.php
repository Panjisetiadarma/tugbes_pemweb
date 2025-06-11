<?php
include 'koneksi.php';

$sql = "SELECT keranjang.id AS cart_id, keranjang.jumlah, produk.* 
        FROM keranjang 
        JOIN produk ON keranjang.produk_id = produk.id";
$result = $conn->query($sql);

$cartItems = [];
$totalAllItems = 0;
$totalAllPrice = 0;

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
        $totalAllItems += $row['jumlah'];
        $totalAllPrice += $row['jumlah'] * $row['harga'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <style>
   body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding-bottom: 100px;
            background-color: rgba(247,247,247,255);
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            background-color: white;
        }
        th {
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            border-left: none;
            border-right: none;
            background-color: rgba(38,114,162,255);
            color: white;
        }
        .cart-footer {
            position: fixed;
            bottom: 0;
            width: 98%;
            background: white;
            padding: 10px;
            box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
        }
        .cart-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 90%;
            max-width: 1200px;
        }
        .cart-actions {
            display: flex;
            gap: 10px;
        }
        .cart-actions button,
        .fitur-checkout button {
            background-color: rgba(78, 181, 222, 1);
            color: white;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 4px;
            font-weight: bold;
        }
        .cart-actions button:hover,
        .fitur-checkout button:hover {
            background-color: rgba(60, 140, 180, 1);
        }
        .cart-summary,
        .total-harga p {
            font-weight: bold;
        }
        .cart-summary span {
            color: rgba(78, 181, 222, 1);
        }
        .total-harga p {
            color: black;
            font-weight: bold;
        }
        .total-harga p span {
            color: rgba(78, 181, 222, 1);
        }
        .fitur-checkout {
            display: flex;
            justify-content: flex-end;
        }
        .produk-gambar {
            width: 100%;
            max-width: 320px;
            height: auto;
            display: block;
            margin: 10px auto;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgb(255, 255, 255);
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
        }
        .logo {
            display: flex;
            align-items: center;
        }
        .logo img {
            height: 30px;
            margin-right: 10px;
        }
        .logo-text {    
            color: #000000;
            font-size: 18px;
        }
        .img-right {
            width: 40px;
            padding-right: 20px;
        }
        .search-bar {
            display: flex;
            align-items: center;
        }
        .search-bar input {
            padding: 5px;
            border: 1px solid #d4cac7;
            border-radius: 4px 0 0 4px;
            outline: none;
        }
        .search-bar button {
            padding: 5px 10px;
            border: none;
            background-color: #cfc4c0;
            color: white;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }
        .favorit-icon span.material-symbols-outlined {
            color: blue;
            font-size: 36px;
            cursor: pointer;
            user-select: none;
        }
        .empty-message {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }
    </style>
</head>
<body>
      <div class="header">
        <div class="logo">
            <img src="gambar/icon-logo.png" alt="start">
            <div class="logo-text">
                <span>Start</span> | <span>Keranjang Belanja</span>
            </div>
        </div>
        <div class="favorit-icon">
            <a href="wishlist.php">
                <span class="material-symbols-outlined">favorite</span>
            </a>
        </div>
    </div>
    
    <table id="cart-table">
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)"></th>
                <th>Produk</th>
                <th>Harga Satuan</th>
                <th>Kuantitas</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody id="cart-body">
            <?php if (empty($cartItems)) { ?>
                <tr>
                    <td colspan="5" class="empty-message">
                        Keranjang-mu kosong. Silakan tambahkan produk ke keranjang.
                    </td>
                </tr>
            <?php } else {
                foreach ($cartItems as $item) {
                    $harga = (int)$item['harga'];
                    $jumlah = (int)$item['jumlah'];
                    $total = $harga * $jumlah;
            ?>
 <tr>
                    <td><input type="checkbox" class="item-checkbox" data-id="<?= $item['cart_id']; ?>" data-price="<?= $harga; ?>" data-quantity="<?= $jumlah; ?>"></td>
                    <td>
                        <strong><?= htmlspecialchars($item['judul']); ?></strong>
                        <?php if (!empty($item['gambar'])): ?>
                     <img src="<?= htmlspecialchars($item['gambar']); ?>" alt="<?= htmlspecialchars($item['judul']); ?>" class="produk-gambar">
                     <?php endif; ?>

                    </td>
                    <td>IDR <?= number_format($harga, 0, ',', '.'); ?></td>
                    <td>
                        <div class="quantity-controls">
                            <button class="quantity-btn" onclick="updateQuantity(<?= $item['cart_id']; ?>, -1)">-</button>
                            <span class="quantity-value" id="quantity-<?= $item['cart_id']; ?>"><?= $jumlah; ?></span>
                            <button class="quantity-btn" onclick="updateQuantity(<?= $item['cart_id']; ?>, 1)">+</button>
                        </div>
                    </td>
                    <td id="subtotal-<?= $item['cart_id']; ?>">IDR <?= number_format($total, 0, ',', '.'); ?></td>
                </tr>
            <?php }} ?>
        </tbody>
    </table>

    <div class="cart-footer">
        <div class="cart-container">
            <div class="cart-actions">
                <button onclick="removeSelected()">Hapus</button>
                <button onclick="addToFavorites()">Tambah ke Favorit</button>
            </div>
            <div class="cart-summary">
                <p>Total Produk: <span id="total-all-items"><?= $totalAllItems; ?></span> </p>
            </div>
            <div class="total-harga">
                <p>Total Harga: IDR <span id="total-all-price"><?= number_format($totalAllPrice, 0, ',', '.'); ?></span> </p>
            </div>
            <div class="fitur-checkout">
              <form id="checkoutForm" method="post" action="../reqi/Bengkel/Pembayaran/Pembayaran.php">
                <?php foreach ($cartItems as $item): ?>
                    <input type="hidden" name="items[][name]" value="<?= htmlspecialchars($item['judul']) ?>">
                    <input type="hidden" name="items[][price]" value="<?= $item['harga'] ?>">
                    <input type="hidden" name="items[][qty]" value="<?= $item['jumlah'] ?>">
                <?php endforeach; ?>
                <button type="submit">Checkout</button>
            </form>
            </div>
        </div>
    </div>

 <script>
        function toggleSelectAll(checkbox) {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(cb => cb.checked = checkbox.checked);
        }

        //  update kuantitas
        function updateQuantity(cartId, change) {
            fetch('update_quantity.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ 
                    cartId: cartId, 
                    change: change 
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // kuantitas
                    const quantitySpan = document.getElementById(`quantity-${cartId}`);
                    quantitySpan.textContent = data.newQuantity;
                    
                    //  subtotal
                    const subtotalTd = document.getElementById(`subtotal-${cartId}`);
                    subtotalTd.textContent = `IDR ${data.newSubtotal.toLocaleString('id-ID')}`;
                    
                    // total footer
                    document.getElementById('total-all-items').textContent = data.totalAllItems;
                    document.getElementById('total-all-price').textContent = data.totalAllPrice.toLocaleString('id-ID');
                    
                    // checkbox
                    const checkbox = document.querySelector(`.item-checkbox[data-id="${cartId}"]`);
                    if (checkbox) {
                        checkbox.dataset.quantity = data.newQuantity;
                    }
                } else {
                    alert(data.message || 'Gagal mengupdate kuantitas');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function removeSelected() {
            const checkboxes = document.querySelectorAll(".item-checkbox:checked");
            const ids = Array.from(checkboxes).map(cb => cb.dataset.id);

            if (ids.length === 0) {
                alert("Pilih produk yang ingin dihapus.");
                return;
            }

            fetch("remove_cart.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ ids: ids })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    checkboxes.forEach(cb => cb.closest('tr').remove());
                    alert("Item berhasil dihapus!");
                    location.reload(); 
                } else {
                    alert("Gagal menghapus item.");
                }
            })
            .catch(err => console.error("Error:", err));
        }

       function checkout() {
        document.getElementById('checkoutForm').submit();
    }

function addToFavorites() {
    const checkboxes = document.querySelectorAll(".item-checkbox:checked");
    let produkIds = Array.from(checkboxes).map(cb => parseInt(cb.dataset.produkId));

    if (produkIds.length === 0) {
        alert("Pilih produk yang ingin ditambahkan ke favorit.");
        return;
    }

    fetch("tambah_wishlist_dari_keranjang.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ produk_ids: produkIds })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("Produk berhasil ditambahkan ke favorit!");
        } else {
            alert("Gagal menambahkan ke favorit: " + (data.message || ''));
        }
    })
    .catch(err => {
        console.error(err);
        alert("Terjadi kesalahan.");
    });
}
        
    </script>
</body>
</html>