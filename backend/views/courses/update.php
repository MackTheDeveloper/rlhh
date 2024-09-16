<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Courses */

$this->title = Yii::t('yii', 'Update Course');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Courses'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->course_id, 'url' => ['view', 'id' => $model->course_id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');

$this->params['menu'][] = ['label'=>'Create Course','url'=>['create'],'options'=>['class'=>'widemenu']];
$this->params['menu'][] = ['label'=>'Manage Courses','url'=>['index'],'options'=>['class'=>'widemenu']];
?>
<div class="courses-update">

    

    <?= $this->render('_form', [
        'model' => $model,
        'modelInstallments' => $modelInstallments,
        'modelInstallmentsData' => $modelInstallmentsData,
    ]) ?>

</div>
