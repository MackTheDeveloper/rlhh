<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Trainer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trainer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email',['enableAjaxValidation'=>true])->textInput(['maxlength' => true]) ?>

    <?php if($model->isNewRecord) { echo $form->field($model, 'password')->passwordInput(['maxlength' => true]); } ?>
    
    <?= $form->field($model, 'skype_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>

   <?= $form->field($model, 'status')->radioList([ '1' => 'Active', '0' => 'In Active', ])  ?>

    

   <div class="row rowbtn">
    <div class="form-group typesubmit">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Submit') : Yii::t('yii', 'Submit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
        <?php echo Html::a(Yii::t('yii','Cancel'),['index'],['class' => 'btn-success btn']); ?>
    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
