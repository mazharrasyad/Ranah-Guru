<?php

use yii\helpers\Html;
use dektrium\user\helpers\Timezone;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Level;

$this->title = Yii::t('user', 'Profil Sekolah');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <?php 
                
                $ar_level = ArrayHelper::map(Level::find()->asArray()->all(),'id','name');
                $form = ActiveForm::begin([
                    'id' => 'school-form',
                    'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],                    
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                        'labelOptions' => ['class' => 'col-lg-3 control-label'],
                    ],
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                ]); ?>
                
                <?= $form->field($model, 'npsn') ?>

                <?= $form->field($model, 'name') ?>

                <?= $form->field($model, 'level_id')
                    ->widget(Select2::classname(), [
                        'data' => $ar_level,
                        'language' => 'id',
                        'options' => ['placeholder' => 'Pilih Jenjang Pendidikan'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]) ?>
                
                <?= $form->field($model, 'address')->textArea() ?>

                <?= $form->field($model, 'telp') ?>

                <?= $form->field($model, 'fotoFile')->fileInput() ?>

                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?= Html::submitButton(Yii::t('user', 'Simpan'), ['class' => 'btn btn-block btn-success']) ?>
                        <br>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
