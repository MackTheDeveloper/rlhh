<?php

namespace backend\controllers;

use Yii;
use backend\models\Products;
use backend\models\ProductsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\web\UploadedFile;
use yii\helpers\Url;
use backend\models\ProductMaterials;
use backend\models\ProductCategories;
// DECLARATION FOR AJAX VALIDATION
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
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
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
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
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();
         if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        $modelProductMaterials = new ProductMaterials();

        if ($model->load(Yii::$app->request->post()) || $modelProductMaterials->load(Yii::$app->request->post())) 
        {
            $model->created_at = new Expression('NOW()');
            $model->save();
            
            // Set flag_product in product category
            $dataProductCat = ProductCategories::find()->where("category_id = $model->category_id")->one();
            $dataProductCat->flag_product = 'Y';
            $dataProductCat->save();
            
            $modelUpdate = $this->findModel($model->product_id);
            if(isset($_FILES['Products']['name']['image']) && $_FILES['Products']['name']['image'] != "")
            {
                   $uploadedFile = UploadedFile::getInstance($model, "image");
                   $modelUpdate->image = $model->product_id.'_'.$uploadedFile->name;
                   $extension = $uploadedFile->getExtension();
                    if($extension=="jpg" || $extension=="jpeg" )
                        {
                        $uploadedfile = $_FILES['Products']['tmp_name']['image'];
                        $src = imagecreatefromjpeg($uploadedfile);
                        }
                        else if($extension=="png")
                        {
                        $uploadedfile = $_FILES['Products']['tmp_name']['image'];
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
                    imagejpeg($tmp,Url::to('@backend').'/web/images/products/'.$modelUpdate->image,100);
                    $modelUpdate->save();
            }
            
            // SAVE DOWNLOADABLE MATERIALS
            if (isset($_FILES['ProductMaterials']) && count($_FILES['ProductMaterials']['error']['attachments']) == 1 && $_FILES['ProductMaterials']['error']['attachments'][0] > 0) {

            } else {
                $countDownloadableMarerial = count($_FILES['ProductMaterials']['name']['attachments']);
                $time = date('YmdHis');
                for ($l = 0; $l < $countDownloadableMarerial; $l++) {
                    $uploadedFile = \yii\web\UploadedFile::getInstance($modelProductMaterials, "attachments[$l]");
                    if ($uploadedFile) {
                        $docNameparts = explode('.', $uploadedFile);
                        $docName = $docNameparts[0];
                        $extension = $uploadedFile->getExtension();
                        $modelProductMaterials->url_material = $docName . '_' . $time . rand(0, 1000) . '.' . $extension;
                        $uploadedFile->saveAs(Yii::$app->basePath . '/web/images/product-materials/' . $modelProductMaterials->url_material);
                    } else {
                        $modelProductMaterials->url_material = "";
                    }
                    $modelProductMaterials->category_id = $model->category_id;
                    $modelProductMaterials->product_id = $model->product_id;
                    $modelProductMaterials->name = $_POST['ProductMaterials']['attachmentsname'][$l];
                    $modelProductMaterials->flag_material = 'D';
                    $modelProductMaterials->material_type = 'O';
                    $modelProductMaterials->material_id = null;
                    $modelProductMaterials->isNewRecord = true;
                    $modelProductMaterials->save();    
                }
            }
            
            
            
            // SAVE DOWNLOADABLE VIDEOS
            if (isset($_FILES['ProductMaterials']) && count($_FILES['ProductMaterials']['error']['videosdownloadable']) == 1 && $_FILES['ProductMaterials']['error']['videosdownloadable'][0] > 0) {

            } else {
                $countDownloadableMarerial = count($_FILES['ProductMaterials']['name']['videosdownloadable']);
                $time = date('YmdHis');
                for ($l = 0; $l < $countDownloadableMarerial; $l++) {
                    $uploadedFile = \yii\web\UploadedFile::getInstance($modelProductMaterials, "videosdownloadable[$l]");
                    if ($uploadedFile) {
                        $docNameparts = explode('.', $uploadedFile);
                        $docName = $docNameparts[0];
                        $extension = $uploadedFile->getExtension();
                        $modelProductMaterials->url_material = $docName . '_' . $time . rand(0, 1000) . '.' . $extension;
                        $uploadedFile->saveAs(Yii::$app->basePath . '/web/images/product-materials/' . $modelProductMaterials->url_material);
                    } else {
                        $modelProductMaterials->url_material = "";
                    }
                    $modelProductMaterials->category_id = $model->category_id;
                    $modelProductMaterials->product_id = $model->product_id;
                    $modelProductMaterials->name = $_POST['ProductMaterials']['videosdownloadablename'][$l];
                    $modelProductMaterials->flag_material = 'D';
                    $modelProductMaterials->material_type = 'V';
                    $modelProductMaterials->material_id = null;
                    $modelProductMaterials->isNewRecord = true;
                    $modelProductMaterials->save();    
                }
            }
            
            
           
            Yii::$app->session->setFlash('add',Yii::t('yii','Product has been Added Successfully.'));
            return $this->redirect(['index']);
        } else {
             $model->status = 1;
             $model->cost_type = 'Paid';
            return $this->render('create', [
                'model' => $model,
                'modelProductMaterials' => $modelProductMaterials,
            ]);
        }
    }

    /**
     * Updates an existing Products model.
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
        $modelProductMaterials = new ProductMaterials();
        if ($model->load(Yii::$app->request->post())) 
        {
            
            if(isset($_FILES['Products']['name']['image']) && $_FILES['Products']['name']['image'] != "")
            {
                   $uploadedFile = UploadedFile::getInstance($model, "image");
                   $model->image = $model->product_id.'_'.$uploadedFile->name;
                   $extension = $uploadedFile->getExtension();
                    if($extension=="jpg" || $extension=="jpeg" )
                        {
                        $uploadedfile = $_FILES['Products']['tmp_name']['image'];
                        $src = imagecreatefromjpeg($uploadedfile);
                        }
                        else if($extension=="png")
                        {
                        $uploadedfile = $_FILES['Products']['tmp_name']['image'];
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
                    imagejpeg($tmp,Url::to('@backend').'/web/images/products/'.$model->image,100);
            }
            else
            {
                    $model->image = $model->oldAttributes['image'];
            }
            $model->save();
            
            // SAVE DOWNLOADABLE MATERIALS
            if (isset($_FILES['ProductMaterials']) && count($_FILES['ProductMaterials']['error']['attachments']) == 1 && $_FILES['ProductMaterials']['error']['attachments'][0] > 0) {

            } else {
                $countDownloadableMarerial = count($_FILES['ProductMaterials']['name']['attachments']);
                $time = date('YmdHis');
                for ($l = 0; $l < $countDownloadableMarerial; $l++) {
                    $uploadedFile = \yii\web\UploadedFile::getInstance($modelProductMaterials, "attachments[$l]");
                    if ($uploadedFile) {
                        $docNameparts = explode('.', $uploadedFile);
                        $docName = $docNameparts[0];
                        $extension = $uploadedFile->getExtension();
                        $modelProductMaterials->url_material = $docName . '_' . $time . rand(0, 1000) . '.' . $extension;
                        $uploadedFile->saveAs(Yii::$app->basePath . '/web/images/product-materials/' . $modelProductMaterials->url_material);
                    } else {
                        $modelProductMaterials->url_material = "";
                    }
                    $modelProductMaterials->category_id = $model->category_id;
                    $modelProductMaterials->product_id = $model->product_id;
                    $modelProductMaterials->name = $_POST['ProductMaterials']['attachmentsname'][$l];
                    $modelProductMaterials->flag_material = 'D';
                    $modelProductMaterials->material_type = 'O';
                    $modelProductMaterials->material_id = null;
                    $modelProductMaterials->isNewRecord = true;
                    $modelProductMaterials->save();    
                }
            }
            
           
            
            // SAVE DOWNLOADABLE VIDEOS
            if (isset($_FILES['ProductMaterials']) && count($_FILES['ProductMaterials']['error']['videosdownloadable']) == 1 && $_FILES['ProductMaterials']['error']['videosdownloadable'][0] > 0) {

            } else {
                $countDownloadableMarerial = count($_FILES['ProductMaterials']['name']['videosdownloadable']);
                $time = date('YmdHis');
                for ($l = 0; $l < $countDownloadableMarerial; $l++) {
                    $uploadedFile = \yii\web\UploadedFile::getInstance($modelProductMaterials, "videosdownloadable[$l]");
                    if ($uploadedFile) {
                        $docNameparts = explode('.', $uploadedFile);
                        $docName = $docNameparts[0];
                        $extension = $uploadedFile->getExtension();
                        $modelProductMaterials->url_material = $docName . '_' . $time . rand(0, 1000) . '.' . $extension;
                        $uploadedFile->saveAs(Yii::$app->basePath . '/web/images/product-materials/' . $modelProductMaterials->url_material);
                    } else {
                        $modelProductMaterials->url_material = "";
                    }
                    $modelProductMaterials->category_id = $model->category_id;
                    $modelProductMaterials->product_id = $model->product_id;
                    $modelProductMaterials->name = $_POST['ProductMaterials']['videosdownloadablename'][$l];
                    $modelProductMaterials->flag_material = 'D';
                    $modelProductMaterials->material_type = 'V';
                    $modelProductMaterials->material_id = null;
                    $modelProductMaterials->isNewRecord = true;
                    $modelProductMaterials->save();    
                }
            }
            
            Yii::$app->session->setFlash('update',Yii::t('yii','Product has been Updated Successfully.'));
            return $this->redirect(['index']);   
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelProductMaterials' => $modelProductMaterials,
            ]);
        }
    }

    /**
     * Deletes an existing Products model.
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
        $checkAnotherProductOfSamCat = Products::find()->where("category_id = $model->category_id && flagdelete = 0")->all();
        if(!empty($checkAnotherProductOfSamCat) && count($checkAnotherProductOfSamCat) > 0)
        { }
        else {
        $catParent = ProductCategories::find()->where("category_id = $model->category_id")->one();    
        $catParent->flag_product = 'N';
        $catParent->save();
        }
        
        ProductMaterials::deleteAll(['product_id'=>$model->product_id]);
        Yii::$app->session->setFlash('delete',Yii::t('yii','Product has been  Deleted Successfully'));
        return $this->redirect(['index']);
    }
    
    // DELETE MATERIAL WHEN CLICK ON DELETE BUTTON
    public function actionDeletematerial()
    {
        $imgId = $_POST['imageid'];
        $productId = $_POST['productId'];
        $code = $_POST['code'];
        
        $dataImage = ProductMaterials::find()->where("material_id = $imgId")->one();
        $dataImage->delete();
        $path = Url::to('@backend').'/web/images/product-materials/'.$dataImage->url_material;
        $removeFilePath = $path;
        unlink($removeFilePath);
        return $this->renderPartial('deletematerial',['productId'=>$productId,'code'=>$code]);
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
