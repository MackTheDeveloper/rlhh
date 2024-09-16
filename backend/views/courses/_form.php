<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use yii\jui\Datepicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Courses */
/* @var $form yii\widgets\ActiveForm */
?>
<?php 
if(!$model->isNewRecord)
{
    $countPaymentInstallment = backend\models\CoursePaymentInstallments::find()->where("course_id = $model->course_id")->count();
}else{
    $countPaymentInstallment = 0;
}
?>
<div class="courses-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?php
    $allNeededCategories = $model->getNeededCategories();
    $categoruData = ArrayHelper::map($allNeededCategories, 'category_id', 'name');
    echo $form->field($model, 'course_category_id')
                    ->widget(Select2::classname(), [
                        'data' => $categoruData,
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            //'multiple' => true
                        ],
            ]);
    ?>
    


<?= $form->field($model, 'course_name')->textInput(['maxlength' => true]) ?>

    <div class="col-md-4" style="padding: 0px">
        <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>
        <span style="float: left;margin-top: -95px;margin-left: 52px;font-size: 11px;">Preferred Image Dimension : <?php echo Yii::$app->params['catImageDimentionWidth']; ?> Width, <?php echo Yii::$app->params['catImageDimentionHeight']; ?> Height</span>
            <?php if (!$model->isNewRecord && $model->image != "" && file_exists(Yii::$app->basePath . '/web/images/courses/' . $model->image)) { ?>
            <span style="float: right;margin-top: -73px;margin-right: 70px;"><?php $img = Html::img(Yii::getAlias('@web') . '/images/courses/' . $model->image, ['width' => 100, 'height' => 100]);
                echo Html::a($img, Yii::getAlias('@web') . '/images/courses/' . $model->image, ['target' => '_blank']);
                ?></span>
    <?php } ?>
    </div>

    <?php 
       echo $form->field($model, 'type')
                    ->widget(Select2::classname(), [
                        'data' => ['O' => 'Online', 'C' => 'Class Room'],
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            //'multiple' => true
                        ],
            ]);     
            ?>


    <?php
    /* $form->field($model, 'course_date')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'en',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control'], 
    ]) */
    ?>
    <?php
    /* $form->field($model, 'course_to_date')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'en',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control'],
    ]) */
    ?>

    <?= $form->field($model, 'time_duration')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'accredited_hours')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'class_size')->textInput(['maxlength' => true]) ?>
    <?php
   /* $trainerData = backend\models\Trainer::find()->where("flagdelete = 0")->all();
    $dataTrainer = yii\helpers\ArrayHelper::map($trainerData, 'trainer_id', function($model) {
                return $model->last_name . ' ' . $model->first_name;
            });
    echo $form->field($model, 'trainer')
                    ->widget(Select2::classname(), [
                        'data' => $dataTrainer,
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true
                        ],
            ]);  */
    ?>

    <?= $form->field($model, 'fees')->textInput(['maxlength' => true, 'placeholder' => '0.00']) ?>


    <?= $form->field($model, 'overview')->textarea(['rows' => 6]) ?>

