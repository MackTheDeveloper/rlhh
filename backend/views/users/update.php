<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */

$this->title = Yii::t('yii', 'Update Internal User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Internal Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');

$this->params['menu'][] = ['label'=>'Create Internal User','url'=>['create'],'options'=>['class'=>'widemenu']];
$this->params['menu'][] = ['label'=>'Manage Internal Users','url'=>['index'],'options'=>['class'=>'widemenu']];
?>
<div class="users-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
