<?php

use yii\helpers\Html;



/* @var $this yii\web\View */
/* @var $model backend\models\Users */

$this->title = Yii::t('yii', 'Create Internal User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Internal Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['menu'][] = ['label'=>'Manage Internal Users','url'=>['index'],'options'=>['class'=>'widemenu']];
?>
<div class="users-create">
<!--    <h1><?= Html::encode($this->title) ?></h1>-->
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
