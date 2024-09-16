<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CourseScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('yii', 'Course Schedules');
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'][] = ['label' => 'Create Schedule', 'url' => ['create'], 'options' => ['class' => 'widemenu']];
?>
<?php if (Yii::$app->session->getFlash('add')) {
    echo '<div class="alert-success">' . Yii::$app->session->getFlash('add') . '</div>';
} ?>
<?php if (Yii::$app->session->getFlash('update')) {
    echo '<div class="alert-info">' . Yii::$app->session->getFlash('update') . '</div>';
} ?>
<div class="alert-info alert-info-ajax" style="display: none"></div>
        <?php if (Yii::$app->session->getFlash('delete')) {
            echo '<div class="alert-danger">' . Yii::$app->session->getFlash('delete') . '</div>';
        } ?>
<input type="hidden" id="edit-url" value="<?php echo Yii::$app->getUrlManager()->createUrl('course-schedule/update'); ?>" >
<div class="course-schedule-index">
    <div class="div_filter_outside">
        <?php
        $model = $filterModel;
        $form = ActiveForm::begin(['id' => 'filteroutside', 'action' => ['filteroutside']]);
        ?>

        <?php
        echo $form->field($model, 'from_date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => '-- From Date --'],
            'pluginOptions' => [
                //'format' => 'yyyy-mm-dd',
                 'format' => 'dd-mm-yyyy',
                'todayHighlight' => true,
                'autoclose' => true,
                'orientation' => 'bottom left',
            ]
        ]);
        ?>

        <?php
        echo $form->field($model, 'to_date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => '-- To Date --'],
            'pluginOptions' => [
                //'format' => 'yyyy-mm-dd',
                 'format' => 'dd-mm-yyyy',
                'todayHighlight' => true,
                'autoclose' => true,
                'orientation' => 'bottom left',
            ]
        ]);
        ?> 
        <?php
        $trainerAll = \backend\models\Trainer::find()->where(['flagdelete' => '0'])->all();
        $trainerData = ArrayHelper::map($trainerAll, 'trainer_id', function($model) {
                    return $model->last_name . ' ' . $model->first_name;
                });
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
        $courseAll = \backend\models\Courses::find()->where(['flagdelete' => '0'])->all();
        $courseData = ArrayHelper::map($courseAll, 'course_id', 'course_name');
        echo $form->field($model, 'course_id')
                ->widget(Select2::classname(), [
                    'data' => $courseData,
                    'options' => ['placeholder' => '-- Select --'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'multiple' => true
                    ],
        ]);
        ?>

<?php echo Html::hiddenInput('CourseSchedule[tt]', 'ind'); ?>



        <div class="row rowbtn">
            <div class="form-group form-group-btn-filteroutside">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Search') : Yii::t('yii', 'Search'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>

            </div>       
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <div id="partial-container">   
        <?php
        $gridColumns = [
            //['class' => 'kartik\grid\ActionColumn'],
             [
                                'format' => 'raw',
                                'label' => 'Actions',
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
            'resizableColumns' => false,
            'containerOptions' => ['style' => 'overflow-y: scroll;position: relative;width: 100%;'], // only set when $responsive = false
            'pjax' => true,
            'pjaxSettings' => [
                'neverTimeout' => true,
                'loadingCssClass' => true,
                'options' => [
                    'id' => 'w0-schedule',
                ]
            ],
            'bordered' => true,
            'hover' => true,
            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ' -- '],
            'panel' => [
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon glyphicon-user"></i>&nbsp;&nbsp;Schedules</h3>',
            ],
            'toolbar' => [
            //'{export}',
            //  $fullExportMenu
            // $export,
            ],
        ]);
        ?>   
    </div>
</div>
<script>
    $(document).ready(function () {
        $('body').on('beforeSubmit', '#filteroutside', function (event) {
            
            if($('#courseschedule-from_date').val() != "")
            {
                if($('#courseschedule-to_date').val() == "")
                {
                    $('.field-courseschedule-to_date').removeClass('has-success');
                    $('.field-courseschedule-to_date').addClass('required has-error');
                    $('#courseschedule-to_date-kvdate').next('.help-block').text("To Date cannot be blank");
                }
            }else{
                $('#courseschedule-to_date').val("");
            }
            
            var form = $(this);
            if (form.find('.has-error').length) {
                return false;
            }

            $("#loading").show();
            // REMOVE QUERY STRING AND SET DEFAULT URL
            if (history.pushState) {
                //  var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?r=customers%2Findex';
                var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                window.history.pushState({path: newurl}, '', newurl);
            }
            $.ajax({
                type: 'post',
                url: '<?php echo Yii::$app->urlManager->createUrl(['course-schedule/filteroutside']); ?>',
                data: $(this).serialize(),
                success: function (response) {

                    $("#loading").hide();
                    $("#partial-container").html(response);
                    return false;
                },
                error: function () {

                    return false;
                }
            });
            event.preventDefault();
            event.stopImmediatePropagation();
            return false;

        });
        
         $(document).on("click", ".change-status", function (e) {
                    e.preventDefault();
                    var id = $(this).attr('id');
                    if (confirm("Are you sure you want to change status ?") == true) {
                        $.ajax({
                            type: "POST",
                            data: "id=" + id,
                            url: '<?php echo Yii::$app->urlManager->createUrl("course-schedule/changestatus") ?>',
                            success: function (response) {
                                $(".alert-info-ajax").show();
                                $(".alert-info-ajax").html(response).fadeIn().fadeOut(2000);
                                $.pjax.reload({container: '#w0-schedule'});
                            },
                            error: function (MLHttpRequest, textStatus, errorThrown) {
                                alert(errorThrown);
                            }
                });
            }
        });
    })
</script>