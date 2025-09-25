<?php

use app\models\MenuModel;
use app\models\TagihanModel;
use yii\helpers\Html;

if ($pesanan && $pesananDetail): ?>
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="fas fa-receipt"></i> Nota Pesanan</h5>
        </div>
        <div class="card-body">
            <div class="p-3 border rounded bg-light">
                <h6 class="text-center mb-3">Rincian Pesanan</h6>
                <p class="mb-1">ID Pesanan: <?= Html::encode($pesanan->id) ?></p>
                <p class="mb-1">Tanggal: <?= Yii::$app->formatter->asDatetime($pesanan->waktu, 'php:d F Y H:i') ?></p>
                <p class="mb-3">Nama Pelanggan: <?= Html::encode($pesanan->nama) ?></p>
                <?php $grandTotal = 0; ?>
                <?php foreach ($pesananDetail as $detail): ?>
                    <?php
                        $menu = MenuModel::findOne($detail->menu_id);
                        $namaMenu = $menu ? $menu->nama : 'Menu tidak ditemukan';
                        $grandTotal += $detail->subtotal;
                    ?>
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <strong><?= Html::encode($namaMenu) ?></strong><br>
                            <small>x<?= Html::encode($detail->jumlah) ?> @ Rp <?= number_format($detail->harga, 0, ',', '.') ?></small>
                        </div>
                        <div>
                            Rp <?= number_format($detail->subtotal, 0, ',', '.') ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <hr>
                <div class="d-flex justify-content-between font-weight-bold">
                    <span>Total Bayar</span>
                    <span>Rp <?= number_format($grandTotal, 0, ',', '.') ?></span>
                </div>
                <?php
                    $tagihan = TagihanModel::find()->where(['pesanan_id' => $pesanan->id])->one();
                ?>
                <?php if ($tagihan && $tagihan->status == 'Terbayar'): ?>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between">
                            <span>Dibayar</span>
                            <span>Rp <?= number_format($tagihan->bayar, 0, ',', '.') ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Kembalian</span>
                            <span>Rp <?= number_format($tagihan->bayar - $grandTotal, 0, ',', '.') ?></span>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="mt-3 text-danger">
                        <strong>Status: Belum dibayar</strong>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <p>Data pesanan tidak ditemukan.</p>
<?php endif; ?>
