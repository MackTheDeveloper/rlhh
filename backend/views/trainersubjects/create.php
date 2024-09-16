<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TrainerSubjects */

$this->title = Yii::t('yii', 'Create Trainer Subjects');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Trainer Subjects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trainer-subjects-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
