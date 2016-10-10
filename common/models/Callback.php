<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%callback}}".
 *
 * @property string $id
 * @property string $name
 * @property string $subject
 * @property string $phone
 */
class Callback extends \yii\db\ActiveRecord
{
    public $successMessage;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%callback}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'subject', 'phone'], 'required'],
            [['name', 'subject'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 25],
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
            'subject' => 'Тема',
            'phone' => 'Ваш телефон',
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
