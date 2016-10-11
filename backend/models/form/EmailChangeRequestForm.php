<?php

    namespace backend\models\form;

    use common\models\User;
    use Yii;
    use yii\base\InvalidParamException;
    use yii\base\Model;

    class EmailChangeRequestForm extends Model{
        public $new_email;

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                ['new_email', 'trim'],
                ['new_email', 'required'],
                ['new_email', 'email'],
            ];
        }

        public function sendEmail(){
            /* @var $user User */
            $user = Yii::$app->user->identity;

            if(!$user){
                return false;
            }

            if(!User::isPasswordResetTokenValid($user->password_reset_token)){
                $user->generatePasswordResetToken();
                if(!$user->save()){
                    return false;
                }
            }

            return Yii::$app->mailer->compose(['html' => 'emailChangeToken-html'], ['user' => $user, 'new_email' => $this->new_email])
                                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name.' robot'])
                                    ->setTo($user->email)
                                    ->setSubject('Change email for '.Yii::$app->name.' to '.$this->new_email)
                                    ->send();
        }


        public static function changeEmail($token, $email){

            if(empty($token) || !is_string($token)){
                throw new InvalidParamException('Password reset token cannot be blank.');
            }
            $user = User::findByPasswordResetToken($token);
            if(!$user){
                throw new InvalidParamException('Wrong password reset token.');
            }else{
                $user->email = $email;
                $user->removePasswordResetToken();

                return $user->save(false);
            }
        }
    }