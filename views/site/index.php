<?php
use yii\helpers\Html;

$this->title = "POS Waiters";

// Dummy data menu
$menu = [
    ['id' => 1, 'nama' => 'Pizza Margherita', 'harga' => 45000, 'img' => 'https://via.placeholder.com/150'],
    ['id' => 2, 'nama' => 'Burger Special', 'harga' => 35000, 'img' => 'https://via.placeholder.com/150'],
    ['id' => 3, 'nama' => 'Es Teh Manis', 'harga' => 5000, 'img' => 'https://via.placeholder.com/150'],
    ['id' => 4, 'nama' => 'Kopi Hitam', 'harga' => 8000, 'img' => 'https://via.placeholder.com/150'],
];
?>

<div class="row">
    <!-- Menu List -->
    <div class="col-md-8 p-4">
        <div class="row g-3">
            <?php foreach ($menu as $item): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card menu-card shadow-sm" onclick="addToCart(<?= $item['id'] ?>)">
                        <img src="<?= $item['img'] ?>" class="card-img-top">
                        <div class="card-body text-center">
                            <h6 class="card-title mb-1"><?= Html::encode($item['nama']) ?></h6>
                            <p class="text-muted mb-0">Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Cart Panel -->
    <div class="col-md-4 cart-panel">
        <h5><i class="fas fa-receipt"></i> Pesanan</h5>
        <ul id="cart-list" class="list-group mb-3"></ul>

        <div class="d-flex justify-content-between">
            <span>Total</span>
            <span class="cart-total" id="cart-total">Rp 0</span>
        </div>

        <button class="btn btn-success w-100 mt-3"><i class="fas fa-check"></i> Selesai</button>
    </div>
</div>

<script>
    let cart = [];
    const menuData = <?= json_encode($menu) ?>;

    function addToCart(id) {
        let item = menuData.find(m => m.id === id);
        let existing = cart.find(c => c.id === id);
        if (existing) {
            existing.qty += 1;
        } else {
            cart.push({...item, qty: 1});
        }
        renderCart();
    }

    function renderCart() {
        let cartList = document.getElementById('cart-list');
        cartList.innerHTML = '';
        let total = 0;
        cart.forEach(item => {
            total += item.harga * item.qty;
            cartList.innerHTML += `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    ${item.nama} x ${item.qty}
                    <span>Rp ${item.harga.toLocaleString()}</span>
                </li>
            `;
        });
        document.getElementById('cart-total').innerText = "Rp " + total.toLocaleString();
    }
</script>
