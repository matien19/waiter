<?php

use app\models\PesananModel;
use app\models\TagihanModel;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Beranda';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body">
             <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-danger">
                    <?= Yii::$app->session->getFlash('error') ?>
                </div>
            <?php endif; ?>
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success">
                    <?= Yii::$app->session->getFlash('success') ?>
                </div>
            <?php endif; ?>
            <h4>Pesanan Hari ini</h4>
            <h6><?= Html::encode(date('d F Y')) ?></h6>
             <?= GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'id',
                    'nama',
                    'meja_id',
                    [
                        'attribute' => 'waktu',
                        'format' => ['date', 'php:d F Y [H:i:s]'],
                    ],
                    [
                        'label' => 'Total Tagihan',
                        // 'format' => ['decimal', 0],
                        'value' => function (PesananModel $model) {
                            $tagihan = TagihanModel::find()->where(['pesanan_id' => $model->id])->one();
                            $total = intval($tagihan->total);
                            return  'Rp ' . number_format($total, 0, ',', '.');
                        },
                    ],
                    [
                        'attribute' => 'status_pesanan',
                        'format' => 'raw', 
                        'value' => function (PesananModel $model) {
                            if ($model->status_pesanan === PesananModel::STATUS_PESANAN_TERPESAN) {
                                return '<span class="badge bg-warning">' . Html::encode($model->displayStatusPesanan()) . '</span>';
                            } elseif ($model->status_pesanan === PesananModel::STATUS_PESANAN_TERKIRIM) {
                                return '<span class="badge bg-success">' . Html::encode($model->displayStatusPesanan()) . '</span>';
                            } 
                        },
                    ],
                    [
                        'label' => 'Status Tagihan',
                        'format' => 'raw',
                        'value' => function (PesananModel $model) {
                            $tagihan = TagihanModel::find()->where(['pesanan_id' => $model->id])->one();
                            if ($tagihan) {
                                if ($tagihan->status === TagihanModel::STATUS_PENDING) {
                                    return '<span class="badge bg-danger"> Belum Dibayar </span>';
                                } elseif ($tagihan->status === TagihanModel::STATUS_TERBAYAR) {
                                    return '<span class="badge bg-success">' . Html::encode($tagihan->displayStatus()) . '</span>';
                                }
                            } else {
                                return '<span class="badge bg-secondary">Belum Ada</span>';
                            }
                        },
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, PesananModel $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        },
                        'template' => '{nota} {confirm} {verifikasi}',
                        'buttons' => [
                            // Tombol Nota (hanya jika tagihan sudah terbayar)
                            'nota' => function ($url, PesananModel $model, $key) {
                                return Html::a(
                                    '<i class="fas fa-receipt"></i> Nota',
                                    ['pesanan/nota', 'id' => $model->id],
                                    [
                                        'class' => 'btn btn-info btn-sm btn-nota',
                                        'title' => 'Lihat Nota',
                                        'data-toggle' => 'modal',
                                        'data-target' => '#notaModal',
                                        'data-id' => $model->id,
                                        'data-pjax' => '0',
                                    ]
                                );
                            },
                        
                            // Tombol Confirm Terkirim (khusus role koki, jika status masih terpesan)
                            'confirm' => function ($url, PesananModel $model, $key) {
                                return Html::a(
                                    '<i class="fas fa-check"></i> Terkirim',
                                    ['beranda/confirm-terkirim', 'id' => $model->id],
                                    [
                                        'class' => 'btn btn-success btn-sm',
                                        'title' => 'Konfirmasi Pesanan Terkirim',
                                        'data-method' => 'post',
                                        'data-confirm' => 'Yakin ingin mengubah status menjadi terkirim?',
                                    ]
                                );
                            },
                            // Tombol Verifikasi Pembayaran (khusus role kasir, jika tagihan pending)
                            'verifikasi' => function ($url, PesananModel $model, $key) {
                                $tagihan = TagihanModel::find()->where(['pesanan_id' => $model->id])->one();
                                // if (!$tagihan) return '';
                                $btnCash = Html::a(
                                    '<i class="fas fa-money-bill"></i> Cash ',
                                    '#',
                                    [
                                        'class' => 'btn btn-primary btn-sm btn-cash',
                                        'data-id' => $model->id,
                                        'data-tagihan_id' => $tagihan->id,
                                        'title' => 'Verifikasi Pembayaran Cash',
                                        'data-toggle' => 'modal',
                                        'data-target' => '#cashModal',
                                    ]
                                );
                                $btnTransfer = Html::a(
                                    '<i class="fas fa-university"></i> Transfer',
                                    ['beranda/verifikasi-transfer', 'id' => $tagihan->id],
                                    [
                                        'class' => 'btn btn-secondary btn-sm',
                                        'title' => 'Verifikasi Pembayaran Transfer',
                                        'data-method' => 'post',
                                        'data-confirm' => 'Verifikasi pembayaran transfer?',
                                    ]
                                );
                                return $btnCash . ' ' . $btnTransfer;
                            },
                        ],
                        'visibleButtons' => [
                            // 'nota' => function (PesananModel $model, $key, $index) {
                            //     $tagihan = TagihanModel::find()->where(['pesanan_id' => $model->id])->one();
                            //     return $tagihan && $tagihan->status === TagihanModel::STATUS_TERBAYAR;
                            // },
                            'confirm' => function (PesananModel $model, $key, $index) {
                                return Yii::$app->user->identity->role === 'koki' && $model->status_pesanan === PesananModel::STATUS_PESANAN_TERPESAN;
                            }, 
                            'verifikasi' => function (PesananModel $model, $key, $index) {
                                $tagihan = TagihanModel::find()->where(['pesanan_id' => $model->id])->one();
                                return Yii::$app->user->identity->role === 'kasir' && $tagihan && $tagihan->status === TagihanModel::STATUS_PENDING;
                            },
                        ],
                    ],
                ],
            ]); ?>

        </div>
    </div>
</div>
<!-- Modal Nota -->
<div class="modal fade" id="notaModal" tabindex="-1" role="dialog" aria-labelledby="notaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="notaModalLabel">Nota Pesanan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body" id="notaModalContent">
              <div class="text-center">
                  <i class="fas fa-spinner fa-spin"></i> Memuat...
              </div>
          </div>
      </div>
  </div>
</div>


<div class="modal fade" id="cashModal" tabindex="-1" role="dialog" aria-labelledby="cashModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cashModalLabel">Pembayaran Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="cashModalContent">
                <form id="form-verifikasi-cash" action="<?= Url::to(['pesanan/verifikasi-cash']) ?>" method="post">
                    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>
                    <input type="hidden" name="tagihan_id" id="input_tagihan_id" value="">
                    <div class="form-group">
                        <label for="input-nominal">Nominal Bayar</label>
                        <input type="number" class="form-control" id="input-nominal" name="nominal" min="0" required placeholder="Masukkan nominal pembayaran">
                    </div>
                    <button type="submit" class="btn btn-success">Verifikasi & Simpan</button>
                </form>
                
            </div>
        </div>
    </div>
</div>
<script>
$(document).on('click', '.btn-cash', function(e) {
    var tagihanId = $(this).data('tagihan_id');
    $('#input_tagihan_id').val(tagihanId);
    $('#input-nominal').val('');
});
</script>
<?php
$script = <<<JS
$(document).on('click', '.btn-nota', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    $('#notaModalContent').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Memuat...</div>');
    $('#notaModal').modal('show')
        .find('#notaModalContent')
        .load(url);
});
JS;
$this->registerJs($script);
?>
