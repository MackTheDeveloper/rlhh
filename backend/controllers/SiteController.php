<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use backend\models\Users;
use yii\helpers\Url;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','validateemail','resetpassword','forgotresetpassword'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'validateemail' => ['post'],
                    'Resetpassword' =>['post']
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
            
        if (!Yii::$app->user->isGuest) {
            //return $this->goHome();
            return $this->redirect(['users/index']);
            //return Yii::$app->getResponse()->redirect(Url::toRoute('users'));
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
            //return $this->redirect(['/users']);
            return $this->redirect(['users/index']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function actionValidateemail(){
        if (Yii::$app->request->isAjax && Yii::$app->request->post('email')) {
            $email = Yii::$app->request->post('email');
            $dataUser = Users::find()->where("email = '".$email."'")->one();
            if(!empty($dataUser)){
                //get number send email to user
                $access_token = $this->randomNum();
                $dataUser->password_reset_token = $access_token;
                $dataUser->save();
                Yii::$app->mailer->compose()
                                ->setFrom('vaghasiyajaydeep.magneto@gmail.com')
                                ->setTo($email)
                                ->setSubject('Forgot Password')
                                ->setHtmlBody('<b>Please go to the link <a href="'.Url::to('site/resetpassword?token='.$access_token).'">'.Url::to('site/forgotresetpassword/'.$access_token).'</a> to Reset Password</b>')
                                ->send();
                echo '1';
            }else{
                echo 'Email Id is not Valid';
            }
        }else echo 'Email id must be non-empty';
    }
    
    public function randomNum($length = 5) {
	$salt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $rand = '';
        $i = 0;
        while ($i < $length) { // Loop until you have met the length
          $num = rand() % strlen($salt);
          $tmp = substr($salt, $num, 1);
          $rand = $rand . $tmp;
          $i++;
        }
        return $rand; // Return the random string
    }
    
    public function actionResetpassword($token){
        if($token){
            $dataUser = Users::find()->where("password_reset_token = '".$token."'")->one();
            if(!empty($dataUser)){
                return $this->renderPartial('reset-password',['reset_password_token'=>$token]);
            }else{
                return 'Invalid Access Token';
            }       
        }else{
            return 'No Any Access Token';
        }    
    }
    
    public function actionForgotresetpassword(){
        $token = Yii::$app->request->post('reset_password_token');
        if($token){
            $dataUser = Users::find()->where("password_reset_token = '".$token."'")->one();
            if(!empty($dataUser)){
                $password = Yii::$app->request->post('password');
                $confirm_password = Yii::$app->request->post('confirm_password');
                if($password && $confirm_password && $password == $confirm_password){
                    $dataUser->password = md5($password);
                    $dataUser->password_reset_token = null;
                    $dataUser->save();
                    return $this->redirect('login');
                }else{
                    return 'Password and Confirm Password must not be empty and both must be same!!!';
                }
                
            }else{
                return 'Invalid Access Token';
            }       
        }else{
            return 'No Any Access Token';
        }    
    }
}
