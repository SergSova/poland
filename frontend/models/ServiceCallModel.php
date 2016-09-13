<?php
    namespace frontend\models;
    use Yii;
    use yii\base\Model;

    class ServiceCallModel extends Model{
        public $phone;

        public function rules(){
            return [
                ['phone', 'required'],
                ['phone', 'match', 'pattern' => '/^\+?[78]{1}\d{10}$/i','message' => 'Не правильный формат телефона +7(8) 000 000 00 00'],
            ];
        }

        public function sendMail(){
            $body = "Телефон отправителя: ".$this->phone."\n\rДата запроса: ".date("d m Y H:i")."Запрос звонка по поводу услуг";
            Yii::$app->mailer->compose()
                             ->setFrom(Yii::$app->params['robotEmail'])
                             ->setTo(Yii::$app->params['adminEmail'])
                             ->setSubject("Услуги")
                             ->setTextBody($body)
                             ->setHtmlBody($body)
                             ->send();
        }
    }
