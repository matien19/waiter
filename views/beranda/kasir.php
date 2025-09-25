<?php
use yii\helpers\Html;
/** @var yii\web\View $this */

$this->title = 'Beranda';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body">
            <p>Selamat datang, KASIR! Berikut adalah ringkasan data sistem:</p>

        </div>
    </div>
</div>
