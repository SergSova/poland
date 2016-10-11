<?php

    namespace backend\models\form;

    use common\models\User;
    use Yii;
    use yii\base\Model;

    class RegistrationForm extends Model{

        public $username;
        public $email;
        public $password;
        public $password_repeat;

        public static function confirm($token){
            $transaction = Yii::$app->db->beginTransaction();

            try{
                $user = User::findByPasswordResetToken($token);
                if(!$user){
                    throw new \Exception('no User by token');
                }

                $user->removePasswordResetToken();
                $user->status = User::STATUS_ACTIVE;
                if(!$user->save()){
                }
                $authManager = Yii::$app->getAuthManager();
                $role = $authManager->getRole('admin');
                if(!$authManager->assign($role, $user->id)){
                    throw new \Exception('rback not initialized');
                }

                Yii::$app->user->login($user, 3600 * 24 * 30);
                $transaction->commit();

                return true;
            }catch(\Exception $e){
                $transaction->rollBack();

                return false;
            }
        }

        public function rules(){
            return [
                [['username', 'password', 'email'], 'required'],
                [['username'], 'unique', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['username' => 'username']],
                [['email'], 'unique', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['email' => 'email']],
                ['email', 'email'],
                [['email', 'password', 'password_repeat', 'username'], 'trim'],
                ['password', 'compare'],
            ];
        }

        public function attributeLabels(){
            return [
                'username'        => 'Ваш логин',
                'email'           => 'Ваш Email',
                'password'        => 'Подтвердите пароль',
                'password_repeat' => 'Ваш пароль',
            ];
        }

        public function register(){
            if($this->validate()){
                $transaction = Yii::$app->db->beginTransaction();
                try{
                    $user = new User();
                    $user->username = $this->username;
                    $user->email = $this->email;
                    $user->setPassword($this->password);
                    $user->password = $this->password;
                    $user->generatePasswordResetToken();
                    $user->status = User::STATUS_DELETED;

                    if(!$user->save(false)){
                        throw new \Exception('save False');
                    }

                    if(!Yii::$app->mailer->compose(['html' => 'registrationConfirm-html'], ['user' => $user])
                                         ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name.' robot'])
                                         ->setTo($user->email)
                                         ->setSubject('Confirm registration on '.Yii::$app->name)
                                         ->send()
                    ){
                        throw new \Exception('send False');
                    }
                    $transaction->commit();

                    Yii::$app->session->setFlash('success', 'Follow in your mail to confirm registration');

                    return true;
                }catch(\Exception $e){
                    $transaction->rollBack();

                    return false;
                }
            }
        }

    }