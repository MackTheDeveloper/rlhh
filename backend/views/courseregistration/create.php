<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Courseregistration */

$this->title = Yii::t('yii', 'Create Courseregistration');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Courseregistrations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courseregistration-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
