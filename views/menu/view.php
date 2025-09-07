<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\MenuModel $model */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Menu Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="menu-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nama',
            [
                'attribute' => 'id_kategori',
                'value' => function ($model) {
                    return $model->kategori ? $model->kategori->kategori : '-';
                },
                'label' => 'Kategori',
            ],
            'harga',
            'stok',
           [
                'label' => 'Gambar',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::img(Yii::getAlias('@web/uploads/'.$model->gambar), [
                        'alt' => $model->nama,
                        'width' => '200px'
                    ]);
                },
            ],

        ],
    ]) ?>

</div>
