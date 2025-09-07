<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MejaModel $model */

$this->title = 'Update Meja Model: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Meja Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="meja-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
