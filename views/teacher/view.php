<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Jobvacancy */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Lowongan', 'url' => ['jobvacancy/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="teacher-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-md-12">
        <img src="<?= Yii::$app->request->baseUrl; ?>/foto/<?= $model->foto; ?>" style="width: 25%; align: center;">
        <br>
        <br>
    </div>    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [      
            'nuptk',
            'name',
            'birthdate',            
            [
                'label' => 'Agama',
                'attribute' => 'religion.name',
            ],
            'telp',
            'address',    
        ],
    ]) ?>

    <a href="<?= Yii::$app->request->baseUrl; ?>/cv/<?= $model->cv; ?>" class="btn btn-danger">
        Unduh CV
    </a>

</div>
