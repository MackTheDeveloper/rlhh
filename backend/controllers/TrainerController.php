<?php

namespace backend\controllers;

use Yii;
use backend\models\Trainer;
use backend\models\TrainerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * TrainerController implements the CRUD actions for Trainer model.
 */
class TrainerController extends Controller
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
     * Lists all Trainer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $filterModel = new Trainer();
        $filterModel->scenario = 'outsidefilter';
        
        $searchModel = new TrainerSearch();
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
            if($dataProvider->query->where == "flagdelete = 0")
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
        $model = new Trainer();
        $searchModel = new TrainerSearch();
        
        if(isset($_POST['Trainer']) && isset($_POST['Trainer']['tt']) && $_POST['Trainer']['tt'] != null)
        {
           // pre($_POST);
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
     * Displays a single Trainer model.
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
     * Creates a new Trainer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Trainer();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()))
        {
            $model->created_at = new Expression('NOW()');
            $model->password = md5($model->password);
            $model->save();
            Yii::$app->session->setFlash('add',Yii::t('yii','Trainer has been Added Successfully.'));
            return $this->redirect(['index']);
        } else {
            $model->status = 1;
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Trainer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()))
        {
            $model->save();
            Yii::$app->session->setFlash('update',Yii::t('yii','Trainer has been Updated Successfully.'));
            return $this->redirect(['index']);  
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Trainer model.
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
        Yii::$app->session->setFlash('delete',Yii::t('yii','Trainer has been  Deleted Successfully'));
        return $this->redirect(['index']);
    }
    
    public function actionChangestatus()
    {
        $id = $_POST['id'];
        $dataTrainer = Trainer::find()->where("trainer_id = $id")->one();
        if($dataTrainer->status == 1)
        $dataTrainer->status = 0;
        else
        $dataTrainer->status = 1;
        $dataTrainer->save();
        echo 'Status have been changed successfully';
    }
    
    public function actionViewdetail($id)
    {
        $model = $this->findModel($id);
        return $this->renderAjax('viewdetail',['model'=>$model]);
    }

    /**
     * Finds the Trainer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Trainer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Trainer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
