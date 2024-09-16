<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Collaboration */

$this->title = Yii::t('yii', 'Create Collaboration');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Collaborations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'][] = ['label'=>'Manage Collaborations','url'=>['index'],'options'=>['class'=>'widemenu']];
?>
<div class="collaboration-create">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
