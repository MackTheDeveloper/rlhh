<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CourseSchedule */

$this->title = Yii::t('yii', 'Create Course Schedule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Course Schedules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'][] = ['label'=>'Manage Schedules','url'=>['index'],'options'=>['class'=>'widemenu']];
?>
<div class="course-schedule-create">

    

    <?= $this->render('_form', [
        'model' => $model,
        'modelCourse' => $modelCourse,
    ]) ?>

</div>
