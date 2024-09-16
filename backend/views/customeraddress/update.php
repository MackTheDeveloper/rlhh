<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerAddress */

$this->title = Yii::t('yii', 'Update {modelClass}: ', [
    'modelClass' => 'Customer Address',
]) . $model->customer_address_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Customer Addresses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->customer_address_id, 'url' => ['view', 'id' => $model->customer_address_id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="customer-address-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
