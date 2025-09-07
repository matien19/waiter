<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MejaModel $model */

$this->title = 'Create Meja Model';
$this->params['breadcrumbs'][] = ['label' => 'Meja Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meja-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
