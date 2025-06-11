<?php
include '"../rizal/koneksi.php"';

$cartItems = [];

if (isset($_POST['selected_items'])) {
    $selectedItems = json_decode($_POST['selected_items'], true);

    foreach ($selectedItems as $item) {
        $cartId = intval($item['id']);
        $qty = intval($item['quantity']);

        // Ambil info produk dari DB
        $sql = "SELECT keranjang.id AS cart_id, produk.* 
                FROM keranjang 
                JOIN produk ON keranjang.produk_id = produk.id
                WHERE keranjang.id = $cartId";
        $result = $conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            $row['jumlah'] = $qty;
            $cartItems[] = $row;
        }
    }
}
?>
