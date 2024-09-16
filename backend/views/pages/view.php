<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Pages */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-view">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->
    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->page_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->page_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php
        //var_dump($model->status);
        $model->status = $model->status == 1 ? 'Active' : 'Inactive';
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'page_id',
            'name',
            'slug',
            [
                'format' => 'raw',
                'attribute' => 'content',
                //'value' => html_entity_decode($model->content),
            ],
            
             
               
            'seo_title',
            'seo_description',
            'status',
//            'flagdelete',
//            'deleted_at',
//            'deleted_by',
//            'created_on',
        ],
    ]) ?>

</div>
