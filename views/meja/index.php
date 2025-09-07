<?php

use app\models\MejaModel;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\MejaSearchModel $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Data Meja';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meja-model-index">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        </div>
         <div class="card-body">
            <?php

            $totalMeja = MejaModel::find()->count();
            ?>

            <div class="alert alert-info">
                Total Meja Sekarang: <b><?= $totalMeja ?></b>
            </div>

            <?php $form = ActiveForm::begin([
                'action' => ['update'],
                'method' => 'post',
            ]); ?>

            <div class="input-group mb-3">
                <input type="number" name="total_meja" class="form-control" value="<?= $totalMeja ?>" min="1">
                <div class="input-group-append">
                    <?= Html::submitButton('Update Total Meja', [
                        'class' => 'btn btn-primary',
                        'onclick' => 'return confirm("Apakah Anda yakin ingin update total meja? Data lama akan diganti!");'
                    ]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
