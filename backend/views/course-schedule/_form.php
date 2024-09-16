<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
use dosamigos\ckeditor\CKEditor;
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
    echo $form->field($model, 'days')->checkboxList(['Mon' => Yii::t('yii','Monday'), 'Tue' => Yii::t('yii','Tuesday'), 'Wed' => Yii::t('yii','Wednesday'), 'Thu' => Yii::t('yii','Thursday'), 'Fri' => Yii::t('yii','Friday'), 'Sat' => Yii::t('yii','Saturday'), 'Sun' => Yii::t('yii','Sunday')]); ?>
 <div class="chkall">
    <?php echo Html::checkbox('checkall','',['class'=>'checkall']); ?><span>Check All Days</span>
      </div>  
    
    <?php echo $form->field($model, 'location')->textInput(['maxlength' => true]); ?>
    <?php  
    
    if($model->isNewRecord) $trainerDataAllowDownload = array();
    else  {
    $trainerAllowdownloadAll = \backend\models\Trainer::find()->where(['IN','trainer_id',$model->trainer_ids])->all();
    $trainerDataAllowDownload = ArrayHelper::map($trainerAllowdownloadAll,'trainer_id', function($model) { return $model->last_name.' '.$model->first_name; });
    }
    echo $form->field($model, 'trainers_allow_download')
                    ->widget(Select2::classname(), [
                        'data' => $trainerDataAllowDownload,
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true
                        ],
            ]); ?>
    
    <?php
        echo $form->field($model, 'important_notes_for_student')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'basic'
        ]);
        ?>
    <?php
        echo $form->field($model, 'important_notes_for_trainer')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'basic'
        ]);
        ?>
    
    <h4 style="float: left;width: 98%;background-color: #ececec;padding: 7px;margin-bottom: 25px;">Downloadable Materials</h4>
    <div class="col-md-12">
        <div class="col-md-6">
        <h4 style="float: left;width: 100%;background-color: #ececec;padding: 7px;margin-bottom: 25px;margin-right: 15px">Student</h4>
        <?php
         $dmsAr = array();
         if (!$model->isNewRecord) {
                $dataMaterials = $model->getMaterialsOfCourse($model->course_id);
                $dmsAr = yii\helpers\ArrayHelper::map($dataMaterials['materials'], 'material_id', 'name', 'product_name');
                
            }
        echo $form->field($model, 'downloadable_materials_student')
                    ->widget(Select2::classname(), [
                        'data' => $dmsAr,
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true
                        ],
            ]);
        ?>
        <?php
         $dvsAr = array();
         if (!$model->isNewRecord) {
                $dataMaterials = $model->getMaterialsOfCourse($model->course_id);
                $dvsAr = yii\helpers\ArrayHelper::map($dataMaterials['videos'], 'material_id', 'name', 'product_name');
                
            }
        echo $form->field($model, 'downloadable_videos_student')
                    ->widget(Select2::classname(), [
                        'data' => $dvsAr,
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true
                        ],
            ]);
        ?>
        </div>
        <div class="col-md-6">
        <h4 style="float: left;width: 100%;background-color: #ececec;padding: 7px;margin-bottom: 25px;">Trainer</h4>
        <?php
        $dmtAr = array();
         if (!$model->isNewRecord) {
                $dataMaterials = $model->getMaterialsOfCourse($model->course_id);
                $dmtAr = yii\helpers\ArrayHelper::map($dataMaterials['materials'], 'material_id', 'name', 'product_name');
                
            }
        echo $form->field($model, 'downloadable_materials_trainer')
                    ->widget(Select2::classname(), [
                        'data' => $dmtAr,
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true
                        ],
            ]);
        ?>
        <?php
        $dvtAr = array();
         if (!$model->isNewRecord) {
                $dataMaterials = $model->getMaterialsOfCourse($model->course_id);
                $dvtAr = yii\helpers\ArrayHelper::map($dataMaterials['videos'], 'material_id', 'name', 'product_name');
                
            }
        echo $form->field($model, 'downloadable_videos_trainer')
                    ->widget(Select2::classname(), [
                        'data' => $dvtAr,
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true
                        ],
            ]);
        ?>
    </div>
        </div>
    
    <div class="courseDetailsinscheduling" style="display: none;float:left;width:100%;">
        <h4 style="float: left;width: 98%;background-color: #ececec;padding: 7px;margin-bottom: 25px;">Course Detail</h4>
        <?php echo $form->field($modelCourse, 'course_name')->textInput(['maxlength' => true]); ?>
        <?php echo $form->field($modelCourse, 'fees')->textInput(['maxlength' => true]); ?>
        <?php echo $form->field($modelCourse, 'class_size')->textInput(['maxlength' => true]); ?>
        <?php echo $form->field($modelCourse, 'overview')->textarea(['rows' => 6]) ?>
        <?php
        echo $form->field($modelCourse, 'highlight')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'basic'
        ]);
        ?>
        
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
        
        <?php if(!$model->isNewRecord) { ?>
                $('.courseDetailsinscheduling').show(); 
        <?php } ?>
            
        // Trainers allow to download
        $('#courseschedule-trainer_ids').change(function () {
            var Trainers = $(this).val();
            $.ajax({
                    type: 'post',
                    url: '<?php echo Yii::$app->urlManager->createUrl(['course-schedule/gettrainerforallowdownload']); ?>',
                    data: {Trainers: Trainers},
                    dataType: "JSON",
                    success: function (response) {
                        $('#courseschedule-trainers_allow_download').html(response.allowdownloadtotrainers);
                    }
                });
        });
        
        // --- Start Downloadable Materials
        $('#courseschedule-course_id').change(function () {
            var courseId = $(this).val();
            $('.courseDetailsinscheduling').show(); 
             /* $.ajax({
                                type: 'post',
                                url: '<?php //echo Yii::$app->urlManager->createUrl(['course-schedule/getcoursetrainers']); ?>',
                                data: {courseId: courseId},
                                dataType: "JSON",
                                success: function (response) {
                                    $('#courseschedule-trainer_ids').html(response.str);
                                }
                            }); */
               $.ajax({
                    type: 'post',
                    url: '<?php echo Yii::$app->urlManager->createUrl(['course-schedule/getcoursedetail']); ?>',
                    data: {courseId: courseId},
                    dataType: "JSON",
                    success: function (response) {
                        $('#courses-course_name').val(response.course_name);
                        $('#courses-fees').val(response.fees);
                        $('#courses-class_size').val(response.class_size);
                        $('#courses-overview').val(response.overview);
                        //$('#courses-highlight').val(response.highlight);
                          CKEDITOR.instances['courses-highlight'].setData(response.highlight)
                        //$('#courseschedule-trainer_ids').html(response.str);
                    }
               });
               
                $.ajax({
                    type: 'post',
                    url: '<?php echo Yii::$app->urlManager->createUrl(['course-schedule/getmaterialsofselectedcourse']); ?>',
                    data: {courseId: courseId},
                    dataType: "JSON",
                    success: function (response) {
                        $('#courseschedule-downloadable_materials_student').html(response.strmaterials);
                        $('#courseschedule-downloadable_videos_student').html(response.strvideos);
                        $('#courseschedule-downloadable_materials_trainer').html(response.strmaterials);
                        $('#courseschedule-downloadable_videos_trainer').html(response.strvideos);
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
        
        
            <?php if($model->isNewRecord) { ?>
            $("#btnSub").off().click(function(e) {
            
                            var form = $('#w0');
            		var url = '<?php echo Yii::$app->getUrlManager()->createUrl("course-schedule/validateschedule"); ?>';
			$.ajax({
				async : true,
				url: url,
				type: 'post',
				data: form.serialize(),
                                    dataType: "JSON",
				success: function(data) {
                                    
					//alert(data);
					//return false;
					if(data.res =="0")
					{
                                            
						 Lobibox.confirm({
                                                                msg: "Current criteria of schedule is already exist for <br><b>" + data.names + "</b><br>Are you sure to proceed?",
                                                                callback: function (lobibox, type) {

                                                                             if(type == 'yes')
                                                                               {
                                                                                    $("#w0")[0].submit();
                                                                               }
                                                                              else
                                                                                {}    
                                                                    }
                                                            })
					}
					else
					{
						//return false;
						$("#w0")[0].submit();
						return true;
					}
				}
			});
              e.preventDefault();
        });
        <?php } ?>
    })
</script>    