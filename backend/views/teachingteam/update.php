<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Teachingteam */

$this->title = Yii::t('yii', 'Update Team Member');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Teaching Team'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->teaching_team_id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');

$this->params['menu'][] = ['label'=>'Create Team Member','url'=>['create'],'options'=>['class'=>'widemenu']];
$this->params['menu'][] = ['label'=>'Manage Team','url'=>['index'],'options'=>['class'=>'widemenu']];
?>
<div class="teachingteam-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
