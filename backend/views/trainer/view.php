<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Trainer */

$this->title = $model->trainer_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Trainers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trainer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->trainer_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->trainer_id], [
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
            'trainer_id',
            'first_name',
            'last_name',
            'email:email',
            'password',
            'phone_number',
            'status',
            'flagdelete',
            'deleted_by',
            'created_at',
        ],
    ]) ?>

</div>
