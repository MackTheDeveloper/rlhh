<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */

$this->title = $model->first_name .' '. $model->last_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
            Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ])
        ?>
    </p>
    <?php
        //var_dump($model->status);
        $model->type = $model->type == 'A' ? 'Admin' : 'Subadmin';
    ?>
    <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'first_name',
                'last_name',
                'email:email',
                //'password',
                'mobile',
                'type',
                'created',
                'updated',
            ],
        ])
    ?>

</div>
