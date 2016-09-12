<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nad_feedback".
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $body
 */
class Feedback extends \yii\db\ActiveRecord
{
    public $successMessage;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nad_feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'subject', 'body'], 'required'],
            [['body'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 150],
            [['subject'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
