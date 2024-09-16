<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Trainer */

$this->title = Yii::t('yii', 'Update Trainer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Trainers'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->trainer_id, 'url' => ['view', 'id' => $model->trainer_id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');

$this->params['menu'][] = ['label'=>'Create Trainer','url'=>['create'],'options'=>['class'=>'widemenu']];
$this->params['menu'][] = ['label'=>'Manage Trainera','url'=>['index'],'options'=>['class'=>'widemenu']];
?>
<div class="trainer-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
