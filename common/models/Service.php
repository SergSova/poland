<?php

    namespace common\models;

    use Yii;
    use yii\web\UploadedFile;

    /**
     * This is the model class for table "nad_service".
     *
     * @property integer $id
     * @property string  $title
     * @property string  $short_description
     * @property string  $full_description
     * @property string  $icon
     */
    class Service extends \yii\db\ActiveRecord{
        /**
         * @inheritdoc
         */
        public static function tableName(){
            return 'nad_service';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'title',
                        'short_description',
                        'full_description'
                    ],
                    'required'
                ],
                [
                    [
                        'short_description',
                        'full_description'
                    ],
                    'string'
                ],
                [
                    [
                        'title',
                        'icon'
                    ],
                    'string',
                    'max' => 255
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id' => 'ID',
                'title' => 'Название',
                'short_description' => 'Краткое описание',
                'full_description' => 'Полное описание',
                'icon' => 'Icon',
            ];
        }

        public function beforeSave($insert){
            if(isset($_FILES) && $this->icon = UploadedFile::getInstance($this, 'icon')){
                if(!is_dir(Yii::getAlias('@storage').DIRECTORY_SEPARATOR.'service')){
                    mkdir(Yii::getAlias('@storage').DIRECTORY_SEPARATOR.'service', 0777, true);
                }
                $filename = 'service'.DIRECTORY_SEPARATOR.$this->icon->baseName.'.'.$this->icon->extension;
                if($this->icon->saveAs(Yii::getAlias('@storage').DIRECTORY_SEPARATOR.$filename)){
                    $this->icon = $filename;
                }
            }

            return parent::beforeSave($insert);
        }


    }
