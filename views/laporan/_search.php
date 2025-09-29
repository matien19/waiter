<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TagihanSearchModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tagihan-model-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pesanan_id') ?>

    <?= $form->field($model, 'total') ?>

    <?= $form->field($model, 'bayar') ?>

    <?= $form->field($model, 'kembalian') ?>

    <?php // echo $form->field($model, 'waktu_pembayaran') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
