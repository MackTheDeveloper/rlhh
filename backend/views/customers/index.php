<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CustomersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('yii', 'Website Users');
$this->params['breadcrumbs'][] = $this->title;
//$this->params['menu'][] = ['label'=>'Export', 'url'=>['create'],'options'=>['class'=>'widemenu']];
?>
<?php if(Yii::$app->session->getFlash('add')) { echo  '<div class="alert-success">'.Yii::$app->session->getFlash('add').'</div>'; }?>
<?php if(Yii::$app->session->getFlash('update')) { echo  '<div class="alert-info">'.Yii::$app->session->getFlash('update').'</div>'; }?>
<div class="alert-info alert-info-ajax" style="display: none"></div>
<?php if(Yii::$app->session->getFlash('delete')) { echo  '<div class="alert-danger">'.Yii::$app->session->getFlash('delete').'</div>'; }?>


<div class="customers-index">
 <div class="div_filter_outside div_filter_outside_customers">
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
     echo $form->field($model, 'profession')
                    ->widget(Select2::classname(), [
                        'data' => Yii::$app->params['customerProfessions'],
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            //'multiple' => true
                        ],
            ]);
    
    ?> 
     
     <?php
     echo $form->field($model, 'flag_newsletter')->radioList([ 'Y' => 'Yes', 'N' => 'No' ]);
     ?>
    
    <?php echo Html::hiddenInput('Customers[tt]','ind'); ?>
    
    
    
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
                   'pjaxContainerId' => 'kv-pjax-container',
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
        	'id'=>'kv-pjax-container',
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
    </div>    
    </div>    
    
 <?php
Modal::begin([
'header' => 'Customer Detail',
'id' => 'modalViewDetail',
'size' => 'modal-lg',
'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]
]);
echo "<div id='modalContentViewDetail' class='applicant-popup'></div>";
Modal::end();
?>   

</div>
<script>
    $(document).on("click", ".change-status", function (e) {
                    e.preventDefault();
                    var id = $(this).attr('id');
                    if (confirm("Are you sure you want to change status ?") == true) {
                        $.ajax({
                            type: "POST",
                            data: "id=" + id,
                            url: '<?php echo Yii::$app->urlManager->createUrl("customers/changestatus") ?>',
                            success: function (response) {
                                $(".alert-info-ajax").show();
                                $(".alert-info-ajax").html(response).fadeIn().fadeOut(2000);
                                $.pjax.reload({container: '#w0-trainer'});
                            },
                            error: function (MLHttpRequest, textStatus, errorThrown) {
                                alert(errorThrown);
                            }
                });
            }
        });
        
        $(document).ready(function(){
                $('body').on('beforeSubmit', '#filteroutside', function (event) {
                    
                    if($('#customers-from_date').val() != "")
                    {
                        if($('#customers-to_date').val() == "")
                        {
                            $('.field-customers-to_date').removeClass('has-success');
                            $('.field-customers-to_date').addClass('required has-error');
                            $('#customers-to_date-kvdate').next('.help-block').text("To Date cannot be blank");
                        }
                    }else{
                        $('#customers-to_date').val("");
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
                            url: '<?php echo Yii::$app->urlManager->createUrl(['customers/filteroutside']); ?>',
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