<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('yii', 'Internal Users');
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'][] = ['label'=>'Create Internal User', 'url'=>['create'],'options'=>['class'=>'widemenu']];

?>
<?php if(Yii::$app->session->getFlash('add')) { echo  '<div class="alert-success">'.Yii::$app->session->getFlash('add').'</div>'; }?>
<?php if(Yii::$app->session->getFlash('update')) { echo  '<div class="alert-info">'.Yii::$app->session->getFlash('update').'</div>'; }?>
<?php if(Yii::$app->session->getFlash('delete')) { echo  '<div class="alert-danger">'.Yii::$app->session->getFlash('delete').'</div>'; }?>
<input type="hidden" id="edit-url" value="<?php echo  Yii::$app->getUrlManager()->createUrl('users/update'); ?>" >
<div class="users-index">
   <?php $gridColumns = [
                    //['class' => 'kartik\grid\ActionColumn'],
                    [
                                'format' => 'raw',
                                'label' => 'Actions',
                                'headerOptions' => [
                                 'class' => 'kv-align-center kv-align-middle skip-export kv-merged-header',
                                    ],
                                'value' => function ($data) {
                                    
                                    return "<div class='dropdown'>
                                        ". Html::a('<span class="glyphicon glyphicon-trash" data-original-title="" title=""></span>',['users/delete', 'id' =>$data->id],['data-confirm'=>'Are you sure to delete this item?','class'=>'quickactiondelete']) .
                         Html::a('<span class="glyphicon glyphicon-pencil" data-original-title="" title=""></span>',['users/update', 'id' =>$data->id]).
                                            "</div>";
                                }
                            ],
                    'first_name',
                    'last_name',
                    'email:email',
                    'mobile',
                    [
                    'filterInputOptions'=>['prompt'=>'-- Select --','class'=>'form-control dpauto'],
                    'attribute'=>'type',
                    'filter'=>array("A"=>"Admin","SUBA"=>"Sub Admin"),
                    'value' => function ($data){
                    return $data->type=='A' ? "Admin": "Sub Admin";}
                    ],


                        ];   
            echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'resizableColumns'=>false,
            'containerOptions' => ['style'=>'overflow-y: hidden;position: relative;width: 100%;'], // only set when $responsive = false
            'pjax' => true,
            'pjaxSettings' =>[
            'neverTimeout'=>true,
        'loadingCssClass' => true,
            'options'=>[
            'id'=>'w0-deletetask',
            ]
            ],  
            'bordered' => true,
            'hover' => true,
            'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ' -- '],
            'panel' => [
           'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon glyphicon-user"></i>&nbsp;&nbsp;Users</h3>',
           ],
           'toolbar' => [
            //'{export}',
             //  $fullExportMenu
           // $export,
        ],   
]);                    
    
?>

    
</div>
