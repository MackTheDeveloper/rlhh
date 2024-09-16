<?php

namespace backend\controllers;

use Yii;
use backend\models\AssignCourses;
use backend\models\AssignCoursesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AssignCoursesController implements the CRUD actions for AssignCourses model.
 */
class AssignCoursesController extends Controller
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
     * Lists all AssignCourses models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AssignCoursesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AssignCourses model.
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
     * Creates a new AssignCourses model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AssignCourses();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->assign_course_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
     public function actionAssigntoothercategories($id)
    {
          $model = new AssignCourses();
          $modelCourse = \backend\models\Courses::find()->where("course_id = $id")->one();
           if($model->load(Yii::$app->request->post())) 
           {
                $model::deleteAll(['course_id'=>$model->course_id]);
                if(!empty($_POST['AssignCourses']['course_category_id']))
                {
                    foreach($_POST['AssignCourses']['course_category_id'] as $v)
                    {
                        $model->course_category_id = $v;
                        $model->assign_course_id = null;
                        $model->isNewRecord = true;
                        $model->save();
                    }
                }
                Yii::$app->session->setFlash('add',Yii::t('yii','Categories has been Assigned Successfully.'));
                return $this->redirect(['courses/index']);
           }
          else{
           return $this->renderAjax('assingcourse',['model'=>$model,'modelCourse'=>$modelCourse]);   
          }
          
    }

    /**
     * Updates an existing AssignCourses model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->assign_course_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AssignCourses model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AssignCourses model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AssignCourses the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AssignCourses::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
