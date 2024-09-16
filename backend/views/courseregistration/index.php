<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CourseregistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('yii', 'Registrations');
$this->params['breadcrumbs'][] = $this->title;

//$this->params['menu'][] = ['label'=>'Create Registration', 'url'=>['create'],'options'=>['class'=>'widemenu']];
?>
<?php if(Yii::$app->session->getFlash('add')) { echo  '<div class="alert-success">'.Yii::$app->session->getFlash('add').'</div>'; }?>
<?php if(Yii::$app->session->getFlash('update')) { echo  '<div class="alert-info">'.Yii::$app->session->getFlash('update').'</div>'; }?>
<div class="alert-info alert-info-ajax" style="display: none"></div>
<?php if(Yii::$app->session->getFlash('delete')) { echo  '<div class="alert-danger">'.Yii::$app->session->getFlash('delete').'</div>'; }?>

<div class="courseregistration-index">

<div class="div_filter_outside">
<?php 
$model = $filterModel;
$form = ActiveForm::begin(['id' => 'filteroutside' , 'action' => ['filteroutside']]); ?>

 <?php
    echo $form->field($model, 'from_date')->widget(DatePicker::classname(), [
		'options' => ['placeholder' => '-- From Date --'],
		'pluginOptions' => [
			//'format' => 'yyyy-mm-dd',
                           'format' => 'dd-mm-yyyy', 
			'todayHighlight' => true,
			'autoclose'=>true,
			'orientation' => 'bottom left',
		]
	]);?>

 <?php
    echo $form->field($model, 'to_date')->widget(DatePicker::classname(), [
		'options' => ['placeholder' => '-- To Date --'],
		'pluginOptions' => [
			//'format' => 'yyyy-mm-dd',
                            'format' => 'dd-mm-yyyy',
			'todayHighlight' => true,
			'autoclose'=>true,
			'orientation' => 'bottom left',
		]
	]);?> 
    <?php
    $dataCustomer = backend\models\Customers::find()->where("flagdelete = 'N'")->all();
    $allCustomers = \yii\helpers\ArrayHelper::map($dataCustomer,'customer_id', function($model) { return $model->last_name.' '.$model->first_name; });
     echo $form->field($model, 'customer_id')
                    ->widget(Select2::classname(), [
                        'data' => $allCustomers,
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                           // 'multiple' => true
                        ],
            ]);
    
    ?> 
    <?php
    $dataCourse = backend\models\Courses::find()->where("flagdelete = 'N'")->all();
    $allCourse = \yii\helpers\ArrayHelper::map($dataCourse,'course_id','course_name');
     echo $form->field($model, 'course_id')
                    ->widget(Select2::classname(), [
                        'data' => $allCourse,
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            //'multiple' => true
                        ],
            ]);
    
    ?> 
    <?php
     echo $form->field($model, 'status_registration')
                    ->widget(Select2::classname(), [
                        'data' => ["All"=>"All","Paid"=>"Paid","Unpaid"=>"Unpaid"],
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            //'multiple' => true
                        ],
            ]);
    
    ?> 
    
    <?php echo Html::hiddenInput('Courseregistration[tt]','ind'); ?>
    
    
    
    <div class="row rowbtn">
        <div class="form-group form-group-btn-filteroutside">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Search') : Yii::t('yii', 'Search'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
        
        </div>       
     </div>

<?php ActiveForm::end(); ?>
</div>    
<div id="partial-container">
<?php $gridColumns = [
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
    </div>
   </div>
<script>
    $(document).on("click", ".change-status-course-registration", function (e) {
                    e.preventDefault();
                    var id = $(this).attr('id');
                    if (confirm("Are you sure you want to change status ?") == true) {
                        $.ajax({
                            type: "POST",
                            data: "id=" + id,
                            url: '<?php echo Yii::$app->urlManager->createUrl("courseregistration/changecourseregistrationstatus") ?>',
                            success: function (response) {
                                $(".alert-info-ajax").show();
                                $(".alert-info-ajax").html(response).fadeIn().fadeOut(2000);
                                $.pjax.reload({container: '#w0-courseregistration'});
                            },
                            error: function (MLHttpRequest, textStatus, errorThrown) {
                                alert(errorThrown);
                            }
                });
            }
        });
        
        $(document).ready(function(){
                $('body').on('beforeSubmit', '#filteroutside', function (event) {
                    
                    if($('#courseregistration-from_date').val() != "")
                    {
                        if($('#courseregistration-to_date').val() == "")
                        {
                            $('.field-courseregistration-to_date').removeClass('has-success');
                            $('.field-courseregistration-to_date').addClass('required has-error');
                            $('#courseregistration-to_date-kvdate').next('.help-block').text("To Date cannot be blank");
                        }
                    }else{
                        $('#courseregistration-to_date').val("");
                    }
                    
                    
                    var form = $(this);
                    if (form.find('.has-error').length) {return false;}

                $("#loading").show();
                // REMOVE QUERY STRING AND SET DEFAULT URL
                    if (history.pushState) {
                      //  var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?r=customers%2Findex';
                        var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                        window.history.pushState({path:newurl},'',newurl);
                    }
                $.ajax({
                            type: 'post',
                            url: '<?php echo Yii::$app->urlManager->createUrl(['courseregistration/filteroutside']); ?>',
                            data : $(this).serialize(),
                            success: function (response) {

                              $("#loading").hide();
                              $("#partial-container").html(response);
                      return false; 
                            },
                    error:function(){

                        return false;
                    }
                    });
                event.preventDefault();
                    event.stopImmediatePropagation(); 
                return false;

            });  
            })
        
</script>        