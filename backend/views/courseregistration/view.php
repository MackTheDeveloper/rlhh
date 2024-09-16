<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Courseregistration */

$this->title = $model->courseregistration_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Courseregistrations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courseregistration-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->courseregistration_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->courseregistration_id], [
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
            'courseregistration_id',
            'course_id',
            'customer_id',
            'registration_date',
            'amount',
            'status_registration',
            'status',
            'flagdelete',
            'deleted_by',
            'created_at',
        ],
    ]) ?>

</div>
