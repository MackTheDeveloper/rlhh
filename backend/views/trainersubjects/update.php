<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TrainerSubjects */

$this->title = Yii::t('yii', 'Update {modelClass}: ', [
    'modelClass' => 'Trainer Subjects',
]) . $model->trainer_subject_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Trainer Subjects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->trainer_subject_id, 'url' => ['view', 'id' => $model->trainer_subject_id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="trainer-subjects-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
