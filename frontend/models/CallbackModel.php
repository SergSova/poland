<?php
    namespace frontend\models;

    use Yii;
    use yii\base\Model;

    class CallbackModel extends Model{
        public $name;
        public $subject;
        public $phone;
        public $successMessage = '';
        public function rules(){
            return [
                [['name', 'phone', 'subject'], 'required'],
                ['phone', 'match', 'pattern' => '/^\+?[78]{1}\d{10}$/i','message' => 'Не правильный формат телефона +7(8) 000 000 00 00'],
            ];
        }

        public function attributeLabels()
        {
            return [
                'name' => 'Ваше имя',
                'phone' => 'Ваш телефон',
                'subject' => 'Тема',
            ];
        }

        public function sendMail(){
            $body = "Имя отправителя: ".$this->name."\n\rТелефон отправителя: ".$this->phone."\n\rДата запроса: ".date("d m Y H:i");
            $this->successMessage = 'Мы свяжемся с Вами в ближайщее время!';
            Yii::$app->mailer->compose()
                             ->setFrom(Yii::$app->params['robotEmail'])
                             ->setTo(Yii::$app->params['adminEmail'])
                             ->setSubject($this->subject)
                             ->setTextBody($body)
                             ->setHtmlBody($body)
                             ->send();
        }
    }