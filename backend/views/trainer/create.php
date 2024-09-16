<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Trainer */

$this->title = Yii::t('yii', 'Create Trainer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Trainers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['menu'][] = ['label'=>'Manage Trainers','url'=>['index'],'options'=>['class'=>'widemenu']];
?>
<div class="trainer-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
