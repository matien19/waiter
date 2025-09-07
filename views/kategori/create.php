<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KategoriModel $model */

$this->title = 'Tambah Data Kategori';
$this->params['breadcrumbs'][] = ['label' => 'Data Kategori', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kategori-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
