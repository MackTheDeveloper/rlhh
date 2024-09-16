<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Categories */
$clickCatID = Yii::$app->session->get('currentProdCatId');
if($clickCatID != 0) { $temp = 'Sub'; } else  { $temp = ""; }
$this->title = Yii::t('yii', "Create $temp Category");
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Product Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$this->params['menu'][] = ['label'=>'Manage Categories','url'=>['index'],'options'=>['class'=>'widemenu']];

?>
<div class="categories-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
