<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CoursesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="courses-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'course_id') ?>

    <?= $form->field($model, 'course_category_id') ?>

    <?= $form->field($model, 'course_name') ?>

    <?= $form->field($model, 'image') ?>

    <?= $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'course_date') ?>

    <?php // echo $form->field($model, 'time_duration') ?>

    <?php // echo $form->field($model, 'overview') ?>

    <?php // echo $form->field($model, 'highlight') ?>

    <?php // echo $form->field($model, 'class_size') ?>

    <?php // echo $form->field($model, 'trainer') ?>

    <?php // echo $form->field($model, 'fees') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'flagdelete') ?>

    <?php // echo $form->field($model, 'deleted_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('yii', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('yii', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
