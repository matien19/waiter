<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KategoriModel $model */

$this->title = 'Edit Data Kategori: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Data Kategori', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kategori-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
