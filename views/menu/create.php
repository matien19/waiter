<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MenuModel $model */

$this->title = 'Create Menu Model';
$this->params['breadcrumbs'][] = ['label' => 'Menu Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
