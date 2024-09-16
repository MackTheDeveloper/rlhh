<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Categories */

$datacheckParent = \backend\models\ProductCategories::find()->where("category_id = ".Yii::$app->request->get('id'))->one();
if($datacheckParent->parent_id != 0) { $temp = 'Sub'; } else  { $temp = ""; }

$this->title = Yii::t('yii', "Update $temp Category");
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Product Categories'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->category_id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');

$this->params['menu'][] = ['label'=>"Create $temp Category",'url'=>['create'],'options'=>['class'=>'widemenu']];
$this->params['menu'][] = ['label'=>'Manage Categories','url'=>['index'],'options'=>['class'=>'widemenu']];
?>
<div class="categories-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