<?php
echo $form->field($model, 'highlight')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'basic'
]);
?>

    <div class="productmaterialselectionsection">
        <h4 style="float: left;width: 98%;background-color: #ececec;padding: 7px;margin-bottom: 25px;">Downloadable Materials</h4>
        <?php
            $productData = \backend\models\Products::find()->where("flagdelete = 0")->all();
            $dataProduct = yii\helpers\ArrayHelper::map($productData, 'product_id', 'name', function($model) {
                        $dataCat = backend\models\ProductCategories::find()->where("category_id = $model->category_id")->one();
                        return$dataCat->name;
                    });
            echo $form->field($model, 'productsdownloadablematerials')
                    ->widget(Select2::classname(), [
                        'data' => $dataProduct,
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true
                        ],
            ]);
     ?>

        <?php
            $dmAr = array();
            if (!$model->isNewRecord) {
                $dataMaterials = $model->fetchdownlodableandpaidmaterialforcourse($model->productsdownloadablematerials);
                $dmAr = yii\helpers\ArrayHelper::map($dataMaterials['materials'], 'material_id', 'name', 'product_name');
                
            }
            echo $form->field($model, 'downloadable_materials')
                    ->widget(Select2::classname(), [
                        'data' => $dmAr,
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true
                        ],
            ]);
     ?>
        
        <?php
            $dvAr = array();
            if (!$model->isNewRecord) {
                $dataMaterials = $model->fetchdownlodableandpaidmaterialforcourse($model->productsdownloadablematerials);
                $dvAr = yii\helpers\ArrayHelper::map($dataMaterials['videos'], 'material_id', 'name', 'product_name');
            }
            echo $form->field($model, 'downloadable_videos')
                    ->widget(Select2::classname(), [
                        'data' => $dvAr,
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true
                        ],
            ]);
     ?>

        <h4 style="float: left;width: 98%;background-color: #ececec;padding: 7px;margin-bottom: 25px;">Paid Materials</h4>
        <?php
            $productData = \backend\models\Products::find()->where("flagdelete = 0 AND cost_type = 'Paid'")->all();
            $dataProduct = yii\helpers\ArrayHelper::map($productData, 'product_id',function($model) {
                        return $model->name.' ('. $model->price .') ';
                    }, function($model) {
                        $dataCat = backend\models\ProductCategories::find()->where("category_id = $model->category_id")->one();
                        return$dataCat->name;
                    });
            echo $form->field($model, 'productspaidmaterials')
                    ->widget(Select2::classname(), [
                        'data' => $dataProduct,
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true
                        ],
            ]);
     ?>
    </div>
    
    <h4 style="float: left;width: 98%;background-color: #ececec;padding: 7px;margin-bottom: 25px;">Payment Details</h4>
    <?php echo $form->field($model,'payment_process')->radioList(['Y'=>'Yes','N'=>'No']); ?>
    
    <?php if(!$model->isNewRecord){ 
            if(isset($modelInstallmentsData) && count($modelInstallmentsData) > 0)
            {
        ?>
         <div class="addpaymentmaincontainer addpaymentmaincontainerupdate" style="width: 83%;float:left">
             <h4 style="float: left;width: 97%;background-color: #ececec;padding: 7px;margin-bottom: 25px;">Installments Detail</h4>
             <?php 
             $plusminuspayment = 0;
             foreach($modelInstallmentsData as $k => $v) { ?>
        <div class="col-md-12" id="addpaymentcontainer-<?php echo $plusminuspayment; ?>">

            <div class="form-group">
     <?php 
     //$modelInstallments->period = $v->period;
     echo Select2::widget([
            'name' => 'CoursePaymentInstallments[period][]',
            'value' => $v->period,
            'data' => Yii::$app->params['installmentPeriod'],
            'options' => [
                'placeholder' => '-- Select Period --',
                'class' => 'form-control',
            ],
        ]);
       ?>   
          </div>      
            <div class="form-group">
        <?php echo Html::textInput("CoursePaymentInstallments[amount][]",$v->amount,['class'=>'form-control','placeholder' => '0.00']); ?>
        </div>
            <div class="form-group">
     <?php 
     echo Select2::widget([
            'name' => 'CoursePaymentInstallments[reminder][]',
            'value' => $v->reminder,
            'data' => Yii::$app->params['reminderPayment'],
            'options' => [
                'placeholder' => '-- Select Reminder --',
                'class' => 'form-control',
            ],
        ]);
       ?>   
          </div>
            <div class="form-group" style="width: 8% !important;">
        <?php echo Html::a('+', 'javascript:void(0)', ['class'=>'btn btn-success btn-xs addcoursepaymentinstallments addcoursepaymentinstallmentsfirst','style'=>'margin-top:6px;margin-right:10px;']);  ?>
            <?php 
        if($plusminuspayment != 0) {
        echo Html::a('-', 'javascript:void(0)', ['class'=>'btn btn-danger btn-xs removecoursepaymentinstallments removecoursepaymentinstallmentsfirst','id'=>$plusminuspayment,'style'=>'margin-top:6px;;margin-right:10px;']);  
        }
      ?>
    </div>
            </div>
             <?php $plusminuspayment++; } ?>
    </div>
    <?php } else { ?>
                     <div class="addpaymentmaincontainer" style="width: 83%;float:left">
                         <h4 style="float: left;width: 97%;background-color: #ececec;padding: 7px;margin-bottom: 25px;">Installments Detail</h4>
                    <div class="col-md-12" id="addpaymentcontainer-0">

                     <?php echo $form->field($modelInstallments, 'period[]')
                                    ->widget(Select2::classname(), [
                                        'data' => Yii::$app->params['installmentPeriod'],
                                        'options' => ['placeholder' => '-- Select Period --'],
                                        'pluginOptions' => [
                                            'allowClear' => true,

                                        ],
                            ])->label(''); ?>   
                        <?= $form->field($modelInstallments, 'amount[]')->textInput(['maxlength' => true, 'placeholder' => '0.00'])->label('') ?>
                         <?php echo $form->field($modelInstallments, 'reminder[]')
                    ->widget(Select2::classname(), [
                        'data' => Yii::$app->params['reminderPayment'],
                        'options' => ['placeholder' => '-- Select Reminder --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            
                        ],
            ])->label(''); ?>   
                        <?php echo Html::a('+', 'javascript:void(0)', ['class'=>'btn btn-success btn-xs addcoursepaymentinstallments addcoursepaymentinstallmentsfirst','style'=>'']);  ?>

                    </div>
                    </div>
    
        <?php } ?>
        
    <?php } else {  ?>
    <div class="addpaymentmaincontainer" style="width: 83%;float:left">
        <h4 style="float: left;width: 97%;background-color: #ececec;padding: 7px;margin-bottom: 25px;">Installments Detail</h4>
    <div class="col-md-12" id="addpaymentcontainer-0">
     
     <?php echo $form->field($modelInstallments, 'period[]')
                    ->widget(Select2::classname(), [
                        'data' => Yii::$app->params['installmentPeriod'],
                        'options' => ['placeholder' => '-- Select Period --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            
                        ],
            ])->label(''); ?>   
        <?= $form->field($modelInstallments, 'amount[]')->textInput(['maxlength' => true, 'placeholder' => '0.00'])->label('') ?>
        <?php echo $form->field($modelInstallments, 'reminder[]')
                    ->widget(Select2::classname(), [
                        'data' => Yii::$app->params['reminderPayment'],
                        'options' => ['placeholder' => '-- Select Reminder --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            
                        ],
            ])->label(''); ?>   
        <?php echo Html::a('+', 'javascript:void(0)', ['class'=>'btn btn-success btn-xs addcoursepaymentinstallments addcoursepaymentinstallmentsfirst','style'=>'']);  ?>
        
    </div>
    </div>
    <?php } ?>

