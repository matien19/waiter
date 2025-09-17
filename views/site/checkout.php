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
                <?php $form = ActiveForm::begin(['action' => ['site/finish-order'], 'method' => 'post']); ?>

                <div class="form-group mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama pemesan" required>
                </div>

                <!-- <div class="form-group mb-3">
                    <label>Nomor Meja</label>
                    <select name="meja_id" class="form-control" required>
                        <option value="">-- Pilih Meja --</option>
                        <?php foreach ($mejaList as $meja): ?>
                            <option value="<?= $meja->id ?>">Meja <?= Html::encode($meja->no_meja) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div> -->

                <!-- <div class="form-group mb-3">
                    <label>Metode Pembayaran</label>
                    <select name="pembayaran" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div> -->

                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-check"></i> Konfirmasi Pesanan
                </button>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
</section>