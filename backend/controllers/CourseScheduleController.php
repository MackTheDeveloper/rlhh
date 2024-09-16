<?php

namespace backend\controllers;

use Yii;
use backend\models\CourseSchedule;
use backend\models\CourseScheduleSearch;
use backend\models\Courses;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\db\Expression;
// DECLARATION FOR AJAX VALIDATION
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * CourseScheduleController implements the CRUD actions for CourseSchedule model.
 */
class CourseScheduleController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CourseSchedule models.
     * @return mixed
     */
    
     public function actionIndex()
    {
        $filterModel = new CourseSchedule();
        $filterModel->scenario = 'outsidefilter';
        
        $searchModel = new CourseScheduleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //pre($dataProvider->query->where);
        if(isset($dataProvider->query->where) && is_array($dataProvider->query->where))
        {
        
            if($dataProvider->query->where['1'] == 'DATE(created_at) = DATE(NOW())')
            {
               $filterModel->from_date = date('Y-m-d'); 
               $filterModel->to_date = date('Y-m-d');
                    return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'filterModel' => $filterModel,
                    ]);
            }
            else
            {
            return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'filterModel' => $filterModel,
                ]);
             }    
        }
        elseif(isset($dataProvider->query->where) && strlen($dataProvider->query->where) > 0)
        {
            
            //pre($dataProvider->query->where,1);
            //pre($_POST);
            if($dataProvider->query->where == "course_schedule.flagdelete = 0")
            {
                return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'filterModel' => $filterModel,            
                ]);
                
            }else
            {
                
                return $this->renderPartial('indexfilteroutside', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'filterModel' => $filterModel,
                    ]);
            }
        }
        else{
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'filterModel' => $filterModel,         
        ]);
        }
    }
    
    public function actionFilteroutside()
    {
        $model = new CourseSchedule();
        $searchModel = new CourseScheduleSearch();
        
        if(isset($_POST['CourseSchedule']) && isset($_POST['CourseSchedule']['tt']) && $_POST['CourseSchedule']['tt'] != null)
        {
           //pre($_POST);
            $dataProvider = $searchModel->searchfilteroutside(Yii::$app->request->queryParams,$_POST);
            return $this->renderAjax('indexfilteroutside', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        }
        else
        {
            
         $dataProvider = $searchModel->searchfilteroutside(Yii::$app->request->queryParams,''); 
        return $this->renderPartial('indexfilteroutside', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);    
        } 
    }
    
    
    

    /**
     * Displays a single CourseSchedule model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CourseSchedule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new CourseSchedule();
        $model->scenario = 'add';
        $modelCourse = new Courses();
        

        if ($model->load(Yii::$app->request->post())) {
            
            $model->days = implode(',', $_POST['CourseSchedule']['days']);
            $model->status = 1; 
            $model->trainer_ids = implode(',', $_POST['CourseSchedule']['trainer_ids']);
            
            if(!empty($_POST['CourseSchedule']['downloadable_materials_student'])) { $model->downloadable_materials_student = implode(',',$_POST['CourseSchedule']['downloadable_materials_student']); }
            if(!empty($_POST['CourseSchedule']['downloadable_videos_student'])) { $model->downloadable_videos_student = implode(',',$_POST['CourseSchedule']['downloadable_videos_student']); }
            if(!empty($_POST['CourseSchedule']['downloadable_materials_trainer'])) { $model->downloadable_materials_trainer = implode(',',$_POST['CourseSchedule']['downloadable_materials_trainer']); }
            if(!empty($_POST['CourseSchedule']['downloadable_videos_trainer'])) { $model->downloadable_videos_trainer = implode(',',$_POST['CourseSchedule']['downloadable_videos_trainer']); }
            if(!empty($_POST['CourseSchedule']['trainers_allow_download'])) { $model->trainers_allow_download = implode(',',$_POST['CourseSchedule']['trainers_allow_download']); }
            
            $model->save();
            
            // Save Curse Data
            $modelCourse = $modelCourse::find()->where("course_id = ".$_POST['CourseSchedule']['course_id'])->one();
            $modelCourse->course_name = $_POST['Courses']['course_name'];
            $modelCourse->fees = $_POST['Courses']['fees'];
            $modelCourse->class_size = $_POST['Courses']['class_size'];
            $modelCourse->overview = $_POST['Courses']['overview'];
            $modelCourse->highlight = $_POST['Courses']['highlight'];
            $modelCourse->save();
            
            Yii::$app->session->setFlash('add', Yii::t('yii', 'Schedule has been Added Successfully.'));
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'modelCourse' => $modelCourse,
            ]);
        }
    }

    /**
     * Updates an existing CourseSchedule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->scenario = 'update';
        $modelCourse = Courses::find()->where("course_id = $model->course_id")->one();
        if(empty($modelCourse)) { $modelCourse = new Courses; }
        if ($model->load(Yii::$app->request->post())) 
        {
            $model->days = implode(',', $_POST['CourseSchedule']['days']);
            $model->trainer_ids = implode(',', $_POST['CourseSchedule']['trainer_ids']);
            if(!empty($_POST['CourseSchedule']['downloadable_materials_student'])) { $model->downloadable_materials_student = implode(',',$_POST['CourseSchedule']['downloadable_materials_student']); }
            if(!empty($_POST['CourseSchedule']['downloadable_videos_student'])) { $model->downloadable_videos_student = implode(',',$_POST['CourseSchedule']['downloadable_videos_student']); }
            if(!empty($_POST['CourseSchedule']['downloadable_materials_trainer'])) { $model->downloadable_materials_trainer = implode(',',$_POST['CourseSchedule']['downloadable_materials_trainer']); }
            if(!empty($_POST['CourseSchedule']['downloadable_videos_trainer'])) { $model->downloadable_videos_trainer = implode(',',$_POST['CourseSchedule']['downloadable_videos_trainer']); }
            if(!empty($_POST['CourseSchedule']['trainers_allow_download'])) { $model->trainers_allow_download = implode(',',$_POST['CourseSchedule']['trainers_allow_download']); }
            $model->save();
            
            // Save Curse Data
            $modelCourse->course_name = $_POST['Courses']['course_name'];
            $modelCourse->fees = $_POST['Courses']['fees'];
            $modelCourse->class_size = $_POST['Courses']['class_size'];
            $modelCourse->overview = $_POST['Courses']['overview'];
            $modelCourse->highlight = $_POST['Courses']['highlight'];
            $modelCourse->save();
            
            Yii::$app->session->setFlash('update',Yii::t('yii','Schedule has been Updated Successfully.'));
            return $this->redirect(['index']);  
        } else {
            $model->downloadable_materials_student = explode(',',$model->downloadable_materials_student);
            $model->downloadable_videos_student = explode(',',$model->downloadable_videos_student);
            $model->downloadable_materials_trainer = explode(',',$model->downloadable_materials_trainer);
            $model->downloadable_videos_trainer = explode(',',$model->downloadable_videos_trainer);
            $model->trainer_ids = explode(',',$model->trainer_ids);
            $model->days = explode(',',$model->days);
            $model->trainers_allow_download = explode(',',$model->trainers_allow_download);
            return $this->render('update', [
                 'model' => $model,
                 'modelCourse' => $modelCourse,
            ]);
        }
    }

    public function actionGetcoursetrainers() {
        $model = new CourseSchedule;
        $courseId = $_POST['courseId'];
        $optStr = $model->getCourseTrainers($courseId);
        $finalArr['str'] = $optStr;
        echo Json::encode($finalArr);
    }
    
    public function actionGetcoursedetail() {
        $model = new CourseSchedule;
        $courseId = $_POST['courseId'];
        $optStr = $model->getCourseDetail($courseId);
        //$finalArr = $optStr;
        echo Json::encode($optStr);
    }
    
    public function actionGettrainerforallowdownload()
    {
        $model = new CourseSchedule;
        $trainers = $_POST['Trainers'];
        $dataTrainers = $model->getTrainersForAllowDownload($trainers);
        $optStr = '<option value="">-- Select --</option>';
        foreach($dataTrainers as $kl => $vl)
        {
                $optStr .= "<option value='$vl->trainer_id'>" . $vl->last_name . ' ' . $vl->first_name . "</option>";
        }
        $finalArr['allowdownloadtotrainers'] = $optStr;
        echo Json::encode($finalArr);
    }
    

    public function actionValidateschedule() {
       
        $connection = \Yii::$app->db;
        $postData = $_POST['CourseSchedule'];
        
        // check trainers
        $selectedTrainers = $postData['trainer_ids'];
        $strTrainerCond = '';
        if (is_array($selectedTrainers) && count($selectedTrainers) > 0) {
            $strTrainerCond = " AND (";
            $cnt = 0;
            foreach ($selectedTrainers as $key => $trainerId) {
                if ($cnt == 0) {
                    $strTrainerCond .= "FIND_IN_SET($trainerId,trainer_ids)";
                } else {
                    $strTrainerCond .= " OR FIND_IN_SET($trainerId,trainer_ids)";
                }
                $cnt += 1;
            }
            $strTrainerCond .= ")";
        }

        // Check Days
        $daysTemp = $postData['days'];
        $strDaysCond = '';
        if (is_array($daysTemp) && count($daysTemp) > 0) {
            $strDaysCond = " AND (";
            $cnt = 0;
            foreach ($daysTemp as $key => $dayName) {
                if ($cnt == 0) {
                    $strDaysCond .= " days LIKE '%$dayName%' ";
                } else {
                    $strDaysCond .= " OR days LIKE '%$dayName%' ";
                }
                $cnt += 1;
            }
            $strDaysCond .= " )";
        }

        $start_date = $postData['from_date'];
        $end_date = $postData['to_date'];
        $start_time = $postData['from_time'];
        $end_time = $postData['to_time'];
        $course_id = $postData['course_id'];
        // Now check for course tt if conflciting				
        $sql = "SELECT course_schedule.* 
                            FROM course_schedule
		WHERE course_id = '" . $course_id . "' 
		$strDaysCond $strTrainerCond
		AND (from_date = '" . $start_date . "' OR to_date = '" . $end_date . "' OR from_date = '" . $start_date . "' OR to_date = '" . $end_date . "' OR '" . $start_date . "' BETWEEN from_date AND to_date OR '" . $end_date . "' BETWEEN from_date AND to_date OR from_date BETWEEN '" . $start_date . "' AND '" . $end_date . "' OR to_date BETWEEN '" . $start_date . "' AND '" . $end_date . "') 
		AND (from_time = '" . $start_time . ":00' OR to_time = '" . $start_time . ":00' OR from_time = '" . $end_time . ":00' OR to_time = '" . $end_time . ":00' OR '" . $start_time . ":00' BETWEEN from_time AND to_time OR '" . $end_time . ":00' BETWEEN from_time AND to_time OR from_time BETWEEN '" . $start_time . ":00' AND '" . $end_time . ":00' OR to_time BETWEEN '" . $start_time . ":00' AND '" . $end_time . ":00')";
        $perdata = $connection->createCommand($sql);
        $recFound = $perdata->queryAll();
        $recFound['totalRecords'] = count($recFound);
        
         if ($recFound['totalRecords'] > 0) {
             foreach($recFound as $k => $v)
             {
                 
                 if(isset($v['trainer_ids']))
                 {
                     $nameOfTrainers = array();
                     $existingTrainers = explode(',',$v['trainer_ids']);
                     $fetchExisting = array_intersect($selectedTrainers, $existingTrainers);
                     if(!empty($fetchExisting))
                     {
                         foreach($fetchExisting as $v){
                             $trainersData = \backend\models\Trainer::find()->where("trainer_id = $v")->one();
                             $nameOfTrainers[] = $trainersData->last_name.' '.$trainersData->first_name;
                         }
                     }
                 }
             }
             $finalData['res'] = 0;
             $finalData['names'] = implode(',',$nameOfTrainers);
             echo Json::encode($finalData);
            }else{
                $finalData['res'] = 1;
                echo Json::encode($finalData);
            }
    }
    
    public function actionGetmaterialsofselectedcourse() {
        $courseId = $_POST['courseId'];
        $model = new CourseSchedule;
        $datRes = $model->getMaterialsOfCourse($courseId);
        // Materials
        $dataProduct = yii\helpers\ArrayHelper::map($datRes['materials'], 'material_id','name','product_name');
        $optStr = '<option value="">-- Select --</option>';
        foreach($dataProduct as $kl => $vl)
        {
            
            $optStr .= "<optgroup label='$kl'>";
            foreach($vl as $kkl => $vvl)
            {
                $optStr .= "<option value='$kkl'>" . $vvl . "</option>";
            }
            $optStr .= "</optgroup>";
        }
        $finalArr['strmaterials'] = $optStr;
        
        // Videos
        $dataProduct = yii\helpers\ArrayHelper::map($datRes['videos'], 'material_id','name','product_name');
        $optStr = '<option value="">-- Select --</option>';
        foreach($dataProduct as $kl => $vl)
        {
            
            $optStr .= "<optgroup label='$kl'>";
            foreach($vl as $kkl => $vvl)
            {
                $optStr .= "<option value='$kkl'>" . $vvl . "</option>";
            }
            $optStr .= "</optgroup>";
        }
        $finalArr['strvideos'] = $optStr;
        echo Json::encode($finalArr);
        
    }
    
    

    /**
     * Deletes an existing CourseSchedule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        
        $model = $this->findModel($id);
        $model->flagdelete = '1';
        $model->deleted_by = Yii::$app->User->identity->id;
        $model->save();
        Yii::$app->session->setFlash('delete',Yii::t('yii','Schedule has been  Deleted Successfully'));
        return $this->redirect(['index']);
    }
    
    public function actionChangestatus()
    {
        $id = $_POST['id'];
        $dataTrainer = CourseSchedule::find()->where("course_schedule_id = $id")->one();
        if($dataTrainer->status == 1)
        $dataTrainer->status = 0;
        else
        $dataTrainer->status = 1;
        $dataTrainer->save();
        echo 'Status have been changed successfully';
    }

    /**
     * Finds the CourseSchedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CourseSchedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = CourseSchedule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
