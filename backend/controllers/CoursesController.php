<?php

namespace backend\controllers;

use Yii;
use backend\models\Courses;
use backend\models\CoursesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;
use backend\models\Categories;
use yii\helpers\Json;
use backend\models\CoursePaymentInstallments;
/**
 * CoursesController implements the CRUD actions for Courses model.
 */
class CoursesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
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
     * Lists all Courses models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CoursesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Courses model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Courses model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Courses();
        $modelInstallments = new CoursePaymentInstallments();
        if ($model->load(Yii::$app->request->post()))
        {
            
            $model->created_at = new Expression('NOW()');
            if(!empty($_POST['Courses']['productsdownloadablematerials'])) { $model->productsdownloadablematerials = implode(',',$_POST['Courses']['productsdownloadablematerials']); }
            if(!empty($_POST['Courses']['productspaidmaterials'])) { $model->productspaidmaterials = implode(',',$_POST['Courses']['productspaidmaterials']); }
            
            
            if(!empty($_POST['Courses']['downloadable_materials'])) { $model->downloadable_materials = implode(',',$_POST['Courses']['downloadable_materials']); }
            if(!empty($_POST['Courses']['downloadable_videos'])) { $model->downloadable_videos = implode(',',$_POST['Courses']['downloadable_videos']); }
            
            $model->save();
            
            // Save course payement
            if($model->payment_process == 'Y'){
                if(!empty(array_filter($_POST['CoursePaymentInstallments']['period'])))
                {
                    for($i = 0;$i < count($_POST['CoursePaymentInstallments']['period']); $i++)
                    {
                        $modelInstallments->course_id = $model->course_id;
                        $modelInstallments->period = $_POST['CoursePaymentInstallments']['period'][$i];
                        $modelInstallments->amount = $_POST['CoursePaymentInstallments']['amount'][$i]; 
                        $modelInstallments->reminder = $_POST['CoursePaymentInstallments']['reminder'][$i]; 
                        $modelInstallments->course_payment_installment_id = null;
                        $modelInstallments->isNewRecord = true;
                        $modelInstallments->save();
                    }
                }
            }
            
            // Set flag_product in product category
            $dataCourseCat = Categories::find()->where("category_id = $model->course_category_id")->one();
            $dataCourseCat->flag_course = 'Y';
            $dataCourseCat->save();
            
            $modelUpdate = $this->findModel($model->course_id);
            if(isset($_FILES['Courses']['name']['image']) && $_FILES['Courses']['name']['image'] != "")
            {
                   $uploadedFile = UploadedFile::getInstance($model, "image");
                   $modelUpdate->image = $model->course_id.'_'.$uploadedFile->name;
                   $extension = $uploadedFile->getExtension();
                    if($extension=="jpg" || $extension=="jpeg" )
                        {
                        $uploadedfile = $_FILES['Courses']['tmp_name']['image'];
                        $src = imagecreatefromjpeg($uploadedfile);
                        }
                        else if($extension=="png")
                        {
                        $uploadedfile = $_FILES['Courses']['tmp_name']['image'];
                        $src = imagecreatefrompng($uploadedfile);
                        }
                        else 
                        {
                        $src = imagecreatefromgif($uploadedfile);
                        }
                    list($width,$height)=getimagesize($uploadedfile);
                    //$newheight=($height/$width)*$newwidth;
                    $newwidth=Yii::$app->params['catImageDimentionWidth'];
                    $newheight= Yii::$app->params['catImageDimentionHeight'];
                    $tmp=imagecreatetruecolor($newwidth,$newheight);
                    imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
                    imagejpeg($tmp,Url::to('@backend').'/web/images/courses/'.$modelUpdate->image,100);
                    $modelUpdate->save();
            }
            Yii::$app->session->setFlash('add',Yii::t('yii','Course has been Added Successfully.'));
            return $this->redirect(['index']);
        } else {
            $model->status = 1;
            $model->payment_process = 'Y';
            return $this->render('create', [
                'model' => $model,
                'modelInstallments' => $modelInstallments,
            ]);
        }
    }

    /**
     * Updates an existing Courses model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelInstallmentsData = CoursePaymentInstallments::find()->where("course_id = $id")->all();
        $modelInstallments = new CoursePaymentInstallments;
        if ($model->load(Yii::$app->request->post()))
        {
             if(isset($_FILES['Courses']['name']['image']) && $_FILES['Courses']['name']['image'] != "")
            {
                   $uploadedFile = UploadedFile::getInstance($model, "image");
                   $model->image = $model->course_id.'_'.$uploadedFile->name;
                   $extension = $uploadedFile->getExtension();
                    if($extension=="jpg" || $extension=="jpeg" )
                        {
                        $uploadedfile = $_FILES['Courses']['tmp_name']['image'];
                        $src = imagecreatefromjpeg($uploadedfile);
                        }
                        else if($extension=="png")
                        {
                        $uploadedfile = $_FILES['Courses']['tmp_name']['image'];
                        $src = imagecreatefrompng($uploadedfile);
                        }
                        else 
                        {
                        $src = imagecreatefromgif($uploadedfile);
                        }
                    list($width,$height)=getimagesize($uploadedfile);
                    //$newheight=($height/$width)*$newwidth;
                    $newwidth=Yii::$app->params['catImageDimentionWidth'];
                    $newheight= Yii::$app->params['catImageDimentionHeight'];
                    $tmp=imagecreatetruecolor($newwidth,$newheight);
                    imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
                    imagejpeg($tmp,Url::to('@backend').'/web/images/courses/'.$model->image,100);
            }
            else
            {
                    $model->image = $model->oldAttributes['image'];
            }
            if(!empty($_POST['Courses']['productsdownloadablematerials'])) { $model->productsdownloadablematerials = implode(',',$_POST['Courses']['productsdownloadablematerials']); }
            if(!empty($_POST['Courses']['productspaidmaterials'])) { $model->productspaidmaterials = implode(',',$_POST['Courses']['productspaidmaterials']); }
            
            
            if(!empty($_POST['Courses']['downloadable_materials'])) { $model->downloadable_materials = implode(',',$_POST['Courses']['downloadable_materials']); }
            if(!empty($_POST['Courses']['downloadable_videos'])) { $model->downloadable_videos = implode(',',$_POST['Courses']['downloadable_videos']); }
            $model->save();
            
            // Save course payement
            $modelInstallments::deleteAll(['course_id'=>$model->course_id]);
            if($model->payment_process == 'Y'){
                    if(!empty(array_filter($_POST['CoursePaymentInstallments']['period'])))
                    {
                        for($i = 0;$i < count($_POST['CoursePaymentInstallments']['period']); $i++)
                        {
                            $modelInstallments->course_id = $model->course_id;
                            $modelInstallments->period = $_POST['CoursePaymentInstallments']['period'][$i];
                            $modelInstallments->amount = $_POST['CoursePaymentInstallments']['amount'][$i]; 
                            $modelInstallments->reminder = $_POST['CoursePaymentInstallments']['reminder'][$i];
                            $modelInstallments->course_payment_installment_id = null;
                            $modelInstallments->isNewRecord = true;
                            $modelInstallments->save();
                        }
                    }
            }
            
            Yii::$app->session->setFlash('update',Yii::t('yii','Course has been Updated Successfully.'));
            return $this->redirect(['index']);   
            
        } else {
            $model->productsdownloadablematerials = explode(',',$model->productsdownloadablematerials);
            $model->downloadable_materials = explode(',',$model->downloadable_materials);
            
            $model->productspaidmaterials = explode(',',$model->productspaidmaterials);
            
            $model->downloadable_videos = explode(',',$model->downloadable_videos);
            return $this->render('update', [
                'model' => $model,
                'modelInstallments' => $modelInstallments,
                'modelInstallmentsData' => $modelInstallmentsData,
            ]);
        }
    }

    /**
     * Deletes an existing Courses model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->flagdelete = '1';
        $model->deleted_by = Yii::$app->User->identity->id;
        $model->save();
        
        // change flag of parent category
        $checkAnotherCourseOfSamCat = Courses::find()->where("course_category_id = $model->course_category_id && flagdelete = 0")->all();
        if(!empty($checkAnotherCourseOfSamCat) && count($checkAnotherCourseOfSamCat) > 0)
        { }
        else {
        $catParent = Categories::find()->where("category_id = $model->course_category_id")->one();    
        $catParent->flag_course = 'N';
        $catParent->save();
        }
        
        Yii::$app->session->setFlash('delete',Yii::t('yii','Course has been  Deleted Successfully'));
        return $this->redirect(['index']);
    }
    
    public function actionGetmaterialsforcourse()
    {
        $selectedMaterial = array();
        $model = new Courses();
        $prodId = $_POST['prodId'];
        if(isset($_POST['selectedMaterial']) && $_POST['selectedMaterial'] != "")
        $selectedMaterial = $_POST['selectedMaterial'];
        $datRes = $model->fetchdownlodableandpaidmaterialforcourse($prodId);
        
        // Materials
        $dataProduct = yii\helpers\ArrayHelper::map($datRes['materials'], 'material_id','name','product_name');
        $optStr = '<option value="">-- Select --</option>';
        foreach($dataProduct as $kl => $vl)
        {
            
            $optStr .= "<optgroup label='$kl'>";
            foreach($vl as $kkl => $vvl)
            {
                if(in_array($kkl,$selectedMaterial)) { $temp = 'selected'; } else { $temp = ""; }
                $optStr .= "<option $temp value='$kkl'>" . $vvl . "</option>";
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
                if(in_array($kkl,$selectedMaterial)) { $temp = 'selected'; } else { $temp = ""; }
                $optStr .= "<option $temp value='$kkl'>" . $vvl . "</option>";
            }
            $optStr .= "</optgroup>";
        }
        $finalArr['strvideos'] = $optStr;
        
        
        echo Json::encode($finalArr);
        //return json_encode($datRes);
        
        
    }

    /**
     * Finds the Courses model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Courses the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Courses::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
