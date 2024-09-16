<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductMaterials */

$this->title = Yii::t('yii', 'Update {modelClass}: ', [
    'modelClass' => 'Product Materials',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Product Materials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->material_id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="product-materials-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
