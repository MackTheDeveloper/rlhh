<?php

namespace backend\controllers;

use Yii;
use backend\models\Collaboration;
use backend\models\CollaborationSearch;
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
 * CollaborationController implements the CRUD actions for Collaboration model.
 */
class CollaborationController extends Controller
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
     * Lists all Collaboration models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CollaborationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Collaboration model.
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
     * Creates a new Collaboration model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Collaboration();

        if ($model->load(Yii::$app->request->post()))
        {
            $model->created_at = new Expression('NOW()');
            $model->save();
            $modelUpdate = $this->findModel($model->collaboration_id);
            if(isset($_FILES['Collaboration']['name']['image']) && $_FILES['Collaboration']['name']['image'] != "")
            {
                   $uploadedFile = UploadedFile::getInstance($model, "image");
                   $modelUpdate->image = $model->collaboration_id.'_'.$uploadedFile->name;
                   $extension = $uploadedFile->getExtension();
                    if($extension=="jpg" || $extension=="jpeg" )
                        {
                        $uploadedfile = $_FILES['Collaboration']['tmp_name']['image'];
                        $src = imagecreatefromjpeg($uploadedfile);
                        }
                        else if($extension=="png")
                        {
                        $uploadedfile = $_FILES['Collaboration']['tmp_name']['image'];
                        $src = imagecreatefrompng($uploadedfile);
                        }
                        else 
                        {
                        $src = imagecreatefromgif($uploadedfile);
                        }
                    list($width,$height)=getimagesize($uploadedfile);
                    //$newheight=($height/$width)*$newwidth;
                    $newwidth=Yii::$app->params['collaborationBgWidth'];
                    $newheight= Yii::$app->params['collaborationBgHeight'];
                    $tmp=imagecreatetruecolor($newwidth,$newheight);
                    imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
                    imagejpeg($tmp,Url::to('@backend').'/web/images/collaboration/'.$modelUpdate->image,100);
                    $modelUpdate->save();
            }
            if(isset($_FILES['Collaboration']['name']['logo']) && $_FILES['Collaboration']['name']['logo'] != "")
            {
                   $uploadedFile = UploadedFile::getInstance($model, "logo");
                   $modelUpdate->logo = $model->collaboration_id.'_logo_'.$uploadedFile->name;
                   $extension = $uploadedFile->getExtension();
                    if($extension=="jpg" || $extension=="jpeg" )
                        {
                        $uploadedfile = $_FILES['Collaboration']['tmp_name']['logo'];
                        $src = imagecreatefromjpeg($uploadedfile);
                        }
                        else if($extension=="png")
                        {
                        $uploadedfile = $_FILES['Collaboration']['tmp_name']['logo'];
                        $src = imagecreatefrompng($uploadedfile);
                        }
                        else 
                        {
                        $src = imagecreatefromgif($uploadedfile);
                        }
                    list($width,$height)=getimagesize($uploadedfile);
                    //$newheight=($height/$width)*$newwidth;
                    $newwidth=Yii::$app->params['collaborationLogoWidth'];
                    $newheight= Yii::$app->params['collaborationLogoHeight'];
                    $tmp=imagecreatetruecolor($newwidth,$newheight);
                    imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
                    imagejpeg($tmp,Url::to('@backend').'/web/images/collaboration/'.$modelUpdate->logo,100);
                    $modelUpdate->save();
            }
            Yii::$app->session->setFlash('add',Yii::t('yii','Collaboration has been Added Successfully.'));
            return $this->redirect(['index']);
        } else {
            $model->status = '1';
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Collaboration model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()))
        {
            if(isset($_FILES['Collaboration']['name']['image']) && $_FILES['Collaboration']['name']['image'] != "")
            {
                
                   $uploadedFile = UploadedFile::getInstance($model, "image");
                   $model->image = $model->collaboration_id.'_'.$uploadedFile->name;
                   $extension = $uploadedFile->getExtension();
                    if($extension=="jpg" || $extension=="jpeg" )
                        {
                        $uploadedfile = $_FILES['Collaboration']['tmp_name']['image'];
                        $src = imagecreatefromjpeg($uploadedfile);
                        }
                        else if($extension=="png")
                        {
                        $uploadedfile = $_FILES['Collaboration']['tmp_name']['image'];
                        $src = imagecreatefrompng($uploadedfile);
                        }
                        else 
                        {
                        $src = imagecreatefromgif($uploadedfile);
                        }
                    list($width,$height)=getimagesize($uploadedfile);
                    //$newheight=($height/$width)*$newwidth;
                    $newwidth=Yii::$app->params['collaborationBgWidth'];
                    $newheight= Yii::$app->params['collaborationBgHeight'];
                    $tmp=imagecreatetruecolor($newwidth,$newheight);
                    imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
                    imagejpeg($tmp,Url::to('@backend').'/web/images/collaboration/'.$model->image,100);
            }
            else
            {
                    $model->image = $model->oldAttributes['image'];
            }
            
            if(isset($_FILES['Collaboration']['name']['logo']) && $_FILES['Collaboration']['name']['logo'] != "")
            {
                   $uploadedFile = UploadedFile::getInstance($model, "logo");
                   $model->logo = $model->collaboration_id.'_logo_'.$uploadedFile->name;
                   $extension = $uploadedFile->getExtension();
                    if($extension=="jpg" || $extension=="jpeg" )
                        {
                        $uploadedfile = $_FILES['Collaboration']['tmp_name']['logo'];
                        $src = imagecreatefromjpeg($uploadedfile);
                        }
                        else if($extension=="png")
                        {
                        $uploadedfile = $_FILES['Collaboration']['tmp_name']['logo'];
                        $src = imagecreatefrompng($uploadedfile);
                        }
                        else 
                        {
                        $src = imagecreatefromgif($uploadedfile);
                        }
                    list($width,$height)=getimagesize($uploadedfile);
                    //$newheight=($height/$width)*$newwidth;
                    $newwidth=Yii::$app->params['collaborationLogoWidth'];
                    $newheight= Yii::$app->params['collaborationLogoHeight'];
                    $tmp=imagecreatetruecolor($newwidth,$newheight);
                    imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
                    imagejpeg($tmp,Url::to('@backend').'/web/images/collaboration/'.$model->logo,100);
                    
            }
            else
            {
                    $model->logo = $model->oldAttributes['logo'];
            }
            
            $model->save();
            Yii::$app->session->setFlash('update',Yii::t('yii','Collaboration has been Updated Successfully.'));
            return $this->redirect(['index']);  
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Collaboration model.
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
        Yii::$app->session->setFlash('delete',Yii::t('yii','Collaboration has been  Deleted Successfully'));
        return $this->redirect(['index']);
    }

    /**
     * Finds the Collaboration model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Collaboration the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Collaboration::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
