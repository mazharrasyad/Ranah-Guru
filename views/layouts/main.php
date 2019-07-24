<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use kartik\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    if (Yii::$app->user->identity->role_id == 2) {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Beranda', 'url' => ['/']],                        
                ['label' => 'Lowongan', 'url' => ['/jobvacancy']],                        
                Yii::$app->user->isGuest ? 
                (['label' => 'Masuk', 'url' => ['/user/security/login']]):
                ['label' => Yii::$app->user->identity->username,
                    'items' => [
                        ['label' => 'Profil', 'url' => ['/user/settings/school']],
                        ['label' => 'Keluar', 'url' => ['/user/security/logout'], 'linkOptions' => ['data-method' => 'post']],
                    ],
                ],
                ['label' => 'Daftar', 
                    'url' => ['/user/registration/register'], 
                    'visible' => Yii::$app->user->isGuest
                ],
            ],
        ]);
    }
    else if (Yii::$app->user->identity->role_id == 3) {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Beranda', 'url' => ['/']], 
                ['label' => 'Lowongan '.Html::badge(Yii::$app->user->identity->flags), 'url' => ['/apply/notification'],'encode'=>false],                       
                Yii::$app->user->isGuest ? 
                (['label' => 'Masuk', 'url' => ['/user/security/login']]):
                ['label' => Yii::$app->user->identity->username,
                    'items' => [
                        ['label' => 'Profil', 'url' => ['/user/settings/teacher']],
                        ['label' => 'Keluar', 'url' => ['/user/security/logout'], 'linkOptions' => ['data-method' => 'post']],
                    ],
                ],
                ['label' => 'Daftar', 
                    'url' => ['/user/registration/register'], 
                    'visible' => Yii::$app->user->isGuest
                ],
            ],
        ]);
    }
    else {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Beranda', 'url' => ['/']],                                        
                Yii::$app->user->isGuest ?
                (['label' => 'Masuk', 'url' => ['/user/security/login']]):
                ['label' => Yii::$app->user->identity->username,
                    'items' => [
                        ['label' => 'Profil', 'url' => ['/user/settings/profile']],
                        ['label' => 'Kelola User', 'url' => ['/user/admin']],
                        ['label' => 'Kelola RBAC', 'url' => ['/admin']],
                        ['label' => 'Keluar', 'url' => ['/user/security/logout'], 'linkOptions' => ['data-method' => 'post']],
                    ],
                ],
                ['label' => 'Daftar', 
                    'url' => ['/user/registration/register'], 
                    'visible' => Yii::$app->user->isGuest
                ],
            ],
        ]);
    }

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <b>Ranah Guru</b> <?= date('Y') ?></p>

        <p class="pull-right"><b>Powered by</b> Fathan - Azhar - Akbar - Raihan - Nafu</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
