<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\Signup;
use app\models\Login;
use app\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\PasswordForm;

class SiteController extends Controller
{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout','changepassword'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

public function actionIndex()
{
    return $this->render('index');
}

public function actionLogout()
{
    if(!Yii::$app->user->isGuest)
    {
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }
}

public function actionSignup()
{
    $model = new Signup();
    if(isset($_POST['Signup']))
    {
        $model->attributes = Yii::$app->request->post('Signup');
        if($model->validate() && $model->signup())
        {
            return $this->goHome();
        }
    }
    return $this->render('signup', ['model'=>$model]);
}

public function actionLogin()
    {
        if(!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }

        $login_model = new Login();

        if( Yii::$app->request->post('Login'))
        {
            $login_model->attributes = Yii::$app->request->post('Login');

            if($login_model->validate())
            {
                Yii::$app->user->login($login_model->getUser());
                if(Yii::$app->user->identity->isAdmin === 1) 
                {
                    return $this->redirect(['admin/user']);
                } else {
                    return $this->redirect(['index']);
                }
                
            }
        }

        return $this->render('login',['login_model'=>$login_model]);
    }

public function actionChangepassword()
 {
        $model = new PasswordForm;
        $modeluser = User::find()->where([
            'email'=>Yii::$app->user->identity->email
        ])->one();
     
        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                try{
                    $modeluser->password = Yii::$app->security->generatePasswordHash($_POST['PasswordForm']['newpass']);
                    if($modeluser->save()){
                        Yii::$app->getSession()->setFlash(
                            'success','Password changed'
                        );
                        return $this->redirect(['index']);
                    }else{
                        Yii::$app->getSession()->setFlash(
                            'error','Password not changed'
                        );
                        return $this->redirect(['index']);
                    }
                }catch(Exception $e){
                    Yii::$app->getSession()->setFlash(
                        'error',"{$e->getMessage()}"
                    );
                    return $this->render('changepassword',[
                        'model'=>$model
                    ]);
                }
            }else{
                return $this->render('changepassword',[
                    'model'=>$model
                ]);
            }
        }else{
            return $this->render('changepassword',[
                'model'=>$model
            ]);
        }
    }
}
