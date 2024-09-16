<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseScheduleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-schedule-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'course_schedule_id') ?>

    <?= $form->field($model, 'course_id') ?>

    <?= $form->field($model, 'trainer_ids') ?>

    <?= $form->field($model, 'from_time') ?>

    <?= $form->field($model, 'to_time') ?>

    <?php // echo $form->field($model, 'from_date') ?>

    <?php // echo $form->field($model, 'to_date') ?>

    <?php // echo $form->field($model, 'days') ?>

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
