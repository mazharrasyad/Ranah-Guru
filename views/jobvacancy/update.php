<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Jobvacancy */

$this->title = 'Perbaharui Lowongan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lowongan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Perbaharui';
?>
<div class="jobvacancy-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
