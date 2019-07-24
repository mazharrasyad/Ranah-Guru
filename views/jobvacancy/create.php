<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Jobvacancy */

$this->title = 'Buat Lowongan';
$this->params['breadcrumbs'][] = ['label' => 'Lowongan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jobvacancy-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
