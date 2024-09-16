<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model backend\models\Collaboration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="collaboration-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <div class="col-md-4" style="padding: 0px">
        <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>
        <span style="float: left;margin-top: -95px;margin-left: 52px;font-size: 11px;">Preferred Image Dimension : <?php echo Yii::$app->params['collaborationBgWidth']; ?> Width, <?php echo Yii::$app->params['collaborationBgHeight']; ?> Height</span>
            <?php if (!$model->isNewRecord && $model->image != "" && file_exists(Yii::$app->basePath . '/web/images/collaboration/' . $model->image)) { ?>
            <span style="float: right;margin-top: -73px;margin-right: 70px;"><?php $img = Html::img(Yii::getAlias('@web') . '/images/collaboration/' . $model->image, ['width' => 100, 'height' => 100]);
                echo Html::a($img, Yii::getAlias('@web') . '/images/collaboration/' . $model->image, ['target' => '_blank']);
                ?></span>
    <?php } ?>
    </div>
    
    <div class="col-md-4" style="padding: 0px">
        <?= $form->field($model, 'logo')->fileInput(['accept' => 'image/*']) ?>
        <span style="float: left;margin-top: -95px;margin-left: 52px;font-size: 11px;">Preferred Image Dimension : <?php echo Yii::$app->params['collaborationLogoWidth']; ?> Width, <?php echo Yii::$app->params['collaborationLogoHeight']; ?> Height</span>
            <?php if (!$model->isNewRecord && $model->image != "" && file_exists(Yii::$app->basePath . '/web/images/collaboration/' . $model->logo)) { ?>
            <span style="float: right;margin-top: -73px;margin-right: 70px;"><?php $img = Html::img(Yii::getAlias('@web') . '/images/collaboration/' . $model->logo, ['width' => 100, 'height' => 100]);
                echo Html::a($img, Yii::getAlias('@web') . '/images/collaboration/' . $model->logo, ['target' => '_blank']);
                ?></span>
    <?php } ?>
    </div>
    
    
    
      <?php
echo $form->field($model, 'description')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'basic'
]);
?>
    <?= $form->field($model, 'status')->radioList(['1' => 'Active', '0' => 'In Active',]) ?>

    

       <div class="row rowbtn">
        <div class="form-group typesubmit">
<?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Submit') : Yii::t('yii', 'Submit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
<?php echo Html::a(Yii::t('yii', 'Cancel'), ['index'], ['class' => 'btn-success btn']); ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
