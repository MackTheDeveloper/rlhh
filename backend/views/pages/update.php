<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Pages */

$this->title = Yii::t('yii', 'Update {modelClass}: ', [
    'modelClass' => 'Pages',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->page_id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="pages-update">
    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
