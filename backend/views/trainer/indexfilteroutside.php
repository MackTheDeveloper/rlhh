<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$gridColumns = [
                    //['class' => 'kartik\grid\ActionColumn'],
                    [
                                'format' => 'raw',
                                'label' => 'Actions',
                         'headerOptions' => [
                                'class' => 'kv-align-center kv-align-middle skip-export kv-merged-header',
                                    ],
                               'value' => function ($data) {
                                    
                                    return "<div class='dropdown'>
                                        <button class='fa fa-cogs btn  btn-sm dropdown-toggle' type='button' data-toggle='dropdown'></button>
                                            <ul class='dropdown-menu' style='left:auto;'>
<li>". $data->changestatus($data->status,$data->trainer_id)."</li>                                                    
<li>". Html::button(Yii::t('yii','View Detail') , ['value' => Url::to(['trainer/viewdetail', 'id'=>$data->trainer_id]),'class' => 'actioningridbutton','id'=>'modalbuttonviewdetail'])."</li>
</ul>
                                            ". Html::a('<span class="glyphicon glyphicon-trash" data-original-title="" title=""></span>',['trainer/delete', 'id' =>$data->trainer_id],['data-confirm'=>'Are you sure to delete this item?','class'=>'quickactiondelete']) . Html::a('<span class="glyphicon glyphicon-pencil" data-original-title="" title=""></span>',['trainer/update', 'id' =>$data->trainer_id]) ."
                                        </div>";
                                }
                            ],
                    [
                    'attribute' => 'created_at',
                    'value' => 'created_at',    
                    //'value' => function($model)  {  return date('Y-m-d H:i:s', strtotime($model->created_at)); },
                    'filterType' => GridView::FILTER_DATE,
                    'filterWidgetOptions' => [
                            'options' => ['placeholder' => 'Enter date ...'], //this code not giving any changes in browser
                            'type' => DatePicker::TYPE_COMPONENT_APPEND, //this give error Class 'DatePicker' not found
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ],
                        ],
                    //'format' => ['date','php:Y-m-d'],
                    ],
                    'first_name',
                    'last_name',
                    'email:email',
                    'phone_number',
                    'practice_phone_number',
                    [
                    'filterInputOptions'=>['prompt'=>'-- Select --','class'=>'form-control dpauto'],
                    'attribute'=>'status',
                    'filter'=>array("1"=>"Active","0"=>"In Active"),
                    'value' => function ($data){
                    return $data->status=='1' ? "Active": "In Active";}
                    ],
                    
            ];   
echo GridView::widget([
                	'dataProvider' => $dataProvider,
                	'filterModel' => $searchModel,
                	'columns' => $gridColumns,
                	'resizableColumns'=>false,
                	'containerOptions' => ['style'=>'overflow-y: scroll;position: relative;width: 100%;'], // only set when $responsive = false
                	'pjax' => true,
                	'pjaxSettings' =>[
                	'neverTimeout'=>true,
                    'loadingCssClass' => true,
                	'options'=>[
                	'id'=>'w0-trainer',
                	]
                	],  
                	'bordered' => true,
                	'hover' => true,
                	'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ' -- '],
    'panel' => [
                'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon glyphicon-user"></i>&nbsp;&nbsp;Trainers</h3>',
                ],
                'toolbar' => [
                    //'{export}',
                    //$fullExportMenu
                    ],  
]);                    
    
?>
    


