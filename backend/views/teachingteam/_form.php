<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\Teachingteam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="teachingteam-form">

     <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
    <?php
    echo $form->field($model, 'type')
                                ->widget(Select2::classname(), [
                                    'data' => Yii::$app->params['teachingType'],
                                    'options' => ['placeholder' => '-- Select --'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        //'multiple' => true
                                    ],
                        ]);
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <div class="col-md-4" style="padding: 0px">
        <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>
        <span style="float: left;margin-top: -95px;margin-left: 52px;font-size: 11px;">Preferred Image Dimension : <?php echo Yii::$app->params['teachingTeamMemberWidth']; ?> Width, <?php echo Yii::$app->params['teachingTeamMemberHeight']; ?> Height</span>
            <?php if (!$model->isNewRecord && $model->image != "" && file_exists(Yii::$app->basePath . '/web/images/teaching-team/' . $model->image)) { ?>
            <span style="float: right;margin-top: -73px;margin-right: 70px;"><?php $img = Html::img(Yii::getAlias('@web') . '/images/teaching-team/' . $model->image, ['width' => 100, 'height' => 100]);
                echo Html::a($img, Yii::getAlias('@web') . '/images/teaching-team/' . $model->image, ['target' => '_blank']);
                ?></span>
    <?php } ?>
    </div>
    
    
    
       <?= $form->field($model, 'status')->radioList(['1' => 'Active', '0' => 'In Active',]) ?>
    
      <?php
echo $form->field($model, 'description')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'basic'
]);
?>
 

    

       <div class="row rowbtn">
        <div class="form-group typesubmit">
<?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Submit') : Yii::t('yii', 'Submit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
<?php echo Html::a(Yii::t('yii', 'Cancel'), ['index'], ['class' => 'btn-success btn']); ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>

<script>
    $(document).ready(function(){
        
        if($('#teachingteam-type option:selected').val() == '3')
        {
            $('.field-teachingteam-image').hide();
            $('.field-teachingteam-description').hide();
        }else{
             $('.field-teachingteam-image').show();
             $('.field-teachingteam-description').show();
        }
        
        $('#teachingteam-type').change(function(){
            var selectedVal = $(this).val();
            if(selectedVal == 3)
            {
                $('.field-teachingteam-image').hide();
                $('.field-teachingteam-description').hide();
            }else{
                $('.field-teachingteam-image').show();
                $('.field-teachingteam-description').show();
            }
        })
    })
    </script>