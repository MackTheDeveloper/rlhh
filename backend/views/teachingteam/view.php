<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Teachingteam */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Teachingteams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teachingteam-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->teaching_team_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->teaching_team_id], [
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
            'teaching_team_id',
            'title',
            'description:ntext',
            'image',
            'status',
            'flagdelete',
            'deleted_by',
            'created_at',
        ],
    ]) ?>

</div>
