function checkout() {
    const selectedItems = document.querySelectorAll('.item-checkbox:checked');
    if (selectedItems.length === 0) {
        alert("Pilih minimal satu produk untuk checkout");
        return;
    }

    const items = Array.from(selectedItems).map(cb => ({
        id: cb.dataset.id,
        price: cb.dataset.price,
        quantity: cb.dataset.quantity
    }));

    // Simpan data sebagai JSON string
    document.getElementById('selected_items').value = JSON.stringify(items);
    
    // Submit form
    document.getElementById('checkoutForm').submit();
}
