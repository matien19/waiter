<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Konfirmasi Pesanan';
?>
<section class="section p-4">
<a href="<?= Url::to(['site/index']) ?>" class="btn btn-secondary btn-sm mb-2"><i class="fas fa-arrow-left"></i> Kembali ke Menu</a>
<div class="row">
    <!-- Bagian kiri: Nota Pesanan -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fas fa-receipt"></i> Nota Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="p-3 border rounded bg-light">
                    <h6 class="text-center mb-3">Rincian Pesanan</h6>

                    <?php $grandTotal = 0; ?>
                    <?php foreach ($cart as $item): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <strong><?= Html::encode($item['nama']) ?></strong><br>
                                <small>x<?= Html::encode($item['qty']) ?> @ Rp <?= number_format($item['harga'], 0, ',', '.') ?></small>
                            </div>
                            <div>
                                Rp <?= number_format($item['total'], 0, ',', '.') ?>
                            </div>
                        </div>
                        <?php $grandTotal += $item['total']; ?>
                    <?php endforeach; ?>

                    <hr>
                    <div class="d-flex justify-content-between font-weight-bold">
                        <span>Total Bayar</span>
                        <span>Rp <?= number_format($grandTotal, 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <!-- Bagian kanan: Form Konfirmasi -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user-check"></i> Data Pemesan</h5>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin(['action' => ['site/order'], 'method' => 'post']); ?>

                <div class="form-group mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama pemesan" required>
                </div>

                <!-- Tampilkan nomor meja -->
                <div class="form-group mb-3">
                    <label>Nomor Meja</label>
                    <input type="text" class="form-control" value="<?= Html::encode($noMeja) ?>" disabled>
                    <!-- Hidden input supaya ikut terkirim -->
                    <input type="hidden" name="no_meja" value="<?= Html::encode($noMeja) ?>">
                </div>

                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-check"></i> Konfirmasi Pesanan
                </button>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
</section>