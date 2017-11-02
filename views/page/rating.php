<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>



<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'post')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'rate')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>



<div class="form-group">
    <?= Html::submitButton('Rate!', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
