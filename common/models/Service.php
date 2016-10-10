<?php

    namespace common\models;

    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\caching\DbDependency;
    use yii\web\UploadedFile;

    /**
     * This is the model class for table "{{%service}}".
     *
     * @property integer $id
     * @property string  $title
     * @property string  $description
     * @property string  $icon
     * @property string  $create_at
     * @property string  $update_at
     */
    class Service extends \yii\db\ActiveRecord{
        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%service}}';
        }

        public function behaviors(){
            return [
                [
                    'class' => TimestampBehavior::className(),
                    'createdAtAttribute' => 'create_at',
                    'updatedAtAttribute' => 'update_at',
                    'value' => time(),
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'title',
                        'description'
                    ],
                    'required'
                ],
                [
                    ['description'],
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
                'description' => 'Описание',
                'icon' => 'Icon',
            ];
        }

        public function scenarios(){
            return [
                'default' => [
                    'title',
                    'description'
                ]
            ];
        }

        public function beforeSave($insert){
            if(!empty($_FILES) && $icon = UploadedFile::getInstance($this, 'icon')){
                if(!is_dir(Yii::getAlias('@storage').DIRECTORY_SEPARATOR.'service')){
                    mkdir(Yii::getAlias('@storage').DIRECTORY_SEPARATOR.'service', 0777, true);
                }
                $filename = 'service'.DIRECTORY_SEPARATOR.$icon->name;
                if(!file_exists(Yii::getAlias('@storage').DIRECTORY_SEPARATOR.$filename)){
                    $icon->saveAs(Yii::getAlias('@storage').DIRECTORY_SEPARATOR.$filename);
                }
                $this->icon = $filename;
            }

            return parent::beforeSave($insert);
        }

        public function getImgPath(){
            return Yii::getAlias('@storageUrl').DIRECTORY_SEPARATOR.$this->icon;
        }

        public static function getAll(){
            return self::getDb()
                       ->cache(function(){
                           return self::find()
                                      ->all();
                       }, 3600 * 24 * 30, new DbDependency(['sql' => 'SELECT MAX(update_at) FROM '.self::tableName()]));
        }
    }
