<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FeedbackModel extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $successMessage;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'subject', 'body'], 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'Ваш Email',
            'subject' => 'Тема',
            'body' => 'Сообщение',
        ];
    }
    public function sendMail(){
        $body = "Имя отправителя: ".$this->name."\nEmail отправителя: ".$this->email."\rДата запроса: ".date("d m Y H:i")."\r\n".$this->body;
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
