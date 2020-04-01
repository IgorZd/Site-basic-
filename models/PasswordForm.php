<?php
    namespace app\models;
   
    use Yii;
    use yii\base\Model;
    use app\models\User;
   
    class PasswordForm extends Model
    {
        public $oldpass;
        public $newpass;
        public $repeatnewpass;
       
        public function rules()
        {
            return [
                [['oldpass','newpass','repeatnewpass'],'required'],
                ['oldpass','findPasswords'],
                ['repeatnewpass','compare','compareAttribute'=>'newpass'],
                ['newpass','string','min' => 8],
            ];
        }
       
        public function findPasswords($attribute, $params){
            $user = User::find()->where([
                'email'=>Yii::$app->user->identity->email
            ])->one();
            $password = $user->password;
            $hash = Yii::$app->getSecurity()->generatePasswordHash($password);
            $valid_password = Yii::$app->getSecurity()->validatePassword($password, $hash);
            if($valid_password === false && $password!=$this->oldpass)
                $this->addError($attribute,'Old password is incorrect');
        }
       
        public function attributeLabels(){
            return [
                'oldpass'=>'Old Password',
                'newpass'=>'New Password',
                'repeatnewpass'=>'Repeat New Password',
            ];
        }
    }