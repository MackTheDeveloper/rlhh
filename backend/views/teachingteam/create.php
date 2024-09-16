<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Teachingteam */

$this->title = Yii::t('yii', 'Create Team Member');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Teaching Team'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'][] = ['label'=>'Manage Team','url'=>['index'],'options'=>['class'=>'widemenu']];
?>
<div class="teachingteam-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
