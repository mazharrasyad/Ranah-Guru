<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Jobvacancy */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Lowongan', 'url' => ['apply/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="school-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-md-12">
        <img src="<?= Yii::$app->request->baseUrl; ?>/foto/<?= $model->foto; ?>" style="width: 25%; align: center;">
        <br>
        <br>
    </div>    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [            
            'npsn',
            'name',
            [
                'label' => 'Jenjang Pendidikan',
                'attribute' => 'level.name',
            ],
            'address',
            'telp',
        ],
    ]) ?>

</div>
