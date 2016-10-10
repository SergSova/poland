<?php

    namespace common\models;

    use Yii;
    use yii\base\Behavior;
    use yii\caching\DbDependency;
    use yii\web\UploadedFile;

    class ActionBehavior extends Behavior{
        public $dateS;
        public $dateE;

        public function afterFind(){
            $this->dateS = date('m/d/Y', $this->owner->date_start);
            $this->dateE = date('m/d/Y', $this->owner->date_end);

            if($this->owner->date_end <= time() && $this->owner->status == 'active'){
                $this->owner->status = 'inactive';
                if($this->owner->save(false)){
                    Yii::$app->session->addFlash('info', 'акция '.$this->owner->title.' закончилась');
                }
            }
        }

        public function beforeSave($insert){
            $this->owner->date_start = strtotime($this->dateS);
            $this->owner->date_end = strtotime($this->dateE);

            if($this->owner->name == 'discount'){
                $this->owner->value = '{"attr":"price","discount":'.$this->owner->value.'}';
            }

            if(!empty($_FILES) && $file = UploadedFile::getInstance($this->owner, 'icon')){
                $basePath = Yii::getAlias('@wwwRoot');
                $fileName = 'img/'.$file->name;
                if(!file_exists($basePath.DIRECTORY_SEPARATOR.$fileName)){
                    $file->saveAs($basePath.DIRECTORY_SEPARATOR.$fileName);
                }
                $this->owner->icon = $fileName;
            }

            return $this->owner->beforeSave($insert);
        }

        /**
         * @return string generate full URL path to icon
         */
        public function getImgPath(){
            return Yii::getAlias('@wwwUrl').DIRECTORY_SEPARATOR.$this->owner->icon;
        }

        /**
         * @return mixed Return caching data
         */
        public static function getAll(){
            return self::getDb()
                       ->cache(function(){
                           return self::find()
                                      ->all();
                       }, 3600 * 24 * 30, new DbDependency(['sql' => 'SELECT MAX(update_at) FROM '.self::tableName()]));
        }
    }