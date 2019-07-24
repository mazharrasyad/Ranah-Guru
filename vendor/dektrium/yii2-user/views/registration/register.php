<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Role;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Daftar');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php 
                    $ar_role = ArrayHelper::map(Role::find()->where(['id' => [2,3]])->asArray()->all(),'id','name');            
                    
                    $form = ActiveForm::begin([
                        'id' => 'registration-form',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                    ]); 
                ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'username') ?>

                <?php if ($module->enableGeneratingPassword == false): ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                <?php endif ?>

                <?= $form->field($model, 'role_id')
                    ->widget(Select2::classname(), [
                        'data' => $ar_role,
                        'language' => 'id',
                        'options' => ['placeholder' => 'Pilih Peran'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]) ?>

                <?= Html::submitButton(Yii::t('user', 'Daftar'), ['class' => 'btn btn-success btn-block']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <p class="text-center">
            <?= Html::a(Yii::t('user', 'Sudah Punya Akun ? Langsung Masuk Aja'), ['/user/security/login']) ?>
        </p>
    </div>
</div>
