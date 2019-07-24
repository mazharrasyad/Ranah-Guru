<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Lesson;

/* @var $this yii\web\View */
/* @var $model app\models\Jobvacancy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jobvacancy-form">

    <?php 
        $ar_lesson = ArrayHelper::map(Lesson::find()->asArray()->all(),'id','name');
        $form = ActiveForm::begin(); 
    ?>

    <?= $form->field($model, 'school_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>

    <?= $form->field($model, 'lesson_id')
        ->widget(Select2::classname(), [
            'data' => $ar_lesson,
            'language' => 'id',
            'options' => ['placeholder' => 'Pilih Pelajaran...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Kirim', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
