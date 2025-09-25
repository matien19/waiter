<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PesananModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pesanan-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'meja_id')->textInput() ?>

    <?= $form->field($model, 'waktu')->textInput() ?>

    <?= $form->field($model, 'status_pesanan')->dropDownList([ 'Terpesan' => 'Terpesan', 'Terkirim' => 'Terkirim', 'Terbayar' => 'Terbayar', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
