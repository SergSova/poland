<?php
    namespace backend\models;

    use backend\components\RealtyPhoto;
    use yii\base\Model;

    class UploadModel extends Model{
        public $photo;
        public $result;

        public function rules(){
            return [
                ['photo', 'file', 'skipOnEmpty'=> true, 'extensions' => 'png, jpg','maxSize' => 1024*1024]
            ];
        }

        public function upload(){
            if($this->validate()){
                $this->result = RealtyPhoto::uploadPhoto($this->photo);
                return true;
            }
            return false;
        }
    }