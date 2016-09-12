<?php
    namespace frontend\models;

    use yii\base\Model;

    class RequestRealtyCall extends Model{
        public $phone;
        public $name;

        public function rules(){
            return [
                [['name', 'phone'], 'required'],
                ['phone', 'match', 'pattern' => '/^8{1}\d{10}$/i'],
            ];
        }

        public function attributeLabels()
        {
            return [
                'name' => 'Ваше имя',
                'phone' => 'Ваш телефон'
            ];
        }
    }