<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CoursesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('yii', 'Courses');
$this->params['breadcrumbs'][] = $this->title;

$this->params['menu'][] = ['label'=>'Create Course', 'url'=>['create'],'options'=>['class'=>'widemenu']];
?>
<?php if(Yii::$app->session->getFlash('add')) { echo  '<div class="alert-success">'.Yii::$app->session->getFlash('add').'</div>'; }?>
<?php if(Yii::$app->session->getFlash('update')) { echo  '<div class="alert-info">'.Yii::$app->session->getFlash('update').'</div>'; }?>
<?php if(Yii::$app->session->getFlash('delete')) { echo  '<div class="alert-danger">'.Yii::$app->session->getFlash('delete').'</div>'; }?>
<input type="hidden" id="edit-url" value="<?php echo  Yii::$app->getUrlManager()->createUrl('courses/update'); ?>" >
<div class="courses-index">
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
                                        
                                        <li>". Html::button(Yii::t('yii','Display Under Other Categories') , ['value' => Url::to(['assign-courses/assigntoothercategories', 'id'=>$data->course_id]),'class' => 'actioningridbutton','id'=>'modalbuttonviewdetail'])."</li>
                                            <li>". Html::a('View Scheduling', ['course-schedule/index', 'CourseScheduleSearch[course_id]' => $data->course_name]) ."</li>
                                            </ul>
                                            ". Html::a('<span class="glyphicon glyphicon-trash" data-original-title="" title=""></span>',['courses/delete', 'id' =>$data->course_id],['data-confirm'=>'Are you sure to delete this item?','class'=>'quickactiondelete']) . Html::a('<span class="glyphicon glyphicon-pencil" data-original-title="" title=""></span>',['courses/update', 'id' =>$data->course_id]) ."
                                        </div>";
                                }
                            ],
                    [
                        'attribute' => 'course_category_id',
                        'value' => 'category.name',
                    ],
                    
                    'course_name',
                    
                   
                    
                     [
                    'filterInputOptions'=>['prompt'=>'-- Select --','class'=>'form-control dpauto'],
                    'attribute'=>'type',
                    'filter'=>array("O"=>"Online","C"=>"Class Room"),
                    'value' => function ($data){
                    return $data->type=='O' ? "Online": "Class Room";}
                    ],
                    /* [
                    'attribute' => 'course_date',
                    'value' => 'course_date',    
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
                    ],    */    
                    'time_duration',
                    //'overview:ntext',
                    //'highlight:ntext',
                    'class_size',
                   /* [
                        'attribute' => 'trainer',
                        'value' => function($model)
                            {
                                    return $model->getTrainerName($model->trainer);
                            }
                        //'value' => 'category.name',
                    ], */
               
                    'fees',
            
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
                	'id'=>'w0-deletetask',
                	]
                	],  
                	'bordered' => true,
                	'hover' => true,
                	'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ' -- '],
                          'panel' => [
           'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon glyphicon-user"></i>&nbsp;&nbsp;Courses</h3>',
           ],
           'toolbar' => [
            //'{export}',
             //  $fullExportMenu
           // $export,
        ],   
]);                    
    
?>
    
</div>
<?php
Modal::begin([
'header' => 'Assign To Other Categories',
'id' => 'modalViewDetail',
'size' => 'modal-lg',
'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]
]);
echo "<div id='modalContentViewDetail' class='applicant-popup'></div>";
Modal::end();
?>   