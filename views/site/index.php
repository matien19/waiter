<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "POS Waiters";
?>
<!-- Jumbotron -->
<div class="jumbotron text-center text-white d-flex flex-column justify-content-center align-items-center mb-4" >
    <h1 class="display-6 fw-bold">Selamat Datang di POS Waiters</h1>
    <p class="lead">
        Sistem pemesanan makanan cepat, praktis, dan modern.<br>
        Pilih menu favorit Anda dan lakukan pemesanan dengan mudah.
    </p>
</div>
<section>
    <div class="row">
        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="col-12">
                <div class="alert alert-danger">
                    <?= Yii::$app->session->getFlash('error') ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="col-12">
                <div class="alert alert-success">
                    <?= Yii::$app->session->getFlash('success') ?>
                </div>
            </div>
        <?php endif; ?>
        <h2>Menu</h2>

        <!-- Menu List -->
        <div class="col-md-8 p-4">
            <div class="row g-3">
                <?php foreach ($menuList as $item): ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card menu-card shadow-sm menu-item" 
                            data-toggle="modal" 
                            data-target="#menuModal"
                            data-id="<?= $item['id'] ?>"
                            data-nama="<?= Html::encode($item['nama']) ?>"
                            data-harga="<?= $item['harga'] ?>"
                            data-gambar="<?= Yii::getAlias('@web/uploads/'.$item['gambar']) ?>">
                            <img src="<?= Yii::getAlias('@web/uploads/'.$item['gambar']) ?>" class="card-img-top">
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
            <h5><i class="fas fa-receipt"></i> Pesanan </h5>

            <!-- Form Cart -->
            <form id="cart-form" method="post" action="<?= Url::to(['site/checkout']) ?>">
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>
                
                <ul id="cart-list" class="list-group mb-3"></ul>
                 <!-- Simpan nomor meja -->
                <?= Html::hiddenInput('no_meja', Html::encode($no_meja)) ?>

                <div class="d-flex justify-content-between">
                    <span>Total</span>
                    <span class="cart-total" id="cart-total">Rp 0</span>
                </div>

                <!-- Hidden input untuk simpan cart JSON -->
                <input type="hidden" name="cart_data" id="cart-data">

                <button type="submit" class="btn btn-success w-100 mt-3">
                    <i class="fas fa-check"></i> Selesai
                </button>
            </form>
        </div>
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="menuModal" tabindex="-1" role="dialog" aria-labelledby="menuModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="menuModalLabel">Tambah Pesanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <h5 id="modalNama"></h5>
        <p class="text-muted">Harga: Rp <span id="modalHarga"></span></p>

        <div class="form-group">
          <label>Jumlah</label>
          <input type="number" id="modalQty" class="form-control text-center" value="1" min="1">
        </div>
        <p><strong>Total: Rp <span id="modalTotal"></span></strong></p>
      </div>
      <div class="modal-footer">
        <?= Html::button('Batal', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) ?>
        <?= Html::button('Tambah ke Keranjang', ['class' => 'btn btn-primary', 'id' => 'add-to-cart']) ?>
      </div>
    </div>
  </div>
</div>

<?php
$js = <<<'JS'
let currentMenu = {};
let cart = [];

// Saat card menu diklik → tampilkan modal dengan data
$('.menu-item').on('click', function() {
    let id = $(this).data('id');
    let nama = $(this).data('nama');
    let harga = parseInt($(this).data('harga'));
    let gambar = $(this).data('gambar');
    
    currentMenu = {id, nama, harga, gambar};

    $('#modalNama').text(nama);
    $('#modalHarga').text(harga.toLocaleString());
    $('#modalGambar').attr('src', gambar);
    $('#modalQty').val(1);

    updateModalTotal();
});

// Update total di modal
function updateModalTotal() {
    let qty = parseInt($('#modalQty').val());
    let total = currentMenu.harga * qty;
    $('#modalTotal').text(total.toLocaleString());
}
$('#modalQty').on('input', updateModalTotal);

// Tambah ke keranjang
$('#add-to-cart').on('click', function() {
    let qty = parseInt($('#modalQty').val());
    let total = currentMenu.harga * qty;

    cart.push({...currentMenu, qty, total});

    renderCart();

    $('#menuModal').modal('hide');
    
});

// Render cart ke panel kanan
function renderCart() {
    let html = "";
    let grandTotal = 0;

    cart.forEach((item, index) => {
        html += `<li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                ${item.nama} x${item.qty}<br>
                <small>Rp ${item.total.toLocaleString()}</small>
            </div>
            <button class="btn btn-sm btn-danger remove-item" data-index="${index}">
                <i class="fas fa-times"></i>
            </button>
        </li>`;
        grandTotal += item.total;
    });

    $('#cart-list').html(html);
    $('#cart-total').text("Rp " + grandTotal.toLocaleString());
    $('#cart-data').val(JSON.stringify(cart));
}

// Event hapus item
$(document).on('click', '.remove-item', function() {
    let index = $(this).data('index');
    cart.splice(index, 1); // hapus 1 item
    renderCart();
});
JS;
$this->registerJs($js);
?>