<?= $form->field($model, 'status')->radioList(['1' => 'Active', '0' => 'In Active',]) ?>

    <div class="row rowbtn">
        <div class="form-group typesubmit">
<?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Submit') : Yii::t('yii', 'Submit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
<?php echo Html::a(Yii::t('yii', 'Cancel'), ['index'], ['class' => 'btn-success btn']); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>

</div>


<script type="text/javascript">
    $(document).ready(function () {
        
        // --- Start Downloadable Materials
        $('#courses-productsdownloadablematerials').change(function () {
            var selectedMaterial = $('#courses-downloadable_materials').val();
            var prodId = $(this).val();
            $.ajax({
                type: 'post',
                url: '<?php echo Yii::$app->urlManager->createUrl(['courses/getmaterialsforcourse']); ?>',
                data: {prodId: prodId, selectedMaterial: selectedMaterial},
                dataType: "JSON",
                success: function (response) {
                    $('#courses-downloadable_materials').html(response.strmaterials);
                    $('#courses-downloadable_videos').html(response.strvideos);
                }
            });
        })
        var $eventSelect = $('#courses-productsdownloadablematerials');
        $eventSelect.on("select2:unselect", function (e) {
            var selectedMaterial = $('#courses-downloadable_materials').val();
            var prodId = $(this).val();
            $.ajax({
                type: 'post',
                url: '<?php echo Yii::$app->urlManager->createUrl(['courses/getmaterialsforcourse']); ?>',
                data: {prodId: prodId,selectedMaterial: selectedMaterial},
                dataType: "JSON",
                success: function (response) {
                    $('#courses-downloadable_materials').html(response.str);
                    $('#courses-downloadable_videos').html(response.strvideos);
                }
            });
        });
        // --- End Downloadable Materials
        
        // Add Installments
        
        if($('#courses-payment_process label input:checked').val() == "N")
        {
          $('.addpaymentmaincontainer').hide();
        }else{
         $('.addpaymentmaincontainer').show();
        }
        
        $('#courses-payment_process label input').click(function(){
         if($(this).val() == 'N')
         {
             $('.addpaymentmaincontainer').hide();
         }else{
             $('.addpaymentmaincontainer').show();
         }
        });
        
        
         var countPaymentInstallment = 0;
        if('<?php echo $countPaymentInstallment; ?>' != 0)
        {
            countPaymentInstallment  =  <?php echo $countPaymentInstallment-1;?>;
        }
        
        $(document).on("click",".addcoursepaymentinstallments",function (e) {
            
        countPaymentInstallment = countPaymentInstallment+1;
        if(countPaymentInstallment == 0) { countPaymentInstallment = 1; }
        e.preventDefault();
        var str  =  
         "<div class='col-md-12' id='addpaymentcontainer-"+countPaymentInstallment+"' style='margin-bottom:10px;height:60px'>\n\
\n\
<div class = 'form-group customselect2'>"+addperioddropdown('')+"</div>\n\
\n\<div class = 'form-group'>"+addamount('')+"</div>\n\
<div class = 'form-group customselect2'>"+addreminder('')+"</div>\n\
\n\<div class = 'form-group' style='margin-left:0px;width:8% !important'><a style='margin-top:0px !important;margin-right:10px !important' href='#' class='btn btn-success btn-xs addcoursepaymentinstallments' id="+countPaymentInstallment+">+</a><a style='' href='#' class='btn btn-danger btn-xs removecoursepaymentinstallments' id="+countPaymentInstallment+">-</a></div>";
$('.addpaymentmaincontainer').append(str);
$(".coursepaymentinstallments-period").attr("data-placeholder","-- Select Period --");
$(".coursepaymentinstallments-reminder").attr("data-placeholder","-- Select Reminder --");

 $(".coursepaymentinstallments-period").select2({allowClear: true});
 $(".coursepaymentinstallments-reminder").select2({allowClear: true});
    });
     $(document).on("click",".removecoursepaymentinstallments",function (e) {
        
            e.preventDefault();
            var id = $(this).attr('id');
            $("#addpaymentcontainer-"+id).remove();
            //counterInqAttachement = counterInqAttachement - 1;
    });
    function addperioddropdown(txt)
	{
         var text  =  '<select id="coursepaymentinstallments-period" class="coursepaymentinstallments-period" name = "CoursePaymentInstallments[period][]">\n\
<option value = "">-- Select Period --</option>\n\
 <option value = "Immediate">Immediate</option>\n\
<option value = "30 Days">After 1 Month</option>\n\
<option value = "60 Days">After 2 Months</option>\n\
<option value = "90 Days">After 3 Months</option>\n\
<option value = "120 Days">After 4 Months</option>\n\
<option value = "150 Days">After 5 Months</option>\n\
<option value = "180 Days">After 6 Months</option>\n\
<option value = "210 Days">After 7 Months</option>\n\
<option value = "240 Days">After 8 Months</option>\n\
<option value = "270 Days">After 9 Months</option>\n\
<option value = "300 Days">After 10 Months</option>\n\
<option value = "330 Days">After 11 Months</option>\n\
<option value = "360 Days">After 12 Months</option>\n\
</select>'; 
   
    //text = $('#coursepaymentinstallments-period').select2('data', {id: 'Immediate', a_key: 'Immediate'},{id: 'Immediate', a_key: 'Immediate'});
         return text;
	}
    function addreminder(txt)
	{
         var text  =  '<select id="coursepaymentinstallments-reminder" class="coursepaymentinstallments-reminder" name = "CoursePaymentInstallments[reminder][]">\n\
  <option value = "">-- Select Reminder --</option>\n\
 <option value = "1 Day Before">1 Day Before</option>\n\
<option value = "3 Days Before">3 Days Before</option>\n\
<option value = "5 Days Before">5 Days Before</option>\n\
<option value = "1 Week Before">1 Week Before</option>\n\
<option value = "15 Days Before">15 Days Before</option>\n\
<option value = "1 Month Before">1 Month Before</option>\n\
</select>'; 
   
    //text = $('#coursepaymentinstallments-period').select2('data', {id: 'Immediate', a_key: 'Immediate'},{id: 'Immediate', a_key: 'Immediate'});
         return text;
	}
     function addamount(txt)
	{
         var text  =  '<input type="text" name="CoursePaymentInstallments[amount][]" id="coursepaymentinstallments-amount" placeholder="0.00" class="form-control value="">';
         return text;
	}
})
</script>
