<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseregistrationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="courseregistration-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'courseregistration_id') ?>

    <?= $form->field($model, 'course_id') ?>

    <?= $form->field($model, 'customer_id') ?>

    <?= $form->field($model, 'registration_date') ?>

    <?= $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'status_registration') ?>

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
