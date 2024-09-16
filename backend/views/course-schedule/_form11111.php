<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\CourseSchedule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-schedule-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php 
    $courseAll = \backend\models\Courses::find()->where(['flagdelete'=>'0'])->all();
    $courseData = ArrayHelper::map($courseAll,'course_id','course_name');
    echo $form->field($model, 'course_id')
                    ->widget(Select2::classname(), [
                        'data' => $courseData,
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            //'multiple' => true
                        ],
            ]);
    ?>
    
    <?php 
    $trainerAll = \backend\models\Trainer::find()->where(['flagdelete'=>'0'])->all();
    $trainerData = ArrayHelper::map($trainerAll,'trainer_id', function($model) { return $model->last_name.' '.$model->first_name; });
    echo $form->field($model, 'trainer_ids')
                    ->widget(Select2::classname(), [
                        'data' => $trainerData,
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true
                        ],
            ]);
    ?>
    
    <?php
    echo $form->field($model, 'from_date')->widget(DatePicker::classname(), [
		'options' => ['placeholder' => '-- From Date --'],
		'pluginOptions' => [
			'format' => 'yyyy-mm-dd',
			'todayHighlight' => true,
			'autoclose'=>true,
			'orientation' => 'bottom left',
		]
	]);?>
    <?php
    echo $form->field($model, 'to_date')->widget(DatePicker::classname(), [
		'options' => ['placeholder' => '-- From Date --'],
		'pluginOptions' => [
			'format' => 'yyyy-mm-dd',
			'todayHighlight' => true,
			'autoclose'=>true,
			'orientation' => 'bottom left',
		]
	]);?>

    
    <?php echo $form->field($model, 'from_time')->widget(TimePicker::classname(), ['pluginOptions' => ['showSeconds' => false,'showMeridian'=>false]]); ?>

    
    <?php echo $form->field($model, 'to_time')->widget(TimePicker::classname(), ['pluginOptions' => ['showSeconds' => false,'showMeridian'=>false]]); ?>

   
    <?php 
    echo $form->field($model, 'days[]')->checkboxList(['Mon' => Yii::t('yii','Monday'), 'Tue' => Yii::t('yii','Tuesday'), 'Wed' => Yii::t('yii','Wednesday'), 'Thu' => Yii::t('yii','Thursday'), 'Fri' => Yii::t('yii','Friday'), 'Sat' => Yii::t('yii','Saturday'), 'Sun' => Yii::t('yii','Sunday')]); ?>
 <div class="chkall">
    <?php echo Html::checkbox('checkall','',['class'=>'checkall']); ?><span>Check All Days</span>
      </div>  
    

    <div class="row rowbtn">
    <div class="form-group typesubmit">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Submit') : Yii::t('yii', 'Submit'), ['id' =>'btnSub','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success btnSubupdate']) ?>
        <?php echo Html::a(Yii::t('yii','Cancel'),['index'],['class' => 'btn-success btn']); ?>
    </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        // --- Start Downloadable Materials
        $('#courseschedule-course_id').change(function () {
            var courseId = $(this).val();
            
            $.ajax({
                type: 'post',
                url: '<?php echo Yii::$app->urlManager->createUrl(['course-schedule/getcoursetrainers']); ?>',
                data: {courseId: courseId},
                dataType: "JSON",
                success: function (response) {
                    $('#courseschedule-trainer_ids').html(response.str);
                }
            });
        })
        
        $('.checkall').click(function(){
                    var allChecked = true;
                    $('#courseschedule-days label input').each(function(){
                        if (!this.checked) {
                            allChecked = false;
                        }
                    });
                    $('#courseschedule-days label input').prop('checked', !allChecked);
        })
        
        $('#courseschedule-days label input').click(function(){
                var countCheked = 0;
                $('#courseschedule-days label input').each(function(){
                    if($(this).prop('checked')==true)
                    {
                        countCheked++;
                    }
                });
                if(countCheked == 7)
                $('.checkall').prop('checked',true);
                else
                $('.checkall').prop('checked',false);
        })
        
        
            //$("#btnSub").click(function(e) {
            //$('#w0').delegate("#btnSub", "click", function(){
            //$("#btnSub").off().click(function(e) {
            //$( '#btnSub' ).on( 'click', function(e) {
            $("#w0").submit(function(e) {
                
              e.preventDefault();
              e.stopImmediatePropagation();
                            var form = $('#w0');
            		var url = '<?php echo Yii::$app->getUrlManager()->createUrl("course-schedule/validateschedule"); ?>';
			$.ajax({
				async : false,
				url: url,
				type: 'post',
				data: form.serialize(),
                                    dataType: "JSON",
				success: function(data) {
                                    
					//alert(data);
					//return false;
					if(data.res =="0")
					{
                                                 if (confirm("Current criteria of schedule is already exist for <br><b>" + data.names + "</b><br>Are you sure to proceed?"))
                                                                    {
                                                                         //$( "form#w0" ).submit();
                                                                         $("#w0")[0].submit();
                                                                        
                                                                        
                                                                    }else{
                                                                    }
                                              }
					else
					{
						//return false;
						$( "form#w0" ).submit();
						
					}
				}
			});
            
        });
    })
</script>    