<?php
    namespace frontend\models;

    use yii\base\Model;

    class RequestRealtyEmail extends Model{
        public $name;
        public $email;
        public $body;


        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [['name', 'email', 'body'], 'required'],
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
                'body' => 'Сообщение',
            ];
        }
    }