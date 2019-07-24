<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$orders_id = ArrayHelper::map(\app\models\Order::find()->asArray()->all(), 'id', 'id');
$products_id = ArrayHelper::map(\app\models\Product::find()->asArray()->all(), 'id', 'name');

?>
<h1>Create Order Detail</h1>
<?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model,'orders_id')->dropDownList($orders_id, ['prompt' => 'Pilih Order Id','class' => 'form-control']) ?>
	<?= $form->field($model,'products_id')->dropDownList($products_id, ['prompt' => 'Pilih Product','class' => 'form-control'])->label('Product') ?>
	<?= $form->field($model,'quantity_order') ?>	
	<?= Html::submitButton('Simpan',['class'=>'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>