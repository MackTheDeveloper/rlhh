<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseSchedule */

$this->title = $model->course_schedule_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Course Schedules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-schedule-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->course_schedule_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->course_schedule_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'course_schedule_id',
            'course_id',
            'trainer_ids',
            'from_time',
            'to_time',
            'from_date',
            'to_date',
            'days',
            'status',
            'flagdelete',
            'deleted_by',
            'created_at',
        ],
    ]) ?>

</div>
