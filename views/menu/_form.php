<?php

use app\models\KategoriModel;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MenuModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="menu-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_kategori')->dropDownList(
        ArrayHelper::map(KategoriModel::find()->all(), 'id', 'kategori'),
        ['prompt' => '-- Pilih Kategori --']
    ) ?>
    <?= $form->field($model, 'harga')->textInput() ?>

    <?= $form->field($model, 'stok')->textInput() ?>

    <?= $form->field($model, 'gambar')->fileInput() ?>  

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
