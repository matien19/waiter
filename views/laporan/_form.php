<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TagihanModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tagihan-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pesanan_id')->textInput() ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'bayar')->textInput() ?>

    <?= $form->field($model, 'kembalian')->textInput() ?>

    <?= $form->field($model, 'waktu_pembayaran')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Pending' => 'Pending', 'Terbayar' => 'Terbayar', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
