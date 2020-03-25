<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\Signup;

class SiteController extends Controller
{
public function actionIndex()
{
    return $this->render('index');
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
}
