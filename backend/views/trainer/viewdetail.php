<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Trainer */
?>
<div class="detail-container">
    <div class="labeldata">First Name</div><div class="resultdata"><?php echo $model->first_name; ?></div>
    <div class="labeldata">Last Name</div><div class="resultdata"><?php echo $model->last_name; ?></div>
    <div class="labeldata">Email</div><div class="resultdata"><?php echo $model->email; ?></div>
    <div class="labeldata">Contact Number</div><div class="resultdata"><?php echo $model->phone_number; ?></div>
    <div class="labeldata">Practice Contact Number</div><div class="resultdata"><?php echo $model->practice_phone_number; ?></div>
    <div class="labeldata">Status</div><div class="resultdata"><?php echo $model->status == 1 ? 'Active' : 'In Active'; ?></div>
    
    <h4 style="float: left;width: 98%;background-color: #ececec;padding: 7px;margin-bottom: 25px;">Academic Roles</h4>
    <div class="resultdata"><?php echo str_replace(',',', ',$model->acedemic_roles); ?></div>
    
    <h4 style="float: left;width: 98%;background-color: #ececec;padding: 7px;margin-bottom: 25px;">Preferred subjects</h4>
    <?php $dataTrainerSubject = \backend\models\TrainerSubjects::find()->where("trainer_id = $model->trainer_id")->all(); 
    foreach($dataTrainerSubject as $vl)
    { ?>
        <div class="labeldata"><?php echo Yii::$app->params['preferredSubjects'][$vl->subject_name]; ?></div>
        <div class="resultdata"><?php echo str_replace(',',', ',$vl->subject_value); ?></div>
       <?php } ?>
    
    
</div>


