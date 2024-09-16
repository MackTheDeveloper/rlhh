<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\ProductCategories;
use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\Categories */
/* @var $form yii\widgets\ActiveForm */
$currentCategory = Yii::$app->session->get('currentProdCatId');
//echo $currentCategory;
?>

<div class="categories-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
     <?php 
     
            if($currentCategory == 0)
            {
            $categoryAll = ProductCategories::find()->where(['flagdelete'=>'0','status'=>'1','parent_id'=>$currentCategory])->all();
            $categoruData = ArrayHelper::map($categoryAll,'category_id','name');
            //echo $form->field($model, 'parent_id')->dropDownList($categoruData,['prompt'=>'-- Select --']);
            /*echo $form->field($model, 'parent_id')
                                ->widget(Select2::classname(), [
                                    'data' => $categoruData,
                                    'options' => ['placeholder' => '-- Select --'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        //'multiple' => true
                                    ],
                        ]); */
            }
            else
            {
                if(!$model->isNewRecord)
                $categoryAll = ProductCategories::find()->where(['flagdelete'=>'0','status'=>'1','category_id'=>$currentCategory])->all();
                else{
                $check = ProductCategories::find()->where("category_id =  $currentCategory")->one(); //$model->checkHasSubCatOrNot($currentCategory);    
                  if($check->parent_id == 0)  
                    $categoryAll = ProductCategories::find()->where(['flagdelete'=>'0','status'=>'1','parent_id'=>0])->all();
                  else
                    $categoryAll = ProductCategories::find()->where(['flagdelete'=>'0','status'=>'1','parent_id'=>$check->parent_id])->all();  
                }  
                $model->parent_id = $currentCategory;
                $categoruData = ArrayHelper::map($categoryAll,'category_id','name');
                echo $form->field($model, 'parent_id')
                                ->widget(Select2::classname(), [
                                    'data' => $categoruData,
                                    'options' => ['placeholder' => '-- Select --'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        //'multiple' => true
                                    ],
                        ]);
            
            }
           ?>
    
     <?php if($currentCategory == 0)
            {
    echo $form->field($model, 'name')->textInput(['maxlength' => true])->label("Category Name");
            }else{
    echo $form->field($model, 'name')->textInput(['maxlength' => true])->label("Sub Category Name"); 
            }
            ?>
    
    
    <div class="col-md-4" style="padding: 0px">
    <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>
        <span style="float: left;margin-top: -95px;margin-left: 52px;font-size: 11px;">Preferred Image Dimension : <?php echo Yii::$app->params['catImageDimentionWidth']; ?> Width, <?php echo Yii::$app->params['catImageDimentionHeight']; ?> Height</span>
     </div>
    <?php 
    echo $form->field($model, 'description')->widget(CKEditor::className(), [
			'options' => ['rows' => 6],
			'preset' => 'basic'
		]);?>
    
     <?= $form->field($model, 'status')->radioList([ '1' => 'Active', '0' => 'In Active', ])  ?>

    
    <div class="row rowbtn">
    <div class="form-group typesubmit">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Submit') : Yii::t('yii', 'Submit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
        <?php echo Html::a(Yii::t('yii','Cancel'),['index'],['class' => 'btn-success btn']); ?>
    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
