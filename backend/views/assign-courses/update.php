<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AssignCourses */

$this->title = Yii::t('yii', 'Update {modelClass}: ', [
    'modelClass' => 'Assign Courses',
]) . $model->assign_course_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Assign Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->assign_course_id, 'url' => ['view', 'id' => $model->assign_course_id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="assign-courses-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
