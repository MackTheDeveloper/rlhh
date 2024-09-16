<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Collaboration */

$this->title = Yii::t('yii', 'Update Collaboration');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Collaborations'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->collaboration_id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');

$this->params['menu'][] = ['label'=>'Create Collaboration','url'=>['create'],'options'=>['class'=>'widemenu']];
$this->params['menu'][] = ['label'=>'Manage Collaborations','url'=>['index'],'options'=>['class'=>'widemenu']];
?>
<div class="collaboration-update">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
