<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
$gridColumns = [
                    //['class' => 'kartik\grid\ActionColumn'],
                     [
                                'format' => 'raw',
                                'label' => 'Actions',
                                'headerOptions' => [
                                 'class' => 'kv-align-center kv-align-middle skip-export kv-merged-header',
                                    ],
                                'value' => function ($data) {
                                     if($data->status_registration != 'Paid') {  
                                    return "<div class='dropdown'>
                                        <button class='fa fa-cogs btn  btn-sm dropdown-toggle' type='button' data-toggle='dropdown'></button>
                                         <ul class='dropdown-menu' style='left:auto;'>
                                         <li>". $data->changestatusOfcourseRegistration($data->status_registration,$data->courseregistration_id)."</li>
                                        <li>". Html::button(Yii::t('yii','View Detail') , ['value' => Url::to(['courseregistration/viewdetail', 'id'=>$data->courseregistration_id]),'class' => 'actioningridbutton','id'=>'modalbuttonviewdetail'])."</li>
                                            </ul>
                                        ". //Html::a('<span class="glyphicon glyphicon-trash" data-original-title="" title=""></span>',['teachingteam/delete', 'id' =>$data->courseregistration_id],['data-confirm'=>'Are you sure to delete this item?','class'=>'quickactiondelete']) .
                         //Html::a('<span class="glyphicon glyphicon-pencil" data-original-title="" title=""></span>',['teachingteam/update', 'id' =>$data->courseregistration_id]).
                                            "</div>";
                                }else{
                                    return "<div class='dropdown'>
                                        <button class='fa fa-cogs btn  btn-sm dropdown-toggle' type='button' data-toggle='dropdown'></button>
                                         <ul class='dropdown-menu' style='left:auto;'>
                                         <li>". Html::button(Yii::t('yii','View Detail') , ['value' => Url::to(['courseregistration/viewdetail', 'id'=>$data->courseregistration_id]),'class' => 'actioningridbutton','id'=>'modalbuttonviewdetail'])."</li>
                                            </ul>
                                        ". //Html::a('<span class="glyphicon glyphicon-trash" data-original-title="" title=""></span>',['teachingteam/delete', 'id' =>$data->courseregistration_id],['data-confirm'=>'Are you sure to delete this item?','class'=>'quickactiondelete']) .
                         //Html::a('<span class="glyphicon glyphicon-pencil" data-original-title="" title=""></span>',['teachingteam/update', 'id' =>$data->courseregistration_id]).
                                            "</div>";
                                }
                                }
                    ],
                    [
                        'attribute' => 'course_id',
                        'value' => 'course.course_name',
                    ],
                                    [
                        'attribute' => 'customer_id',
                        'value' => function($model)
                            {
                                return $model->getCustomerName($model->customer_id);
                            }
                    ],
                    [
                    'attribute' => 'registration_date',
                    'value' => 'registration_date',    
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
                    
                    'amount',
                    [
                    'filterInputOptions'=>['prompt'=>'-- Select --','class'=>'form-control dpauto'],
                    'attribute'=>'status_registration',
                    'filter'=>array("All"=>"All","Paid"=>"Paid","Unpaid"=>"Unpaid"),
                    'value' => function ($data){
                    return $data->status_registration == 'All' ? "All" : ($data->status_registration == "Paid" ? "Paid" : "Unpaid");}
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
                	'id'=>'w0-courseregistration',
                	]
                	],  
                	'bordered' => true,
                	'hover' => true,
                	'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ' -- '],
                'panel' => [
                'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon glyphicon-user"></i>&nbsp;&nbsp;Registrations</h3>',
                ],
                'toolbar' => [
                    //'{export}',
                    //$fullExportMenu
                    ],  
]);                    
    
?>