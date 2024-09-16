<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseSchedule */

$this->title = Yii::t('yii', 'Update Schedule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Course Schedules'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->course_schedule_id, 'url' => ['view', 'id' => $model->course_schedule_id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');

$this->params['menu'][] = ['label'=>'Create Schedule','url'=>['create'],'options'=>['class'=>'widemenu']];
$this->params['menu'][] = ['label'=>'Manage Schedules','url'=>['index'],'options'=>['class'=>'widemenu']];

?>
<div class="course-schedule-update">

  

    <?= $this->render('_form', [
        'model' => $model,
         'modelCourse' => $modelCourse,
    ]) ?>

</div>
