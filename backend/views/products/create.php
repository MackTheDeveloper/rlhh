<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Products */

$this->title = Yii::t('yii', 'Create Products');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['menu'][] = ['label'=>'Manage Products','url'=>['index'],'options'=>['class'=>'widemenu']];
?>
<div class="products-create">

    

    <?= $this->render('_form', [
        'model' => $model,
        'modelProductMaterials' => $modelProductMaterials,
    ]) ?>

</div>
