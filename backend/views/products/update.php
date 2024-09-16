<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Products */

$this->title = Yii::t('yii', 'Update Product');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->product_id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');

$this->params['menu'][] = ['label'=>'Create Product','url'=>['create'],'options'=>['class'=>'widemenu']];
$this->params['menu'][] = ['label'=>'Manage Products','url'=>['index'],'options'=>['class'=>'widemenu']];
?>
<div class="products-update">



    <?= $this->render('_form', [
        'model' => $model,
        'modelProductMaterials' => $modelProductMaterials,
    ]) ?>

</div>
