<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

$this->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

$publishedRes = Yii::$app->assetManager->publish('@vendor/hail812/yii2-adminlte3/src/web/js');
$this->registerJsFile($publishedRes[1].'/control_sidebar.js', ['depends' => '\hail812\adminlte3\assets\AdminLteAsset']);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js', ['position' => \yii\web\View::POS_END]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .menu-card img {
            border-radius: 10px;
            object-fit: cover;
            height: 120px;
        }
        .menu-card {
            transition: transform .2s;
        }
        .menu-card:hover {
            transform: scale(1.05);
            cursor: pointer;
        }
        .cart-panel {
            background: white;
            border-left: 1px solid #dee2e6;
            height: 100vh;
            padding: 20px;
            position: sticky;
            top: 0;
        }
        .cart-total {
            font-size: 1.2rem;
            font-weight: bold;
            color: #28a745;
        }

        .jumbotron {
            background: url('<?= Yii::getAlias('@web/img/bg.png') ?>') no-repeat center center;
            background-size: cover;
            height: 100vh;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="<?= Url::home() ?>">
            <img src="<?= Yii::getAlias('@web/img/logo.png') ?>" 
                 alt="Logo" width="40" height="40" class="me-2">
            <span><?= Html::encode($this->title ?: 'POS Waiters') ?></span>
        </a>
    </div>
</nav>

<div class="container-fluid">
    <?= $content ?>
</div>

<footer>
    <div class="text-center p-3 bg-dark text-white mt-4">
        &copy; <?= date('Y') ?> POS Waiters. All rights reserved.
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
