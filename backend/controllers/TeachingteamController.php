<?php

namespace backend\controllers;

use Yii;
use backend\models\Teachingteam;
use backend\models\TeachingteamSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\Json;

/**
 * TeachingteamController implements the CRUD actions for Teachingteam model.
 */
class TeachingteamController extends Controller
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
                    'delete' => ['POST','GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Teachingteam models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TeachingteamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Teachingteam model.
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
     * Creates a new Teachingteam model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Teachingteam();

        if ($model->load(Yii::$app->request->post()))
        {
            $model->created_at = new Expression('NOW()');
            $model->save();
            $modelUpdate = $this->findModel($model->teaching_team_id);
            if(isset($_FILES['Teachingteam']['name']['image']) && $_FILES['Teachingteam']['name']['image'] != "")
            {
                   $uploadedFile = UploadedFile::getInstance($model, "image");
                   $modelUpdate->image = $model->teaching_team_id.'_'.$uploadedFile->name;
                   $extension = $uploadedFile->getExtension();
                    if($extension=="jpg" || $extension=="jpeg" )
                        {
                        $uploadedfile = $_FILES['Teachingteam']['tmp_name']['image'];
                        $src = imagecreatefromjpeg($uploadedfile);
                        }
                        else if($extension=="png")
                        {
                        $uploadedfile = $_FILES['Teachingteam']['tmp_name']['image'];
                        $src = imagecreatefrompng($uploadedfile);
                        }
                        else 
                        {
                        $src = imagecreatefromgif($uploadedfile);
                        }
                    list($width,$height)=getimagesize($uploadedfile);
                    //$newheight=($height/$width)*$newwidth;
                    
                    $newwidth=Yii::$app->params['teachingTeamMemberWidth'];
                    
                    $size     = getimagesize($uploadedfile);
                    $newheight = $size[1];
                    
                    
                    $tmp=imagecreatetruecolor($newwidth,$newheight);
                    imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
                    imagejpeg($tmp,Url::to('@backend').'/web/images/teaching-team/'.$modelUpdate->image,100);
                    $modelUpdate->save();
            }
            
            Yii::$app->session->setFlash('add',Yii::t('yii','Team Member has been Added Successfully.'));
            return $this->redirect(['index']);
        } else {
            $model->status = '1';
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Teachingteam model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()))
        {
            if(isset($_FILES['Teachingteam']['name']['image']) && $_FILES['Teachingteam']['name']['image'] != "")
            {
                
                   $uploadedFile = UploadedFile::getInstance($model, "image");
                   $model->image = $model->teaching_team_id.'_'.$uploadedFile->name;
                   $extension = $uploadedFile->getExtension();
                    if($extension=="jpg" || $extension=="jpeg" )
                        {
                        $uploadedfile = $_FILES['Teachingteam']['tmp_name']['image'];
                        $src = imagecreatefromjpeg($uploadedfile);
                        }
                        else if($extension=="png")
                        {
                        $uploadedfile = $_FILES['Teachingteam']['tmp_name']['image'];
                        $src = imagecreatefrompng($uploadedfile);
                        }
                        else 
                        {
                        $src = imagecreatefromgif($uploadedfile);
                        }
                    list($width,$height)=getimagesize($uploadedfile);
                    //$newheight=($height/$width)*$newwidth;
                    $newwidth=Yii::$app->params['teachingTeamMemberWidth'];
                    
                    $size     = getimagesize($uploadedfile);
                    $newheight = $size[1];
                    
                    
                    $tmp=imagecreatetruecolor($newwidth,$newheight);
                    imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
                    imagejpeg($tmp,Url::to('@backend').'/web/images/teaching-team/'.$model->image,100);
            }
            else
            {
                    $model->image = $model->oldAttributes['image'];
            }
            
            $model->save();
            Yii::$app->session->setFlash('update',Yii::t('yii','Team Member has been Updated Successfully.'));
            return $this->redirect(['index']);  
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Teachingteam model.
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
        Yii::$app->session->setFlash('delete',Yii::t('yii','Team Member has been  Deleted Successfully'));
        return $this->redirect(['index']);
    }

    /**
     * Finds the Teachingteam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Teachingteam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Teachingteam::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
