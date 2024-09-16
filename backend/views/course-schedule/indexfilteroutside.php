<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\date\DatePicker;
?>

<?php $gridColumns = [
            //['class' => 'kartik\grid\ActionColumn'],
            [
                                'format' => 'raw',
                                'label' => 'Action',
                                'headerOptions' => [
                                'class' => 'kv-align-center kv-align-middle skip-export kv-merged-header',
                                    ],
                                'value' => function ($data) {
                                    
                                    return "<div class='dropdown'>
                                        <button class='fa fa-cogs btn  btn-sm dropdown-toggle' type='button' data-toggle='dropdown'></button>
                                            <ul class='dropdown-menu' style='left:auto;'>
<li>". $data->changestatus($data->status,$data->course_schedule_id)."</li>                                                    
                                            </ul>
                                            ". Html::a('<span class="glyphicon glyphicon-trash" data-original-title="" title=""></span>',['course-schedule/delete', 'id' =>$data->course_schedule_id],['data-confirm'=>'Are you sure to delete this item?','class'=>'quickactiondelete']) . Html::a('<span class="glyphicon glyphicon-pencil" data-original-title="" title=""></span>',['course-schedule/update', 'id' =>$data->course_schedule_id]) ."
                                        </div>";
                                }
                            ],
            [
                'attribute' => 'course_id',
                'value' => 'course.course_name',
            ],
                                    [
                'attribute' => 'course_category',
                'value' => function($model)
                            {
                            return $model->getCourseCatName($model->course_id);
                            }
            ],
            [
                'attribute' => 'trainer_ids',
                'value' => function($model) {
                    return str_replace(',',', ',$model->getTrainerName($model->trainer_ids));
                }
            //'value' => 'category.name',
            ],
            [
                'attribute' => 'from_date',
                'value' => 'from_date',
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
            [
                'attribute' => 'to_date',
                'value' => 'to_date',
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
            [
                'attribute' => 'from_time',
                'header' => 'Timing',
                'headerOptions' => [
                    'class' => 'custcoloringirdheader',
                ],
                'value' => function($model) {
                    return $model->from_time . ' ~ ' . $model->to_time;
                }
            ],
            [
                'attribute' => 'fees',
                'header' => 'Fees '.Yii::$app->params['currencySymbol'],
                'headerOptions' => [
                    'class' => 'custcoloringirdheader',
                ],
                'value' => 'course.fees',
            ],
            'location',
            [
                'attribute' => 'class_size',
                'headerOptions' => [
                    'class' => 'custcoloringirdheader',
                ],
                'header' => 'Seats',
                'value' => 'course.class_size',
            ],
            'days',
            [
                'filterInputOptions' => ['prompt' => '-- Select --', 'class' => 'form-control dpauto'],
                'attribute' => 'status',
                'filter' => array("1" => "Active", "0" => "In Active"),
                'value' => function ($data) {
                    return $data->status == '1' ? "Active" : "In Active";
                }
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
                	'id'=>'w0-schedule',
                	]
                	],  
                	'bordered' => true,
                	'hover' => true,
                	'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ' -- '],
                          'panel' => [
           'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon glyphicon-user"></i>&nbsp;&nbsp;Schedules</h3>',
           ],
           'toolbar' => [
            //'{export}',
             //  $fullExportMenu
           // $export,
        ],   
]);                    
    
?>   
