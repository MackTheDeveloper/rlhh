<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Courses */

$this->title = Yii::t('yii', 'Create Courses');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'][] = ['label'=>'Manage Courses','url'=>['index'],'options'=>['class'=>'widemenu']];
?>
<div class="courses-create">

    

    <?= $this->render('_form', [
        'model' => $model,
        'modelInstallments' => $modelInstallments,
    ]) ?>

</div>
