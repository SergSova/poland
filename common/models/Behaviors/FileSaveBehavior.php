<?php

    namespace common\models\Behaviors;

    use Yii;
    use yii\base\Behavior;
    use yii\db\ActiveRecord;
    use yii\web\UploadedFile;

    class FileSaveBehavior extends Behavior{
        public $inputAttribute  = 'icon';
        public $outputAttribute = 'icon';

        public function events(){
            return [
                ActiveRecord::EVENT_BEFORE_INSERT => 'onBeforeSave',
                ActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave',
            ];
        }

        public function onBeforeSave(){
            if(!empty($_FILES) && $file = UploadedFile::getInstance($this->owner, $this->inputAttribute)){
                $basePath = Yii::getAlias('@wwwRoot');
                $owner_name = substr($this->owner->tableName(), strpos($this->owner->tableName(), '%') + 1);
                $owner_name = substr($owner_name, 0, strpos($owner_name, '}'));
                $fileName = 'img/'.$owner_name.'_'.$file->name;
                if(!file_exists($basePath.DIRECTORY_SEPARATOR.$fileName)){
                    $file->saveAs($basePath.DIRECTORY_SEPARATOR.$fileName);
                }
                $this->owner->{$this->outputAttribute} = $fileName;
            }
        }

        /**
         * @return string generate full URL path to icon
         */
        public function getImgPath(){
            return Yii::$app->params['wwwUrl'].DIRECTORY_SEPARATOR.$this->owner->icon;
        }
    }