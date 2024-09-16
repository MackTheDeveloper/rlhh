<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\AssignCourses */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="assign-courses-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo Html::hiddenInput('AssignCourses[course_id]',$modelCourse->course_id); ?>
    
     <?php
    $allNeededCategories = $model->getNeededCategories($modelCourse->course_category_id);
    $categoruData = ArrayHelper::map($allNeededCategories, 'category_id', 'name');
    $model->course_category_id = $model->getAssingedCategory($modelCourse->course_id);
    echo $form->field($model, 'course_category_id')
                    ->widget(Select2::classname(), [
                        'data' => $categoruData,
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true
                        ],
            ]);
    ?>
    
    
    

    <div class="row rowbtn">
        <div class="typesubmit">
<?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Submit') : Yii::t('yii', 'Submit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
