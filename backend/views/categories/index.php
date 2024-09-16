<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('yii', 'Course Categories');
$this->params['breadcrumbs'][] = $this->title;



$this->params['menu'][] = ['label'=>'Create Category', 'url'=>['create'],'options'=>['class'=>'widemenu']];


?>
<?php if(Yii::$app->session->getFlash('add')) { echo  '<div class="alert-success">'.Yii::$app->session->getFlash('add').'</div>'; }?>
<?php if(Yii::$app->session->getFlash('update')) { echo  '<div class="alert-info">'.Yii::$app->session->getFlash('update').'</div>'; }?>
<?php if(Yii::$app->session->getFlash('delete')) { echo  '<div class="alert-danger">'.Yii::$app->session->getFlash('delete').'</div>'; }?>
<input type="hidden" id="edit-url" value="<?php echo  Yii::$app->getUrlManager()->createUrl('categories/update'); ?>" >
<div class="categories-index">
<div class="genericSearchContainer">
<?php 
echo Html::textInput('genericSearch','',['id'=>'genericSearch','class'=>'form-control searchgeneric','placeholder'=>'-- Search Category --']);
?>
</div>
 <?php $gridColumns = [
                   // ['class' => 'kartik\grid\ActionColumn'],
                     [
                                'format' => 'raw',
                                'label' => 'Actions',
                                'headerOptions' => [
                                 'class' => 'kv-align-center kv-align-middle skip-export kv-merged-header',
                                    ],
                                'value' => function ($data) {
                                    
                                    return "<div class='dropdown'>
                                        ". Html::a('<span class="glyphicon glyphicon-trash" data-original-title="" title=""></span>',['categories/delete', 'id' =>$data->category_id],['data-confirm'=>'Are you sure to delete this item?','class'=>'quickactiondelete']) .
                         Html::a('<span class="glyphicon glyphicon-pencil" data-original-title="" title=""></span>',['categories/update', 'id' =>$data->category_id]).
                                            "</div>";
                                }
                            ],
                    //'category_id',
                    //'parent_id',
                    //'name',
                    [
                    'filterInputOptions'=>['prompt'=>'-- Select --','class'=>'form-control dpauto'],
                    'attribute'=>'type',
                    'filter'=>array("C"=>"Course","W"=>"Webinar"),
                    'value' => function ($data){
                    return $data->type=='C' ? "Course": "Webinar";}
                    ],
                    [
                        'format' => 'raw',
                        'attribute' => 'name',
                        'value' => function($model)
                            {
                                $checkHasSubCatOrNot = $model->checkHasSubCatOrNot($model->category_id);
                                if($checkHasSubCatOrNot == 1)
                                {
                                    $url = Yii::$app->urlManager->createUrl(['categories/indexsubcategory', 'id' => $model->category_id]);
                                    return Html::a($model->name, $url, ['title' => Yii::t('yii','Go To Sub-Categories'), 'class' => 'class_ina link-color']);
                                }else{
                                    //return $model->name;
                                    $url = Yii::$app->urlManager->createUrl(['categories/indexsubcategory', 'id' => $model->category_id]);
                                    return Html::a($model->name, $url, ['title' => Yii::t('yii','Go To Sub-Categories'), 'class' => 'class_ina link-color']);
                                }
                            }
                    ],    
                        
                    [
                        'format' => 'raw',
                        'attribute' => 'description',
                        'value' => function($model)
                        {
                            return html_entity_decode($model->description);
                        }
                    ],
                    
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
           'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon glyphicon-user"></i>&nbsp;&nbsp;Categories</h3>',
           ],
           'toolbar' => [
            //'{export}',
             //  $fullExportMenu
           // $export,
        ],   
]);                    
    
?>
    
</div>
<script>
    $(document).ready(function () {
     // -- Start Key up on customer
         $('#genericSearch').keyup(function(){
                    if($(this).val().length >= 0)
                   {
                   var enterdTextOfCustomer = $(this).val();
                   $.ajax({
                                     url:'<?php echo Yii::$app->urlManager->createUrl(['categories/getcategories']); ?>',
                                     type:"POST",
                                    dataType:"JSON",
                                     data : {enterdtext:enterdTextOfCustomer},
                                     success:function (output) {
                                         console.log(output);
                                         $( "#genericSearch" ).autocomplete({
                                              select: function(event, ui) {
                                                    event.preventDefault();
                                                    $("#genericSearch").val(ui.item.label);
                                                    
                                                    var urlViewDetail = '<?php echo Yii::$app->urlManager->createUrl(['categories/indexsubcategory']); ?>';
                                                     urlViewDetail += '?id='+ui.item.value;
                                                            $.ajax({
                                                                    url: urlViewDetail,
                                                                    type: "POST",
                                                                    success: function (output) {
                                                                    }
                                                                });
                                                    },
                                                focus: function(event, ui) {
                                                    event.preventDefault();
                                                    $("#genericSearch").val(ui.item.label);
                                                },
                                                change: function(event,ui)
                                                          {
                                                          if (ui.item==null || typeof(ui.item) == "undefined")
                                                              {
                                                                       $('#genericSearch').val("");
                                                              }
                                                          },
                                             source: output,
                                            // minLength:1,  
                                          });
                                     },
                                     error: function()
                                     { }
                           });
                           }  
            });
           // -- End Key up on customer  
           });
</script>