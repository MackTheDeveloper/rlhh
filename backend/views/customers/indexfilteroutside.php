<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use kartik\export\ExportMenu;

?>
<?php $gridColumns = [
                    //['class' => 'kartik\grid\ActionColumn'],
                     
                        [    
                    
                                'format' => 'raw',
                                'label' => 'Actions',
                                'filter' => false,
                                'headerOptions' => [
                                'class' => 'kv-align-center kv-align-middle skip-export kv-merged-header',
                                    ],
                                'value' => function ($data) {
                                    
                                    return "<div class='dropdown'>
                                        <button class='fa fa-cogs btn  btn-sm dropdown-toggle' type='button' data-toggle='dropdown'></button>
                                         <ul class='dropdown-menu' style='left:auto;'>
                                        <li>". $data->changestatus($data->status,$data->customer_id)."</li>                                                    
                                        <li>". Html::button(Yii::t('yii','View Detail') , ['value' => Url::to(['customers/viewdetail', 'id'=>$data->customer_id]),'class' => 'actioningridbutton','id'=>'modalbuttonviewdetail'])."</li>
                                            </ul>
                                            ". Html::a('<span class="glyphicon glyphicon-trash" data-original-title="" title=""></span>',['customers/delete', 'id' =>$data->customer_id],['data-confirm'=>'Are you sure to delete this item?','class'=>'quickactiondelete']) ."
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
                    'profession',
                    [
                    'filterInputOptions'=>['prompt'=>'-- Select --','class'=>'form-control dpauto'],
                    'attribute'=>'flag_newsletter',
                    'filter'=>array("Y"=>"Yes","N"=>"No"),
                    'value' => function ($data){
                    return $data->flag_newsletter=='Y' ? "Yes": "No";}
                    ],
                    [
                    'filterInputOptions'=>['prompt'=>'-- Select --','class'=>'form-control dpauto'],
                    'attribute'=>'status',
                    'filter'=>array("1"=>"Active","0"=>"In Active"),
                    'value' => function ($data){
                    return $data->status=='1' ? "Active": "In Active";}
                    ],
                    
                   [
                       'attribute' => 'address_one',
                       'header' => 'Billing Address1',
                       'value' => function($model)
                        {
                            return $model->getBillingAdress($model->customer_id,'B','1');
                        },
                        'hidden'  => true,       
                   ],
                   [
                       'attribute' => 'address_two',
                       'header' => 'Billing Address2',
                       'value' => function($model)
                        {
                            return $model->getBillingAdress($model->customer_id,'B','2');
                        },
                        'hidden'  => true,
                   ],  
                   [
                       'attribute' => 'country',
                       'header' => 'Country',
                       'value' => function($model)
                        {
                            return $model->getCountryStateCityPincode($model->customer_id,'B','Cou');
                        },
                        'hidden'  => true,
                   ],
                   [
                       'attribute' => 'state',
                       'header' => 'State',
                       'value' => function($model)
                        {
                            return $model->getCountryStateCityPincode($model->customer_id,'B','Sta');
                        },
                        'hidden'  => true,
                   ],
                   [
                       'attribute' => 'city',
                       'header' => 'City',
                       'value' => function($model)
                        {
                            return $model->getCountryStateCityPincode($model->customer_id,'B','Cit');
                        },
                        'hidden'  => true,
                   ], 
                                
                   [
                       'attribute' => 'address_one',
                       'header' => 'Shipping Address1',
                       'value' => function($model)
                        {
                            return $model->getBillingAdress($model->customer_id,'S','1');
                        },
                        'hidden'  => true,       
                   ],
                   [
                       'attribute' => 'address_two',
                       'header' => 'Shipping Address2',
                       'value' => function($model)
                        {
                            return $model->getBillingAdress($model->customer_id,'S','2');
                        },
                        'hidden'  => true,
                   ],  
                   [
                       'attribute' => 'country',
                       'header' => 'Country',
                       'value' => function($model)
                        {
                            return $model->getCountryStateCityPincode($model->customer_id,'S','Cou');
                        },
                        'hidden'  => true,
                   ],
                   [
                       'attribute' => 'state',
                       'header' => 'State',
                       'value' => function($model)
                        {
                            return $model->getCountryStateCityPincode($model->customer_id,'S','Sta');
                        },
                        'hidden'  => true,
                   ],
                   [
                       'attribute' => 'city',
                       'header' => 'City',
                       'value' => function($model)
                        {
                            return $model->getCountryStateCityPincode($model->customer_id,'S','Cit');
                        },
                        'hidden'  => true,
                   ],
                                
                        
                    
            ];   ?>
<?php 
    $export = ExportMenu::widget([
		'noExportColumns'=>[0],
		'columns' 			=>  $gridColumns,
		'dataProvider'      =>  $dataProvider,
		'class'             =>  'test123',
		'fontAwesome'       =>  true,
                  'pjaxContainerId' => 'kv-pjax-container1',
                'exportRequestParam' => 'indexofoutsidefiltering',
		'dropdownOptions'   =>  [
		'label' => Yii::t('yii','Export'),
		'title' => Yii::t('yii','Export'),
		'class' => 'btn-warning pull-right'
		],
		'exportConfig' => [
		ExportMenu::FORMAT_TEXT => false,
		ExportMenu::FORMAT_PDF => false,
		ExportMenu::FORMAT_HTML => false,
		ExportMenu::FORMAT_EXCEL => false,
		ExportMenu::FORMAT_EXCEL_X => false,
		],
	]);?>
<?php       
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
        		'id'=>'kv-pjax-container1',
        	] 
    	],   
    	'bordered' => true,
    	'hover' => true,
    	'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ' -- '], 
        'panel' => [
                'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon glyphicon-user"></i>&nbsp;&nbsp;Customers</h3>',
                ],
       
        'toolbar' => [
            //'{export}',
             //  $fullExportMenu
            $export,
        ],                        
]);          
    
?>
   