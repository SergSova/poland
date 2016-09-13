<?php
    namespace frontend\models;

    use yii\base\Model;

    class RequestRealtyCall extends Model{
        public $phone;
        public $name;

        public function rules(){
            return [
                [['name', 'phone'], 'required'],
                ['phone', 'match', 'pattern' => '/^\+?[78]{1}\d{10}$/i','message' => 'Не правильный формат телефона +7(8) 000 000 00 00'],
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