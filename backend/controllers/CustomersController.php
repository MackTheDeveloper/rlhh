<?php

namespace backend\controllers;

use Yii;
use backend\models\Customers;
use backend\models\CustomersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomersController implements the CRUD actions for Customers model.
 */
class CustomersController extends Controller
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
     * Lists all Customers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $filterModel = new Customers();
        $filterModel->scenario = 'outsidefilter';
        
        $searchModel = new CustomersSearch();
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
        $model = new Customers();
        $searchModel = new CustomersSearch();
        
        if(isset($_POST['Customers']) && isset($_POST['Customers']['tt']) && $_POST['Customers']['tt'] != null)
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
    
    
    public function actionChangestatus()
    {
        $id = $_POST['id'];
        $dataCustomer = Customers::find()->where("customer_id = $id")->one();
        if($dataCustomer->status == 1)
        $dataCustomer->status = 0;
        else
        $dataCustomer->status = 1;
        $dataCustomer->save();
        echo 'Status have been changed successfully';
    }
    
    public function actionViewdetail($id)
    {
        $model = $this->findModel($id);
        return $this->renderAjax('viewdetail',['model'=>$model]);
    }

    /**
     * Displays a single Customers model.
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
     * Creates a new Customers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customers();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->customer_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Customers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->customer_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Customers model.
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
        Yii::$app->session->setFlash('delete',Yii::t('yii','Customer has been  Deleted Successfully'));
        return $this->redirect(['index']);
    }

    /**
     * Finds the Customers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
