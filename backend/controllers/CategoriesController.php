<?php

namespace backend\controllers;

use Yii;
use backend\models\Categories;
use backend\models\CategoriesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\web\UploadedFile;
use yii\helpers\Url;
/**
 * CategoriesController implements the CRUD actions for Categories model.
 */
class CategoriesController extends Controller
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
     * Lists all Categories models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndexsubcategory($id)
    {
        
        $searchModel = new CategoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        //return $this->redirect('indexsub',['searchModel' => $searchModel,'dataProvider' => $dataProvider]);
        return $this->redirect(['categories/indexsub','id' => $id]);
        /*return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]); */
    }
    public function actionIndexsub($id)
        {
            $searchModel = new CategoriesSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            //return $this->redirect('indexsub',['searchModel' => $searchModel,'dataProvider' => $dataProvider]);
            return $this->render('indexsub', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
        }
        
     public function actionGetcategories()
     {
         $model = new Categories;
         $dataCatAll = $model->getAllCategories();
         foreach($dataCatAll as $vl)
        {
            $fData['label'] = $vl->name;
            $check = $model->checkHasSubCatOrNot($vl->category_id);
            if($check == 0){
                $fData['value'] = $vl->parent_id;
            }else{
                $fData['value'] = $vl->category_id;
            }
            
            $final1[] = $fData;
        }
         echo json_encode($final1);
     }

    /**
     * Displays a single Categories model.
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
     * Creates a new Categories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Categories();

        if ($model->load(Yii::$app->request->post()))
        {    
            if($model->parent_id == "") { $model->parent_id = 0; }
            $model->created_at = new Expression('NOW()');
            $model->save();
            $modelUpdate = $this->findModel($model->category_id);
            if(isset($_FILES['Categories']['name']['image']) && $_FILES['Categories']['name']['image'] != "")
            {
                   $uploadedFile = UploadedFile::getInstance($model, "image");
                   $modelUpdate->image = $model->category_id.'_'.$uploadedFile->name;
                   $extension = $uploadedFile->getExtension();
                    if($extension=="jpg" || $extension=="jpeg" )
                        {
                        $uploadedfile = $_FILES['Categories']['tmp_name']['image'];
                        $src = imagecreatefromjpeg($uploadedfile);
                        }
                        else if($extension=="png")
                        {
                        $uploadedfile = $_FILES['Categories']['tmp_name']['image'];
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
                    imagejpeg($tmp,Url::to('@backend').'/web/images/categories/'.$modelUpdate->image,100);
                    $modelUpdate->save();
                    
            }
            
            if($model->parent_id != ""){
            $pathOfParentId = Categories::find()->where("category_id = $model->parent_id")->one();   
            $pathOfParentId->flag_category = 'Y';
            $pathOfParentId->save();
            
            $modelUpdate->category_path = (string) $pathOfParentId->category_path.','.$model->category_id;
            $modelUpdate->type = $pathOfParentId->type;
            }else{
            $modelUpdate->category_path = (string) $model->category_id;    
            }
            $modelUpdate->save();
            Yii::$app->session->setFlash('add',Yii::t('yii','Category has been Added Successfully.'));
            
            if(isset(Yii::$app->request->post()['Categories']['parent_id']))
            {
                return $this->redirect(['indexsub','id'=>Yii::$app->request->post()['Categories']['parent_id']]);
            }else{
                return $this->redirect(['index']);
            }
            
            
            
        } else {
            $model->status = 1;
            $model->type = 'C';
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Categories model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()))
        {
            
             if($model->parent_id == "") { $model->parent_id = 0; }
             if(isset($_FILES['Categories']['name']['image']) && $_FILES['Categories']['name']['image'] != "")
                {
                       $uploadedFile = UploadedFile::getInstance($model, "image");
                       $model->image = $model->category_id.'_'.$uploadedFile->name;
                       $extension = $uploadedFile->getExtension();
                        if($extension=="jpg" || $extension=="jpeg" )
                            {
                            $uploadedfile = $_FILES['Categories']['tmp_name']['image'];
                            $src = imagecreatefromjpeg($uploadedfile);
                            }
                            else if($extension=="png")
                            {
                            $uploadedfile = $_FILES['Categories']['tmp_name']['image'];
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
                        imagejpeg($tmp,Url::to('@backend').'/web/images/categories/'.$modelUpdate->image,100);
                }else{
                    $model->image = $model->oldAttributes['image'];
                }
             if($model->parent_id != ""){
            $pathOfParentId = Categories::find()->where("category_id = $model->parent_id")->one();    
            $model->category_path = (string) $pathOfParentId->category_path.','.$model->category_id;
            $model->type = $pathOfParentId->type;
            }else{
            $model->category_path = (string) $model->category_id;    
            }   
             $model->save();
             Yii::$app->session->setFlash('update',Yii::t('yii','Category has been Updated Successfully.'));
            return $this->redirect(['index']);   
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Categories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        
        $model = $this->findModel($id);
        $res = $model->checkHasSubCatOrNot($id);
        if($res == 1)
        {
        Yii::$app->session->setFlash('delete',Yii::t('yii','Oooops Wrong !! Delete child categories first..'));
        return $this->redirect(['index']);    
        }else{
        $model->flagdelete = '1';
        $model->deleted_by = Yii::$app->User->identity->id;
        $model->save();
        
        // change flag of parent category
        $checkAnotherCat = Categories::find()->where("parent_id = $model->parent_id && flagdelete = 0")->all();
        if(!empty($checkAnotherCat) && count($checkAnotherCat) > 0)
        { }
        else {
        $catParent = $this->findModel($model->parent_id);
        $catParent->flag_category = 'N';
        $catParent->save();
        }
        
        Yii::$app->session->setFlash('delete',Yii::t('yii','Category has been  Deleted Successfully'));
        return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Categories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Categories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categories::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
