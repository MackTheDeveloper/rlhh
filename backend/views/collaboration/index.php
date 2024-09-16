<?php

use yii\helpers\Html;

use yii\widgets\Pjax;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CollaborationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('yii', 'Collaborations');
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'][] = ['label'=>'Create Collaboration', 'url'=>['create'],'options'=>['class'=>'widemenu']];
?>
<?php if(Yii::$app->session->getFlash('add')) { echo  '<div class="alert-success">'.Yii::$app->session->getFlash('add').'</div>'; }?>
<?php if(Yii::$app->session->getFlash('update')) { echo  '<div class="alert-info">'.Yii::$app->session->getFlash('update').'</div>'; }?>
<?php if(Yii::$app->session->getFlash('delete')) { echo  '<div class="alert-danger">'.Yii::$app->session->getFlash('delete').'</div>'; }?>

<input type="hidden" id="edit-url" value="<?php echo  Yii::$app->getUrlManager()->createUrl('collaboration/update'); ?>" >

<div class="collaboration-index">
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
                                        ". Html::a('<span class="glyphicon glyphicon-trash" data-original-title="" title=""></span>',['collaboration/delete', 'id' =>$data->collaboration_id],['data-confirm'=>'Are you sure to delete this item?','class'=>'quickactiondelete']) .
                         Html::a('<span class="glyphicon glyphicon-pencil" data-original-title="" title=""></span>',['collaboration/update', 'id' =>$data->collaboration_id]).
                                            "</div>";
                                }
                            ],
                    [
                     'attribute' => 'title',   
                    'format' => 'raw',
		'value'  => function($data){
                        //return substr(strip_tags($data->note),0,45).'.....';
			//return substr(strip_tags(html_entity_decode(trim($data->note))),0,30).'.....';
                        return substr(html_entity_decode(trim($data->title)),0,30). "...";
                        //return Html::tag('div',Html::encode(strip_tags(html_entity_decode($data->note))),['title'=>$data->note]);
		},
                   ],
                        [
                     'attribute' => 'description',   
                    'format' => 'raw',
		'value'  => function($data){
                        //return substr(strip_tags($data->note),0,45).'.....';
			//return substr(strip_tags(html_entity_decode(trim($data->note))),0,30).'.....';
                        return substr(html_entity_decode(trim($data->description)),0,30). "...";
                        //return Html::tag('div',Html::encode(strip_tags(html_entity_decode($data->note))),['title'=>$data->note]);
		},
                   ],
                        
                  
                   [
                        'attribute' => 'image',
                        'format' => 'raw',
                        'value' => function($model)
                            {
                                if(file_exists(Yii::getAlias('@backend').'/web/images/collaboration/'.$model->image) && $model->image != "")
                                return Html::a(Html::img(Yii::getAlias('@web').'/images/collaboration/'.$model->image,['width'=>'50','height'=>'50']),Yii::getAlias('@web').'/images/collaboration/'.$model->image,['data-pjax' => '0','target'=>'_blank']);
                            }
                    ], 
                    [
                        'attribute' => 'logo',
                        'format' => 'raw',
                        'value' => function($model)
                            {
                                if(file_exists(Yii::getAlias('@backend').'/web/images/collaboration/'.$model->logo) && $model->logo != "")
                                return Html::a(Html::img(Yii::getAlias('@web').'/images/collaboration/'.$model->logo,['width'=>'50','height'=>'50']),Yii::getAlias('@web').'/images/collaboration/'.$model->logo,['data-pjax' => '0','target'=>'_blank']);
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
                'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon glyphicon-user"></i>&nbsp;&nbsp;Collaborations</h3>',
                ],
                'toolbar' => [
                    //'{export}',
                    //$fullExportMenu
                    ],  
]);                    
    
?>
  
</div>
