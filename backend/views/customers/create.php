<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Customers */

$this->title = Yii::t('yii', 'Create Customers');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['menu'][] = ['label'=>'Manage Customers','url'=>['index'],'options'=>['class'=>'widemenu']];
?>
<div class="customers-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
