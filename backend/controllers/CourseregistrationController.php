<?php

namespace backend\controllers;

use Yii;
use backend\models\Courseregistration;
use backend\models\CourseregistrationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CourseregistrationController implements the CRUD actions for Courseregistration model.
 */
class CourseregistrationController extends Controller
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
     * Lists all Courseregistration models.
     * @return mixed
     */
    
    public function actionIndex()
    {
        $filterModel = new Courseregistration();
        $filterModel->scenario = 'outsidefilter';
        
        $searchModel = new CourseregistrationSearch();
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
            if($dataProvider->query->where == "courseregistration.flagdelete = 0")
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
        $model = new Courseregistration();
        $searchModel = new CourseregistrationSearch();
        
        if(isset($_POST['Courseregistration']) && isset($_POST['Courseregistration']['tt']) && $_POST['Courseregistration']['tt'] != null)
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
     * Displays a single Courseregistration model.
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
     * Creates a new Courseregistration model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Courseregistration();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->courseregistration_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Courseregistration model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->courseregistration_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Courseregistration model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionChangecourseregistrationstatus()
    {
     
        $id = $_POST['id'];
        $dataCourseRegi = Courseregistration::find()->where("courseregistration_id = $id")->one();
        if($dataCourseRegi->status_registration == "Unpaid" || $dataCourseRegi->status_registration == "All")
        $dataCourseRegi->status_registration = "Paid";
        $dataCourseRegi->save();
        echo 'Status have been changed successfully';
    }

    /**
     * Finds the Courseregistration model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Courseregistration the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Courseregistration::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
