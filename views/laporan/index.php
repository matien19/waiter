<?php

use app\models\TagihanModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TagihanSearchModel $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Laporan Pemasukan');
$this->params['breadcrumbs'][] = $this->title;
// Karena pagination sudah dimatikan, langsung sum semua dari query
$query = clone $dataProvider->query;
$totalSemua = (int) $query->sum('total');
?>
<div class="tagihan-model-index">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body">

            <?php $form = ActiveForm::begin([
                    'method' => 'get',
                    'action' => ['index'],
                ]); ?>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <?= $form->field($searchModel, 'date_start')->input('date') ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($searchModel, 'date_end')->input('date') ?>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary mt-4">Filter</button>
                        <?= Html::a('Reset', ['index'], ['class' => 'btn btn-secondary ms-2 mt-4']) ?>
                    </div>
                </div>
                <div class="mb-3">
                    <?= Html::a('<i class="fas fa-file-pdf"></i> Cetak PDF', 
                        ['laporan/pdf', 
                            'date_start' => $searchModel->date_start, 
                            'date_end' => $searchModel->date_end
                        ], 
                        ['class' => 'btn btn-danger', 'target' => '_blank']) ?>
                </div>

                <?php ActiveForm::end(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'showFooter' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'waktu_pembayaran',
                            'format' => ['date', 'php:d F Y [H:i]'],
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function ($tagihan) {
                                if ($tagihan->status === \app\models\TagihanModel::STATUS_PENDING) {
                                    return '<span class="badge bg-danger"> Belum Dibayar </span>';
                                } elseif ($tagihan->status === \app\models\TagihanModel::STATUS_TERBAYAR) {
                                    return '<span class="badge bg-success">' . Html::encode($tagihan->displayStatus()) . '</span>';
                                }
                                return Html::encode($tagihan->displayStatus());
                            },
                            'footer' => '<strong>Total Pemasukan :</strong>',
                            'footerOptions' => ['style' => 'font-weight:bold; text-align:right;'],
                        ],
                        [
                            'attribute' => 'Pemasukan',
                            'format' => 'raw',
                            'value' => function ($tagihan) {
                                return 'Rp ' . number_format((int)$tagihan->total, 0, ',', '.');
                            },
                            'footer' => 'Rp ' . number_format($totalSemua, 0, ',', '.') . '</strong>',
                            'footerOptions' => ['style' => 'font-weight:bold; text-align:left;'],
                        ],
                    ],
                ]); ?>


        </div>
    </div>


</div>
