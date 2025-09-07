<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\KategoriModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="kategori-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kategori')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
