<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Courseregistration */

$this->title = Yii::t('yii', 'Update {modelClass}: ', [
    'modelClass' => 'Courseregistration',
]) . $model->courseregistration_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Courseregistrations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->courseregistration_id, 'url' => ['view', 'id' => $model->courseregistration_id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="courseregistration-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
